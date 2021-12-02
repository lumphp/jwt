<?php
namespace Lum\Jose;

use DateTime;
use InvalidArgumentException;
use Lum\Codec\CodecUtil;
use Lum\Jose\Algorithms\Algorithm;
use Lum\Jose\Exceptions\BeforeValidException;
use Lum\Jose\Exceptions\ExpiredException;
use Lum\Jose\Signers\HmacSigner;
use OpenSSLAsymmetricKey;
use UnexpectedValueException;

class JWTUtil
{
    private static JWTConfig $config;

    public function __construct(JWTConfig $config)
    {
        self::$config = $config;
    }

    /**
     * Decodes a JWTUtil string into a PHP object.
     *
     * @param string $jwt The JWTUtil
     * @param string $key
     *
     * @return object The JWTUtil's payload as a PHP object
     * @throws \Lum\Codec\CodecException
     */
    public function decode(string $jwt, string $key) : object
    {
        $timestamp = empty(static::$config->getTimestamp()) ? time() : static::$config->getTimestamp();
        if (!$key) {
            throw new InvalidArgumentException('Key may not be empty');
        }
        $tokenInfo = array_filter(explode('.', $jwt));
        if (count($tokenInfo) != 3) {
            throw new UnexpectedValueException('Wrong number of segments');
        }
        $header = CodecUtil::decode(CodecUtil::JWT, $tokenInfo[0]);
        $payload = CodecUtil::decode(CodecUtil::JWT, $tokenInfo[1]);
        $sig = CodecUtil::decode(CodecUtil::URL_BASE64, $tokenInfo[2]);
        if (!$header || !$payload || !$sig) {
            throw new UnexpectedValueException('Invalid JWT encoding');
        }
        if (empty($header->alg) || false === in_array($header->alg, JWA::SUPPORTED)) {
            throw new UnexpectedValueException(sprintf('Not supported algorithm of "%s"', $header->alg));
        }
        $kid = empty($header->kid) ? null : $header->kid;
        if ($kid && !HmacSigner::constantTimeEquals($kid, $header->alg)) {
            throw new UnexpectedValueException('Incorrect key for this algorithm');
        }
        $algClassName = sprintf('\\Lum\\Jose\\Algorithms\\%s', strtoupper($header->alg));
        $alg = new $algClassName;
        if ($header->alg === JWA::ES256 || $header->alg === JWA::ES384) {
            $sig = CodecUtil::encode(CodecUtil::ASN1DER, $sig, ['keySize' => $alg->getKeyLength()]);
        }
        if (!JWS::verify(sprintf("%s.%s", $tokenInfo[0], $tokenInfo[1]), $sig, $key, $alg)) {
            throw new SignatureInvalidException('Signature verification failed');
        }
        if (isset($payload->nbf) && $payload->nbf > ($timestamp + static::$config->getLeewayTime())) {
            throw new BeforeValidException(
                'Cannot handle token prior to '.date(DateTime::ISO8601, $payload->nbf)
            );
        }
        if (isset($payload->iat) && $payload->iat > ($timestamp + static::$config->getLeewayTime())) {
            throw new BeforeValidException(
                'Cannot handle token prior to '.date(DateTime::ISO8601, $payload->iat)
            );
        }
        if (isset($payload->exp) && ($timestamp - static::$config->getLeewayTime()) >= $payload->exp) {
            throw new ExpiredException('Expired token');
        }

        return $payload;
    }

    /**
     * @param $payload
     * @param string $key
     * @param Algorithm $alg
     * @param array|null $head
     *
     * @return string
     * @throws \Lum\Codec\CodecException
     */
    public function encode($payload, string $key, Algorithm $alg, ?array $head = null) : string
    {
        $algName = $alg->getName();
        $header = ['typ' => 'JWT', 'alg' => $algName];
        if (null !== $head && is_array($head)) {
            $header = array_merge($head, $header);
        }
        $result = sprintf(
            '%s.%s',
            CodecUtil::encode(CodecUtil::JWT, $header),
            CodecUtil::encode(CodecUtil::JWT, $payload)
        );
        $signature = JWS::sign($result, $key, $alg);
        if ($algName === JWA::ES256 || $algName === JWA::ES384) {
            $signature = CodecUtil::decode(
                CodecUtil::ASN1DER,
                $signature,
                ['keySize' => $alg->getKeyLength()]
            );
        }

        return sprintf('%s.%s', $result, CodecUtil::encode(CodecUtil::URL_BASE64, $signature));
    }
}
