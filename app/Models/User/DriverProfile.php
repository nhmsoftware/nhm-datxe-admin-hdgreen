<?php

declare(strict_types=1);

namespace App\Models\User;

use App\Models\Concerns\HasSnowflakeId;
use App\Models\Ride\VehicleTypeRef;
use App\Models\User;
use App\Models\User\Enums\DriverStatus;
use App\Models\User\Enums\VehicleColor;
use App\Support\FileHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class DriverProfile extends Model
{
    use HasSnowflakeId;
    use SoftDeletes;

    protected $table = 'driver_profiles';

    protected $fillable = [
        'user_id',
        'full_name',
        'driver_group_id',
        'driver_group_type',
        'vehicle_type',
        'vehicle_name',
        'vehicle_color',
        'vehicle_number',
        'is_online',
        'current_lat',
        'current_lng',
        'status',
        'cooldown_until',
        'cancel_count_today',
        'license_number',
        'license_front_image',
        'license_back_image',
        'average_rating',
        'total_trips',
        'bank_name',
        'bank_account_number',
        'bank_account_holder',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'user_id' => 'string',
            'is_online' => 'boolean',
            'current_lat' => 'decimal:8',
            'current_lng' => 'decimal:8',
            'average_rating' => 'decimal:2',
            'total_trips' => 'integer',
            'cooldown_until' => 'datetime',
            'status' => DriverStatus::class,
            'vehicle_type' => 'integer',
            'vehicle_color' => VehicleColor::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function driverGroup(): BelongsTo
    {
        return $this->belongsTo(DriverGroup::class, 'driver_group_id');
    }

    public function vehicleTypeRef(): BelongsTo
    {
        return $this->belongsTo(VehicleTypeRef::class, 'vehicle_type', 'id');
    }

    public function getLicenseFrontImageAttribute(?string $value): ?string
    {
        return FileHelper::serveUrl($value);
    }

    public function getLicenseBackImageAttribute(?string $value): ?string
    {
        return FileHelper::serveUrl($value);
    }
}
