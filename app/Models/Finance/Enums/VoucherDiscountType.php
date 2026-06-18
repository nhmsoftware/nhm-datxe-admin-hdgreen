<?php

declare(strict_types=1);

namespace App\Models\Finance\Enums;

enum VoucherDiscountType: int
{
    case FIXED = 1;
    case PERCENT = 2;

    public function getLabel(): string
    {
        return match ($this) {
            self::FIXED => 'Giảm tiền mặt',
            self::PERCENT => 'Giảm phần trăm',
        };
    }
}
