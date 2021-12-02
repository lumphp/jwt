<?php
namespace Lum\Jose\Algorithms;

use Lum\Jose\JWA;
use Lum\Jose\Signers\OpenSSLSigner;

/**
 *  EcDsa SHA-256
 */
class ES256 implements Algorithm
{
    /**
     * @return string
     */
    public function getName() : string
    {
        return JWA::ES256;
    }

    public function getOptions() : array
    {
        return ['openssl', 'SHA256'];
    }

    /**
     * @return int
     */
    public function getKeyLength() : int
    {
        return 64;
    }

    /**
     * @return OpenSSLSigner
     */
    public function getSigner() : OpenSSLSigner
    {
        return new OpenSSLSigner(OPENSSL_KEYTYPE_EC, OPENSSL_ALGO_SHA256);
    }
}
