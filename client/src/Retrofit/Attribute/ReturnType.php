<?php

namespace App\Retrofit\Attribute;

#[\Attribute(\Attribute::TARGET_METHOD)]
class ReturnType implements ResponseTag
{
    public function __construct(
        public ?string $type = null,
        public ?string $entryType = null
    ) {
    }
}