<?php
namespace Lum\Jose\Algorithms;

use Lum\Jose\JWA;
use Lum\Jose\Signers\HmacSigner;

/**
 * HMAC SHA-512
 */
class HS512 implements Algorithm
{
    /**
     * @return string
     */
    public function getName() : string
    {
        return JWA::HS512;
    }

    /**
     * @return HmacSigner
     */
    public function getSigner() : HmacSigner
    {
        return new HmacSigner('SHA512');
    }
}
