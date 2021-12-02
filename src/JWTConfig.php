<?php
namespace Lum\Jose;

final class JWTConfig
{
    private string $issuer;
    private string $audience;
    private int $leeway = 0;
    private int $timestamp;

    /**
     * @param string $issuer
     * @param string $audience
     * @param int $leeway
     * @param int|null $timestamp
     */
    public function __construct(string $issuer, string $audience, int $leeway = 0, int $timestamp = 0)
    {
        $this->issuer = $issuer;
        $this->audience = $audience;
        $this->leeway = $leeway;
        $this->timestamp = $timestamp;
    }

    /**
     * @return string
     */
    public function getIssuer() : string
    {
        return $this->issuer;
    }

    /**
     * @return string
     */
    public function getAudience() : string
    {
        return $this->audience;
    }

    /**
     * @return int
     */
    public function getLeewayTime() : int
    {
        return $this->leeway;
    }

    /**
     * @return null|int
     */
    public function getTimestamp() : ?int
    {
        return $this->timestamp;
    }
}