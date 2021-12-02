<?php
namespace Lum\Jose;

use DomainException;
use Lum\Jose\Algorithms\Algorithm;

/**
 * @see rfc7515
 */
class JWS
{
    /**
     * Sign a string with a given key and algorithm.
     *
     * @param string $msg The message to sign
     * @param string|resource $key The secret key
     * @param Algorithm $alg The signing algorithm
     *
     * @return string An encrypted message
     * @throws DomainException Unsupported algorithm or bad key was specified
     */
    public static function sign(string $msg, string $key, Algorithm $alg) : string
    {
        $signer = $alg->getSigner();

        return $signer->createSign($msg, $key);
    }

    /**
     * Verify a signature with the message, key and method. Not all methods
     * are symmetric, so we must have a separate verify and sign method.
     *
     * @param string $msg The original message (header and body)
     * @param string $signature The original signature
     * @param string $key For HS*, a string key works. for RS*, must be a resource of an openssl public key
     * @param Algorithm $alg The algorithm
     *
     * @return bool
     * @throws DomainException Invalid Algorithm, bad key, or OpenSSL failure
     */
    public static function verify(string $msg, string $signature, string $key, Algorithm $alg) : bool
    {
        $signer = $alg->getSigner();

        return $signer->verify($signature, $msg, $key);
    }
}