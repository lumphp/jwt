<?php
namespace Lum\Jose\Signers;

use InvalidArgumentException;
use Lum\Jose\Algorithms\Algorithm;
use Lum\Jose\Signer;

/**
 *
 */
class EcDSASigner implements Signer
{
    /**
     * @var Algorithm $algorithm
     */
    private $algorithm;
    private const KEY_TYPE = OPENSSL_KEYTYPE_EC;

    /**
     * @param Algorithm $algorithm
     */
    public function __construct(Algorithm $algorithm)
    {
        $this->algorithm = $algorithm;
    }

    /**
     * @param string $payload
     * @param KeyUtil $key
     *
     * @return false|string
     * @throws \Exception
     */
    public function createSign(string $payload, $key) : string
    {
        $key = $this->getPrivateKey($pem, $passphrase);
        try {
            $signature = '';
            if (!openssl_sign($payload, $signature, $key, $this->algorithm->getAlgorithm())) {
                throw new InvalidArgumentException(
                    'There was an error while creating the signature: '.openssl_error_string()
                );
            }

            return $signature;
        } finally {
            openssl_free_key($key);
        }
    }

    /**
     * @param string $expected
     * @param string $payload
     * @param null|KeyUtil $keyUtil
     *
     * @return bool
     */
    public function verify(string $expected, string $payload, $keyUtil) : bool
    {
        return $this->verify(
            $expected,
            $payload,
            $keyUtil
        );
    }
}
