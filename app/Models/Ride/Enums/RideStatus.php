<?php

declare(strict_types=1);

namespace App\Models\Ride\Enums;

enum RideStatus: int
{
    case DRAFT = 1;
    case PENDING = 2;
    case ACCEPTED = 3;
    case IN_PROGRESS = 4;
    case COMPLETED = 5;
    case CANCELLED = 6;
    case PICKED_UP = 7;
    case CANCELLATION_REQUESTED = 8;

    public function isTerminal(): bool
    {
        return in_array($this, [self::COMPLETED, self::CANCELLED], true);
    }

    public function canTransitionTo(self $next): bool
    {
        return match ($this) {
            self::DRAFT => in_array($next, [self::PENDING, self::CANCELLED], true),
            self::PENDING => in_array($next, [self::ACCEPTED, self::CANCELLED], true),
            self::ACCEPTED => in_array($next, [self::PICKED_UP, self::CANCELLED, self::CANCELLATION_REQUESTED], true),
            self::PICKED_UP => in_array($next, [self::IN_PROGRESS, self::CANCELLED, self::CANCELLATION_REQUESTED], true),
            self::IN_PROGRESS => $next === self::COMPLETED,
            self::CANCELLATION_REQUESTED => in_array($next, [self::CANCELLED, self::ACCEPTED, self::PICKED_UP], true),
            default => false,
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::DRAFT => 'Đang tạo chuyến xe',
            self::PENDING => 'Đang chờ',
            self::ACCEPTED => 'Đã tiếp nhận',
            self::IN_PROGRESS => 'Đang di chuyển',
            self::PICKED_UP => 'Đang di chuyển (Đã đón khách)',
            self::COMPLETED => 'Hoàn thành',
            self::CANCELLED => 'Đã hủy',
            self::CANCELLATION_REQUESTED => 'Đang chờ xác nhận hủy',
        };
    }
}
