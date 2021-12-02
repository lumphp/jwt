<?php
namespace Lum\Jose\Signatures;

use Lum\Jose\Exceptions\ConversionFailed;

/**
 * ECDSA signature converter using ext-mbstring
 */
final class ECDsaUtil
{
    const ASN1_SEQUENCE = '30';
    const ASN1_INTEGER = '02';
    const ASN1_MAX_SINGLE_BYTE = 128;
    const ASN1_LENGTH_2BYTES = '81';
    const ASN1_BIG_INTEGER_LIMIT = '7f';
    const ASN1_NEGATIVE_INTEGER = '00';
    const BYTE_SIZE = 2;

    /**
     * @param $signature
     * @param $length
     *
     * @return false|string
     */
    public static function fromAsn1($signature, $length)
    {
        $message = bin2hex($signature);
        $position = 0;
        if (self::readAsn1Content($message, $position, self::BYTE_SIZE) !== self::ASN1_SEQUENCE) {
            throw new ConversionFailed('Invalid data. Should start with a sequence.');
        }
        if (self::readAsn1Content($message, $position, self::BYTE_SIZE) === self::ASN1_LENGTH_2BYTES) {
            $position += self::BYTE_SIZE;
        }
        $pointR = self::retrievePositiveInteger(self::readAsn1Integer($message, $position));
        $pointS = self::retrievePositiveInteger(self::readAsn1Integer($message, $position));
        $points = hex2bin(
            str_pad($pointR, $length, '0', STR_PAD_LEFT).str_pad($pointS, $length, '0', STR_PAD_LEFT)
        );

        return $points;
    }

    /**
     * @param $signature
     * @param $length
     *
     * @return false|string
     */
    public static function toAsn1($signature, $length)
    {
        $signature = bin2hex($signature);
        if (self::octetLength($signature) !== $length) {
            throw ConversionFailed::invalidLength();
        }
        $pointR = self::preparePositiveInteger(mb_substr($signature, 0, $length, '8bit'));
        $pointS = self::preparePositiveInteger(mb_substr($signature, $length, null, '8bit'));
        $lengthR = self::octetLength($pointR);
        $lengthS = self::octetLength($pointS);
        $totalLength = $lengthR + $lengthS + self::BYTE_SIZE + self::BYTE_SIZE;
        $lengthPrefix = $totalLength > self::ASN1_MAX_SINGLE_BYTE ? self::ASN1_LENGTH_2BYTES : '';
        $asn1 = hex2bin(
            self::ASN1_SEQUENCE.$lengthPrefix.dechex($totalLength).self::ASN1_INTEGER.dechex($lengthR).
            $pointR.self::ASN1_INTEGER.dechex($lengthS).$pointS
        );

        return $asn1;
    }

    /**
     * @param $data
     *
     * @return int
     */
    private static function octetLength($data)
    {
        return (int)(mb_strlen($data, '8bit') / self::BYTE_SIZE);
    }

    /**
     * @param $data
     *
     * @return mixed|string
     */
    private static function preparePositiveInteger($data)
    {
        if (mb_substr($data, 0, self::BYTE_SIZE, '8bit') > self::ASN1_BIG_INTEGER_LIMIT) {
            return self::ASN1_NEGATIVE_INTEGER.$data;
        }
        while (mb_substr($data, 0, self::BYTE_SIZE, '8bit') === self::ASN1_NEGATIVE_INTEGER &&
            mb_substr($data, 2, self::BYTE_SIZE, '8bit') <= self::ASN1_BIG_INTEGER_LIMIT) {
            $data = mb_substr($data, 2, null, '8bit');
        }

        return $data;
    }

    /**
     * @param $message
     * @param $position
     * @param $length
     *
     * @return string
     */
    private static function readAsn1Content($message, &$position, $length)
    {
        $content = mb_substr($message, $position, $length, '8bit');
        $position += $length;

        return $content;
    }

    /**
     * @param $message
     * @param $position
     *
     * @return string
     */
    private static function readAsn1Integer($message, &$position)
    {
        if (self::readAsn1Content($message, $position, self::BYTE_SIZE) !== self::ASN1_INTEGER) {
            throw new ConversionFailed('Invalid data. Should contain an integer.');
        }
        $length = (int)hexdec(self::readAsn1Content($message, $position, self::BYTE_SIZE));

        return self::readAsn1Content($message, $position, $length * self::BYTE_SIZE);
    }

    /**
     * @param $data
     *
     * @return mixed|string
     */
    private static function retrievePositiveInteger($data)
    {
        while (mb_substr($data, 0, self::BYTE_SIZE, '8bit') === self::ASN1_NEGATIVE_INTEGER &&
            mb_substr($data, 2, self::BYTE_SIZE, '8bit') > self::ASN1_BIG_INTEGER_LIMIT) {
            $data = mb_substr($data, 2, null, '8bit');
        }

        return $data;
    }
}
