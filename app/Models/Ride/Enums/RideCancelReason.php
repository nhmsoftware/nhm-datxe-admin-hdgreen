<?php

declare(strict_types=1);

namespace App\Models\Ride\Enums;

enum RideCancelReason: int
{
    case CUSTOMER_NO_SHOW = 1;
    case VEHICLE_BROKEN = 2;
    case WRONG_LOCATION = 3;
    case OTHER = 4;

    public function getLabel(): string
    {
        return match ($this) {
            self::CUSTOMER_NO_SHOW => 'Khách không ra',
            self::VEHICLE_BROKEN => 'Xe hỏng',
            self::WRONG_LOCATION => 'Đặt sai điểm',
            self::OTHER => 'Khác',
        };
    }
}
