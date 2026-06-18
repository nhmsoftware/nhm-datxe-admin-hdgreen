<?php

declare(strict_types=1);

namespace App\Models\Finance;

use App\Models\Concerns\HasSnowflakeId;
use App\Models\Finance\Enums\VoucherDiscountType;
use App\Models\Finance\Enums\VoucherServiceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Voucher extends Model
{
    use HasSnowflakeId;
    use SoftDeletes;

    protected $table = 'vouchers';

    protected $fillable = [
        'code',
        'name',
        'service_type',
        'discount_type',
        'discount_value',
        'min_order_amount',
        'max_discount_amount',
        'valid_from',
        'valid_until',
        'total_usage_limit',
        'used_count',
        'is_active',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'service_type' => VoucherServiceType::class,
            'discount_type' => VoucherDiscountType::class,
            'discount_value' => 'float',
            'min_order_amount' => 'float',
            'max_discount_amount' => 'float',
            'valid_from' => 'datetime',
            'valid_until' => 'datetime',
            'is_active' => 'boolean',
            'used_count' => 'integer',
            'total_usage_limit' => 'integer',
        ];
    }

    public function isValid(): bool
    {
        $now = now();

        if (!$this->is_active) {
            return false;
        }

        if ($now->lt($this->valid_from) || $now->gt($this->valid_until)) {
            return false;
        }

        return $this->total_usage_limit === null || $this->used_count < $this->total_usage_limit;
    }

    public function isExpired(): bool
    {
        return now()->gt($this->valid_until)
            || ($this->total_usage_limit !== null && $this->used_count >= $this->total_usage_limit);
    }

    public function calculateDiscount(float $orderAmount): float
    {
        if ($orderAmount < $this->min_order_amount) {
            return 0.0;
        }

        $discount = 0.0;

        if ($this->discount_type === VoucherDiscountType::FIXED) {
            $discount = $this->discount_value;
        } elseif ($this->discount_type === VoucherDiscountType::PERCENT) {
            $discount = ($orderAmount * $this->discount_value) / 100;

            if ($this->max_discount_amount !== null) {
                $discount = min($discount, $this->max_discount_amount);
            }
        }

        return min($discount, $orderAmount);
    }
}
