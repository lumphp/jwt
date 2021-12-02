<?php
namespace Lum\Jose;

/**
 * Json Web Algorithm
 */
interface JWA
{
    const RSA = 'RSA';
    //for JWS
    const HS256 = 'HS256';
    const HS384 = 'HS384';
    const HS512 = 'HS512';
    const RS256 = 'RS256';
    const RS384 = 'RS384';
    const RS512 = 'RS512';
    const ES256 = 'ES256';
    const ES384 = 'ES384';
    const ES512 = 'ES512';
    //const PS256 = 'PS256';
    //const PS384 = 'PS384';
    //const PS512 = 'PS512';
    const ED25519 = 'ED25519';
    const SUPPORTED = [
        self::HS256,self::HS384,self::HS512,
        self::RS256,self::RS384,self::RS512,
        self::ES256,self::ES384,self::ES512,
        self::ED25519
    ];
    //const NONE = 'none'; //not security,DO NOT USE
    ////for JWE
    //const RSA1_5 = 'RSA1_5';
    //const RSA_OAEP = 'RSA-OAEP';//RSAES OAEP using default parameters
    //const RSA_OAEP_256 = 'RSA-OAEP-256';//RSAES OAEP using SHA-256 and MGF1 with SHA-256
    //const A128KW = 'A128KW';
    //const A192KW = 'A192KW';
    //const A256KW = 'A256KW';
    //const DIR = 'dir';
    //const ECDH_ES = 'ECDH-ES';//epk apu apv
    //const ECDH_ES_A128KW = 'ECDH-ES+A128KW';//epk apu apv
    //const ECDH_ES_A192KW = 'ECDH-ES+A192KW';//epk apu apv
    //const ECDH_ES_A256KW = 'ECDH-ES+A256KW';//epk apu apv
    ////AES Key Wrap with default initial value using 128,192,256 bits
    //const A128GCMKW = 'A128GCMKW'; //iv tag
    //const A192GCMKW = 'A192GCMKW';//iv tag
    //const A256GCMKW = 'A256GCMKW';//iv tag
    //const PBES2_HS256_A128KW = 'PBES2-HS256+A128KW';//p2s p2c
    //const PBES2_HS256_A192KW = 'PBES2-HS256+A192KW';//p2s p2c
    //const PBES2_HS256_A256KW = 'PBES2-HS256+A256KW';//p2s p2c
}