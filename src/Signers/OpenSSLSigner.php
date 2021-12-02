<?php
namespace Lum\Jose\Signers;

use Closure;
use DomainException;
use Exception;
use Lum\Codec\CodecUtil;
use Lum\Jose\Signer;

/**
 * class OpenSSLSigner
 */
class OpenSSLSigner implements Signer
{
    private int $algorithm;
    private int $keyType;

    /**
     * @param int $keyType
     * @param int $signatureAlgorithm
     * @param Closure|null $callback
     */
    public function __construct(int $keyType, int $signatureAlgorithm)
    {
        $this->keyType = $keyType;
        $this->algorithm = $signatureAlgorithm;
    }

    /**
     * @param string $payload
     * @param string $key
     * @param string $passphrase
     *
     * @return string
     */
    public function createSign(string $payload, string $key, string $passphrase = '') : string
    {
        try {
            return CodecUtil::encode(CodecUtil::OPENSSL, $payload, [
                'keyType' => $this->keyType,
                'signatureAlgorithm' => $this->algorithm,
                'key' => $key,
                'passphrase' => $passphrase,
            ]);
        } catch (Exception $e) {
            throw new DomainException($e->getMessage(), 0, $e);
        }
    }

    /**
     * @param string $signature
     * @param string $payload
     * @param string $key
     * @param string $passphrase
     *
     * @return bool
     */
    public function verify(string $signature, string $payload, string $key, string $passphrase = '') : bool
    {
        try {
            return CodecUtil::verify(CodecUtil::OPENSSL, $payload, [
                'keyType' => $this->keyType,
                'signatureAlgorithm' => $this->algorithm,
                'certificate' => $key,
                'passphrase' => $passphrase,
                'signature' => $signature,
            ]);
        } catch (Exception $e) {
            throw new DomainException($e->getMessage(), 0, $e);
        }
    }
}
