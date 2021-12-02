<?php
namespace Lum\Jose\Algorithms;

use Lum\Jose\JWA;
use Lum\Jose\Signers\HmacSigner;

/**
 * HMAC SHA-384
 */
class HS384 implements Algorithm
{
    /**
     * @return string
     */
    public function getName() : string
    {
        return JWA::HS384;
    }

    /**
     * @return HmacSigner
     */
    public function getSigner() : HmacSigner
    {
        return new HmacSigner('SHA384');
    }
}
