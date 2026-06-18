<?php

declare(strict_types=1);

namespace App\Models\User\Enums;

use App\Models\Concerns\EnumHelper;

enum KycStatus: int
{
    use EnumHelper;

    case NotSubmitted = 0;
    case Pending = 1;
    case Approved = 2;
    case Rejected = 3;

    public function label(): string
    {
        return match ($this) {
            self::NotSubmitted => 'Chưa nộp hồ sơ',
            self::Pending => 'Chờ duyệt',
            self::Approved => 'Đã duyệt',
            self::Rejected => 'Từ chối',
        };
    }
}
