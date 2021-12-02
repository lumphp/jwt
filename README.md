
JSON Web Token
=======
A simple library to encode and decode JSON Web Tokens (JWT) in PHP, conforming to [RFC 7519](https://tools.ietf.org/html/rfc7519).

Installation
------------

Use composer :

```bash
composer require lumphp/jwt
```

Example
-------

```php
<?php
/**
 * Created by PhpStorm.
 *
 * @author rustysun
 */
require_once(__DIR__.'/vendor/autoload.php');

use Lum\Jose\JWTUtil;
use Lum\Jose\JWTConfig;
use Lum\Jose\Payload;
use Lum\Jose\RegisterNames;

$config = new JWTConfig('http://example.org', 'http://example.com', 0, 1357000100);
$key = "example_中国_key";
$payload = (new Payload($config))
    ->setClaim(RegisterNames::ISSUED_AT, 1356999524)
    ->setClaim(RegisterNames::NOT_BEFORE,1357000000);
$jwt = new JWTUtil($config);

//HS256
$hs256 = new \Lum\Jose\Algorithms\HS256;
$encoded = $jwt->encode($payload, $key, $hs256);
echo "\nHS256 Encode:\n", $encoded, "\n";
$decoded = $jwt->decode($encoded, $key);
echo "HS256 Decode:\n", print_r($decoded, true), "\n";

//EdDSA
//$keyPair = sodium_crypto_sign_keypair();
$keyPair = base64_decode(
    "NCwmkhZ1nFfH/6k/3buC+P/LcJzeAfwl0RMitX6fQUJ/3v9mJGkzzYK1lHj90e+QUttA40P+hoAiABK/1ikRbn/e/2YkaTPNgrWUeP3R75BS20DjQ/6GgCIAEr/WKRFu"
);
$algorithm = new \Lum\Jose\Algorithms\ED25519;
$encoded = $jwt->encode($payload, $keyPair, $algorithm);
echo "\nED25519 Encode:\n", $encoded, "\n";
$decoded = $jwt->decode($encoded, $keyPair);
echo "ED25519 Decode:\n", print_r($decoded, true), "\n";


$privateKey = <<<EOD
-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQC8kGa1pSjbSYZVebtTRBLxBz5H4i2p/llLCrEeQhta5kaQu/Rn
vuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t0tyazyZ8JXw+KgXTxldMPEL9
5+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4ehde/zUxo6UvS7UrBQIDAQAB
AoGAb/MXV46XxCFRxNuB8LyAtmLDgi/xRnTAlMHjSACddwkyKem8//8eZtw9fzxz
bWZ/1/doQOuHBGYZU8aDzzj59FZ78dyzNFoF91hbvZKkg+6wGyd/LrGVEB+Xre0J
Nil0GReM2AHDNZUYRv+HYJPIOrB0CRczLQsgFJ8K6aAD6F0CQQDzbpjYdx10qgK1
cP59UHiHjPZYC0loEsk7s+hUmT3QHerAQJMZWC11Qrn2N+ybwwNblDKv+s5qgMQ5
5tNoQ9IfAkEAxkyffU6ythpg/H0Ixe1I2rd0GbF05biIzO/i77Det3n4YsJVlDck
ZkcvY3SK2iRIL4c9yY6hlIhs+K9wXTtGWwJBAO9Dskl48mO7woPR9uD22jDpNSwe
k90OMepTjzSvlhjbfuPN1IdhqvSJTDychRwn1kIJ7LQZgQ8fVz9OCFZ/6qMCQGOb
qaGwHmUK6xzpUbbacnYrIM6nLSkXgOAwv7XXCojvY614ILTK3iXiLBOxPu5Eu13k
eUz9sHyD6vkgZzjtxXECQAkp4Xerf5TGfQXGXhxIX52yH+N2LtujCdkQZjXAsGdm
B2zNzvrlgRmgBrklMTrMYgm1NPcW+bRLGcwgW2PTvNM=
-----END RSA PRIVATE KEY-----
EOD;
$publicKey = <<<EOD
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC8kGa1pSjbSYZVebtTRBLxBz5H
4i2p/llLCrEeQhta5kaQu/RnvuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t
0tyazyZ8JXw+KgXTxldMPEL95+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4
ehde/zUxo6UvS7UrBQIDAQAB
-----END PUBLIC KEY-----
EOD;
$payload = [
    "iss" => "example.org",
    "aud" => "example.com",
    "iat" => 1356999524,
    "nbf" => 1357000000,
];
$alg = new \Lum\Jose\Algorithms\RS256;
$encoded = $jwt->encode($payload, $privateKey, $alg);
echo "RSA256 Encode:\n".print_r($encoded, true)."\n";
$decoded = $jwt->decode($encoded, $publicKey);
$decoded_array = (array)$decoded;
echo "RSA256 Decode:\n".print_r($decoded_array, true)."\n";

//ES256
$privateKey=<<<KEY
-----BEGIN EC PARAMETERS-----
BgUrgQQACg==
-----END EC PARAMETERS-----
-----BEGIN EC PRIVATE KEY-----
MHQCAQEEIODvZuS34wFbt0X53+P5EnSj6tMjfVK01dD1dgDH02RzoAcGBSuBBAAK
oUQDQgAE/nvHu/SQQaos9TUljQsUuKI15Zr5SabPrbwtbfT/408rkVVzq8vAisbB
RmpeRREXj5aog/Mq8RrdYy75W9q/Ig==
-----END EC PRIVATE KEY-----
KEY;
$publicKey=<<<KEY
-----BEGIN PUBLIC KEY-----
MFYwEAYHKoZIzj0CAQYFK4EEAAoDQgAE/nvHu/SQQaos9TUljQsUuKI15Zr5SabP
rbwtbfT/408rkVVzq8vAisbBRmpeRREXj5aog/Mq8RrdYy75W9q/Ig==
-----END PUBLIC KEY-----
KEY;

$payload = [
    "iss" => "example.org",
    "aud" => "example.com",
    "iat" => 1356999524,
    "nbf" => 1357000000,
];
$alg = new \Lum\Jose\Algorithms\ES256;
$encoded = $jwt->encode($payload, $privateKey, $alg);
echo "ES256 Encode:\n".print_r($encoded, true)."\n";
$decoded = $jwt->decode($encoded, $publicKey);
$decoded_array = (array)$decoded;
echo "ES256 Decode:\n".print_r($decoded_array, true)."\n";
```

License
-------
[MIT](https://opensource.org/licenses/MIT).
