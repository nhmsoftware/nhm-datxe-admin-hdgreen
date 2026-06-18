<?php

declare(strict_types=1);

namespace App\Models\Finance\Enums;

enum VoucherServiceType: int
{
    case RIDE = 1;
    case FOOD = 2;
    case BOTH = 3;
    case DELIVERY = 4;
    case ALL = 5;

    public function getLabel(): string
    {
        return match ($this) {
            self::RIDE => 'Chuyến xe',
            self::FOOD => 'Đồ ăn',
            self::BOTH => 'Đa dịch vụ',
            self::DELIVERY => 'Giao hàng',
            self::ALL => 'Tất cả dịch vụ',
        };
    }

    public function getTargetScreen(): string
    {
        return match ($this) {
            self::RIDE => 'ride_booking',
            self::FOOD => 'food_booking',
            self::DELIVERY => 'delivery_booking',
            self::BOTH, self::ALL => 'ride_booking',
        };
    }
}
