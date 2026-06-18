<?php

declare(strict_types=1);

namespace App\Models\Ride\Enums;

enum RideType: int
{
    case CITY = 1;
    case INTERCITY = 2;
    case AIRPORT = 3;
    case DELIVERY = 4;
    case CHAUFFEUR = 5;

    public function getLabel(): string
    {
        return match ($this) {
            self::CITY => 'Chuyến xe thường',
            self::INTERCITY => 'Đi tỉnh',
            self::AIRPORT => 'Sân bay',
            self::DELIVERY => 'Giao hàng',
            self::CHAUFFEUR => 'Lái hộ',
        };
    }
}
