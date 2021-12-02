<?php
namespace Lum\Jose;

use JsonSerializable;

class JoseHeader implements JsonSerializable
{
    private array $header;

    public function __construct(string $alg = 'HS256', string $typ = 'JWT')
    {
        $this->header = [
            'alg' => $alg,
            'typ' => $typ,
        ];
    }

    public function jsonSerialize() : array
    {
        return $this->header;
    }
}