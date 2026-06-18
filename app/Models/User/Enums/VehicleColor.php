<?php

declare(strict_types=1);

namespace App\Models\User\Enums;

use App\Models\Concerns\EnumHelper;

enum VehicleColor: int
{
    use EnumHelper;

    case Unknown = 0;
    case White = 1;
    case Black = 2;
    case Silver = 3;
    case Red = 4;
    case Blue = 5;

    public function label(): string
    {
        return match ($this) {
            self::Unknown => 'Chưa xác định',
            self::White => 'Trắng',
            self::Black => 'Đen',
            self::Silver => 'Bạc',
            self::Red => 'Đỏ',
            self::Blue => 'Xanh',
        };
    }
}
