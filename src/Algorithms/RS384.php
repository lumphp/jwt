<?php
namespace Lum\Jose\Algorithms;

use Lum\Jose\JWA;
use Lum\Jose\Signers\OpenSSLSigner;

/**
 * RSA SHA-384
 */
class RS384 implements Algorithm
{
    /**
     * @return string
     */
    public function getName() : string
    {
        return JWA::RS384;
    }

    /**
     * @return OpenSSLSigner
     */
    public function getSigner() : OpenSSLSigner
    {
        return new OpenSSLSigner(OPENSSL_KEYTYPE_RSA, OPENSSL_ALGO_SHA384);
    }
}
