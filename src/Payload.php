<?php
namespace Lum\Jose;

use JsonSerializable;

class Payload implements JsonSerializable
{
    /**
     * @var array $claims
     */
    private array $claims;

    public function __construct(JWTConfig $config)
    {
        $this->claims = [
            RegisterNames::ISSUER => $config->getIssuer(),
            RegisterNames::AUDIENCE => $config->getAudience(),
        ];
    }

    /**
     * @param string $name
     *
     * @return mixed|null
     */
    public function getClaim(string $name)
    {
        return $this->claims[$name] ?? null;
    }

    /**
     * set a register claim item
     *
     * @param string $name
     * @param mixed $value
     *
     * @return Payload
     */
    public function setClaim(string $name, $value) : Payload
    {
        $this->claims[$name] = $value;

        return $this;
    }

    /**
     * Validates if the token is valid
     *
     * @param null|string $issuer
     * @param null|string $audience
     * @param null|string $subject
     * @param null|int $currentTime
     *
     * @return boolean
     */
    public function validate(
        ?string $issuer = null,
        ?string $audience = null,
        ?string $subject = null,
        ?int $currentTime = null
    ) : bool {
        $currentTime = $currentTime ?: time();
        if (isset($this->claims[RegisterNames::ISSUER]) &&
            $this->claims[RegisterNames::ISSUER] !== $issuer) {
            return false;
        }
        if (isset($this->claims[RegisterNames::AUDIENCE]) &&
            $this->claims[RegisterNames::AUDIENCE] !== $audience) {
            return false;
        }
        if (isset($this->claims[RegisterNames::SUBJECT]) &&
            $this->claims[RegisterNames::SUBJECT] != $subject) {
            return false;
        }
        if (isset($this->claims[RegisterNames::NOT_BEFORE]) &&
            $this->claims[RegisterNames::NOT_BEFORE] > $currentTime) {
            return false;
        }
        if (isset($this->claims[RegisterNames::EXPIRATION]) &&
            $this->claims[RegisterNames::EXPIRATION] < $currentTime) {
            return false;
        }

        return true;
    }

    public function jsonSerialize()
    {
        return $this->claims;
    }
}