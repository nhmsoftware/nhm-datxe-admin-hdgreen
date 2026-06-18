<?php

declare(strict_types=1);

namespace App\Models\Ride\Enums;

enum RideTrackingStatus: int
{
    case WAITING_DRIVER = 1;
    case DRIVER_ACCEPTED = 2;
    case DRIVER_EN_ROUTE = 3;
    case DRIVER_ARRIVED = 4;
    case DRIVER_CANCELLED = 5;
    case CUSTOMER_CANCELLED = 6;
    case TRACKING_LOST = 7;

    public function getLabel(): string
    {
        return match ($this) {
            self::WAITING_DRIVER => 'Đang tìm tài xế',
            self::DRIVER_ACCEPTED => 'Tài xế đã nhận chuyến',
            self::DRIVER_EN_ROUTE => 'Tài xế đang đến',
            self::DRIVER_ARRIVED => 'Tài xế đã đến nơi',
            self::DRIVER_CANCELLED => 'Tài xế đã hủy chuyến',
            self::CUSTOMER_CANCELLED => 'Bạn đã hủy chuyến',
            self::TRACKING_LOST => 'Tín hiệu yếu...',
        };
    }
}
