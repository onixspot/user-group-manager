<?php

namespace App\Retrofit\Http;

class Response
{
    public function __construct(
        private ?string $returnType = null
    ) {
    }

    public function getReturnType(): ?string
    {
        return $this->returnType;
    }

    public function setReturnType(?string $returnType): Response
    {
        $this->returnType = $returnType;

        return $this;
    }

}