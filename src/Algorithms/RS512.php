<?php
namespace Lum\Jose\Algorithms;

use Lum\Jose\JWA;
use Lum\Jose\Signers\OpenSSLSigner;

/**
 * RSA SHA-512
 */
class RS512 implements Algorithm
{
    /**
     * @return string
     */
    public function getName() : string
    {
        return JWA::RS512;
    }

    public function getOptions() : array
    {
        return ['openssl', 'SHA256', OPENSSL_ALGO_SHA512];
    }

    /**
     * @return OpenSSLSigner
     */
    public function getSigner() : OpenSSLSigner
    {
        return new OpenSSLSigner( OPENSSL_KEYTYPE_RSA, OPENSSL_ALGO_SHA512);
    }
}
