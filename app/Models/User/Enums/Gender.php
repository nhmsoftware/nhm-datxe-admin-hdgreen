<?php

declare(strict_types=1);

namespace App\Models\User\Enums;

use App\Models\Concerns\EnumHelper;

enum Gender: int
{
    use EnumHelper;

    case Male = 1;
    case Female = 2;
    case Other = 3;

    public function label(): string
    {
        return match ($this) {
            self::Male => 'Nam',
            self::Female => 'Nữ',
            self::Other => 'Khác',
        };
    }
}
