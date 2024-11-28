<?php

namespace App\Retrofit\Attribute;

#[\Attribute(\Attribute::TARGET_METHOD)]
class Patch implements RequestTag
{
    public function __construct(public string $url)
    {
    }
}