<?php

namespace App\Retrofit\Http;

class Request
{
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_PUT = 'PUT';
    public const METHOD_PATCH = 'PATCH';
    public const METHOD_DELETE = 'DELETE';

    public function __construct(
        private string $method = self::METHOD_GET,
        private ?string $path = null,
        private ?array $body = null,
        private array $uriVariables = [],
    ) {
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(?string $method): Request
    {
        $this->method = $method;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): Request
    {
        $this->path = $path;

        return $this;
    }

    public function getBody(): ?array
    {
        return $this->body;
    }

    public function setBody(?array $body): Request
    {
        $this->body = $body;

        return $this;
    }

    public function getUriVariables(): array
    {
        return $this->uriVariables;
    }

    public function setUriVariables(array $uriVariables): Request
    {
        $this->uriVariables = $uriVariables;

        return $this;
    }
}