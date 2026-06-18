<?php

declare(strict_types=1);

namespace App\Models\User;

use App\Models\Concerns\HasSnowflakeId;
use App\Models\User;
use App\Models\User\Enums\KycStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class MerchantProfile extends Model
{
    use HasSnowflakeId;
    use SoftDeletes;

    protected $table = 'merchant_profiles';

    protected $fillable = [
        'user_id',
        'store_name',
        'store_address',
        'business_type',
        'latitude',
        'longitude',
        'opening_time',
        'closing_time',
        'is_open',
        'business_license',
        'business_license_image',
        'citizen_id_image',
        'store_image',
        'average_rating',
        'total_orders',
        'status',
        'reject_reason',
        'commission_rate',
        'commission_package',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'user_id' => 'string',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'is_open' => 'boolean',
            'average_rating' => 'decimal:2',
            'total_orders' => 'integer',
            'commission_rate' => 'decimal:2',
            'status' => KycStatus::class,
        ];
    }

    public function openingHours(): HasMany
    {
        return $this->hasMany(MerchantOpeningHour::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
