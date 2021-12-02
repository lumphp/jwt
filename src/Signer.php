<?php
namespace Lum\Jose;

/**
 * interface Signer
 */
interface Signer
{
    /**
     * @param string $payload
     * @param string $key
     * @param string $passphrase
     *
     * @return string
     */
    public function createSign(string $payload, string $key, string $passphrase = '') : string;

    /**
     * @param string $signature
     * @param string $payload
     * @param string $key
     * @param string $passphrase
     *
     * @return bool
     */
    public function verify(string $signature, string $payload, string $key, string $passphrase = '') : bool;
}