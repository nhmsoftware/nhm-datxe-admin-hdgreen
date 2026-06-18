<?php

declare(strict_types=1);

namespace App\Models\Ride\Enums;

enum RideChatSenderType: int
{
    case CUSTOMER = 1;
    case DRIVER = 2;

    public function getLabel(): string
    {
        return match ($this) {
            self::CUSTOMER => 'Khách hàng',
            self::DRIVER => 'Tài xế',
        };
    }
}
