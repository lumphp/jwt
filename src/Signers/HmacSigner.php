<?php
namespace Lum\Jose\Signers;

use Lum\Jose\Algorithms\Algorithm;
use Lum\Jose\Signer;

/**
 * hmac signer
 */
class HmacSigner implements Signer
{
    /**
     * @var Algorithm $algorithm
     */
    private $algo;

    /**
     * @param string $algorithm
     */
    public function __construct(string $algorithm)
    {
        $this->algo = $algorithm;
    }

    /**
     * @param string $payload
     * @param string $key
     * @param string $passphrase
     *
     * @return string
     */
    public function createSign(string $payload, string $key, string $passphrase = '') : string
    {


        return hash_hmac($this->algo, $payload, $key, true);
    }

    /**
     * @param string $signature
     * @param string $payload
     * @param string $key
     * @param string $passphrase
     *
     * @return bool
     */
    public function verify(string $signature, string $payload, string $key, string $passphrase = '') : bool
    {
        $result = $this->createSign($payload, $key);

        return hash_equals($signature, $result);
    }

    /**
     * @param string $left
     * @param string $right
     *
     * @return bool
     */
    public static function constantTimeEquals(string $known_string, string $user_string) : bool
    {
        return hash_equals($known_string, $user_string);
    }
}
