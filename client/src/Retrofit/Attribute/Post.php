<?php

namespace App\Retrofit\Attribute;

#[\Attribute(\Attribute::TARGET_METHOD)]
class Post implements RequestTag
{
    public function __construct(public string $url)
    {
    }
}