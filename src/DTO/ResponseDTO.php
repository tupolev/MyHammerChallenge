<?php

namespace App\DTO;


class ResponseDTO implements \JsonSerializable
{
    const STATUS_SUCCESS = "success";
    const STATUS_ERROR = "error";

    /** @var string STATUS_ERROR|STATUS_SUCCESS */
    private $status = "";

    /** @var string */
    private $message = "";

    /** @var ValidationFieldDTO[] */
    private $fields = [];

    /**
     * @param string $status
     * @param string $message
     * @param ValidationFieldDTO[] $fields
     */
    public function __construct(string $status, string $message, array $fields = [])
    {
        $this->status = $status;
        $this->message = $message;
        $this->fields = $fields;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
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
     * @return ValidationFieldDTO[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param ValidationFieldDTO[] $fields
     */
    public function setFields(array $fields): void
    {
        $this->fields = $fields;
    }

    /**
     * @param ValidationFieldDTO $field
     */
    public function addField(ValidationFieldDTO $field): void
    {
        $this->fields[] = $field;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize(): array
    {
        return [
            "status" => $this->status,
            "message" => $this->message,
            "fields" => $this->fields,
        ];
    }
}
