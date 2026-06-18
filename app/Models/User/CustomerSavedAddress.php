<?php

declare(strict_types=1);

namespace App\Models\User;

use App\Models\Concerns\HasSnowflakeId;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class CustomerSavedAddress extends Model
{
    use HasSnowflakeId;
    use SoftDeletes;

    public const LABEL_HOME = 1;
    public const LABEL_COMPANY = 2;
    public const LABEL_FAVORITE_RESTAURANT = 3;
    public const LABEL_OTHER = 4;

    protected $table = 'customer_saved_addresses';

    protected $fillable = [
        'customer_id',
        'label',
        'name',
        'address_text',
        'lat',
        'lng',
        'is_default',
        'receiver_name',
        'receiver_phone',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'customer_id' => 'string',
            'lat' => 'decimal:8',
            'lng' => 'decimal:8',
            'is_default' => 'boolean',
        ];
    }

    public function customerProfile(): BelongsTo
    {
        return $this->belongsTo(CustomerProfile::class, 'customer_id');
    }

    public function getLabelTextAttribute(): string
    {
        return match ($this->label) {
            self::LABEL_HOME => 'Nhà',
            self::LABEL_COMPANY => 'Công ty',
            self::LABEL_FAVORITE_RESTAURANT => 'Nhà hàng yêu thích',
            self::LABEL_OTHER => 'Khác',
            default => 'Khác',
        };
    }

    public function scopeForCustomer(Builder $query, string $customerId): Builder
    {
        return $query->where('customer_id', $customerId);
    }

    public function scopeDefault(Builder $query): Builder
    {
        return $query->where('is_default', true);
    }
}
