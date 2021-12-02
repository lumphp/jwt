<?php
namespace Lum\Jose\Algorithms;

use Lum\Jose\JWA;
use Lum\Jose\Signers\OpenSSLSigner;

/**
 * EcDsa SHA-512
 */
class ES512 implements Algorithm
{
    /**
     * @return string
     */
    public function getName() : string
    {
        return JWA::ES512;
    }

    public function getOptions() : array
    {
        return ['openssl', 'SHA512'];
    }

    /**
     * @return OpenSSLSigner
     */
    public function getSigner() : OpenSSLSigner
    {
        return new OpenSSLSigner(OPENSSL_KEYTYPE_EC, OPENSSL_ALGO_SHA512);
    }
}
