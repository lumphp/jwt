<?php
namespace Lum\Jose\Algorithms;

use Lum\Jose\JWA;
use Lum\Jose\Signers\OpenSSLSigner;

/**
 * EcDsa SHA-384
 */
class ES384 implements Algorithm
{
    /**
     * @return string
     */
    public function getName() : string
    {
        return JWA::ES384;
    }

    public function getOptions() : array
    {
        return ['openssl', 'SHA384'];
    }

    /**
     * @return int
     */
    public function getKeyLength() : int
    {
        return 96;
    }

    /**
     * @return OpenSSLSigner
     */
    public function getSigner() : OpenSSLSigner
    {
        return new OpenSSLSigner(OPENSSL_KEYTYPE_EC, OPENSSL_ALGO_SHA384);
    }
}