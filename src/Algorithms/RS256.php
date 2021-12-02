<?php
namespace Lum\Jose\Algorithms;

use Lum\Jose\JWA;
use Lum\Jose\Signers\OpenSSLSigner;

/**
 * RSA SHA-256
 */
class RS256 implements Algorithm
{
    /**
     * @return string
     */
    public function getName() : string
    {
        return JWA::RS256;
    }

    /**
     * @return OpenSSLSigner
     */
    public function getSigner() : OpenSSLSigner
    {
        return new OpenSSLSigner(OPENSSL_KEYTYPE_RSA, OPENSSL_ALGO_SHA256);
    }
}
