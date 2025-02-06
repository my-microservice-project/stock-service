<?php

namespace App\Enums;

enum CacheEnum: string
{
    case STOCK = 'stock:';

    public function getValue(): string
    {
        return $this->value;
    }

    public function getTTL(): int
    {
        return match ($this) {
            self::STOCK => 3600,
        };
    }
}
