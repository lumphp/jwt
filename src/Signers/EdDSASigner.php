<?php
namespace Lum\Jose\Signers;

use DomainException;
use Exception;
use Lum\Codec\CodecUtil;
use Lum\Jose\Signer;

/**
 * EdDSA signer(ED25519)
 */
class EdDSASigner implements Signer
{
    /**
     * @param string $payload
     * @param string $key
     * @param string $passphrase
     *
     * @return string
     */
    public function createSign(string $payload, string $key, string $passphrase = '') : string
    {
        try {
            return CodecUtil::encode(CodecUtil::ED25519, $payload, [
                'keyPair' => $key,
            ]);
        } catch (Exception $e) {
            throw new DomainException($e->getMessage(), 0, $e);
        }
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
        try {
            return CodecUtil::verify(CodecUtil::ED25519, $payload, [
                'keyPair' => $key,
                'signature' => $signature,
            ]);
        } catch (Exception $e) {
            throw new DomainException($e->getMessage(), 0, $e);
        }
    }
}
