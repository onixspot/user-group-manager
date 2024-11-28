<?php

namespace App\Retrofit\Helper;


readonly class Collection
{
    public static function of(string $type): string
    {
        return sprintf('%s[]', $type);
    }
}