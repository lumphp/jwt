<?php
namespace Lum\Jose\Algorithms;

use Lum\Jose\JWA;
use Lum\Jose\Signers\EdDSASigner;

/**
 *  ED25519
 */
class ED25519 implements Algorithm
{
    /**
     * @return string
     */
    public function getName() : string
    {
        return JWA::ED25519;
    }

    /**
     * @return EdDSASigner
     */
    public function getSigner() : EdDSASigner
    {
        return new EdDSASigner($this);
    }
}
