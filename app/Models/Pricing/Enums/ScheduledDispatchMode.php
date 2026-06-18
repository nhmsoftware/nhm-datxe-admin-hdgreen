<?php

declare(strict_types=1);

namespace App\Models\Pricing\Enums;

enum ScheduledDispatchMode: int
{
    case INTERNAL_PRIORITY = 1;
    case OPEN_POOL = 2;

    public function getLabel(): string
    {
        return match ($this) {
            self::INTERNAL_PRIORITY => 'Internal Fleet Priority',
            self::OPEN_POOL => 'Open Driver Pool',
        };
    }
}
