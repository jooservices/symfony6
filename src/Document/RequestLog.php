<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(collection="request_logs")
 */
class RequestLog
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $url;

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $method;

    /**
     * @MongoDB\Field(type="hash")
     */
    protected array $requestOptions;

    /**
     * @MongoDB\Field(type="string")
     */
    protected string $response;

    /**
     * @MongoDB\Field(type="int")
     */
    protected int $statusCode;

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function setRequestOptions(array $requestOptions): self
    {
        $this->requestOptions = $requestOptions;

        return $this;
    }

    public function setResponse(string $response): self
    {
        $this->response = $response;

        return $this;
    }

    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }
}
