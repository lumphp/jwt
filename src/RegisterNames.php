<?php
namespace Lum\Jose;

/**
 * register claim names interface
 */
interface RegisterNames
{
    const ISSUER = 'iss';
    const SUBJECT = 'sub';
    const AUDIENCE = 'aud';
    const EXPIRATION = 'exp';
    const NOT_BEFORE = 'nbf';
    const ISSUED_AT = 'iat';
    const JWT_ID = 'jti';
    const ALL = [
        self::ISSUER,
        self::SUBJECT,
        self::AUDIENCE,
        self::EXPIRATION,
        self::NOT_BEFORE,
        self::ISSUED_AT,
        self::JWT_ID,
    ];
}