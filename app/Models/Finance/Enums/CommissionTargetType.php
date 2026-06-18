<?php

declare(strict_types=1);

namespace App\Models\Finance\Enums;

use App\Models\Concerns\EnumHelper;

enum CommissionTargetType: int
{
    use EnumHelper;

    case DRIVER = 1;
    case MERCHANT = 2;

    public function label(): string
    {
        return match ($this) {
            self::DRIVER => 'Tài xế',
            self::MERCHANT => 'Merchant/Nhà hàng',
        };
    }
}
