<?php
namespace Lum\Jose\Algorithms;

use Lum\Jose\JWA;
use Lum\Jose\Signers\HmacSigner;

/**
 * HMAC SHA-256
 */
class HS256 implements Algorithm
{
    /**
     * @return string
     */
    public function getName() : string
    {
        return JWA::HS256;
    }

    /**
     * @return HmacSigner
     */
    public function getSigner() : HmacSigner
    {
        return new HmacSigner('SHA256');
    }
}
