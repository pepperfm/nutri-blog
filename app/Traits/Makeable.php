<?php

declare(strict_types=1);

namespace App\Traits;

trait Makeable
{
    public static function make(...$params): static
    {
        return new static(...$params);
    }
}
