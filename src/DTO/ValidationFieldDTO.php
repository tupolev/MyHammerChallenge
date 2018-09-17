<?php

namespace App\DTO;


class ValidationFieldDTO implements \JsonSerializable
{
    /** @var string */
    private $name = "";

    /** @var string */
    private $message = "";

    /**
     * @param string $name
     * @param string $message
     */
    public function __construct(string $name, string $message)
    {
        $this->name = $name;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            "name" => $this->name,
            "message" => $this->message,
        ];
    }
}
