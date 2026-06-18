<?php

declare(strict_types=1);

namespace App\Models\User\Enums;

use App\Models\Concerns\EnumHelper;

enum DriverGroupType: int
{
    use EnumHelper;

    case INTERNAL = 1;
    case PARTNER = 2;

    public function label(): string
    {
        return match ($this) {
            self::INTERNAL => 'Xe nhà',
            self::PARTNER => 'Xe khách',
        };
    }
}
