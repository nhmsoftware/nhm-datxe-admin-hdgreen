<?php

declare(strict_types=1);

namespace App\Models\Finance\Enums;

enum CommissionScope: int
{
    case SYSTEM = 1;
    case REGIONAL = 2;
    case SERVICE = 3;

    public function getLabel(): string
    {
        return match ($this) {
            self::SYSTEM => 'Toàn hệ thống',
            self::REGIONAL => 'Theo khu vực',
            self::SERVICE => 'Theo loại dịch vụ',
        };
    }
}
