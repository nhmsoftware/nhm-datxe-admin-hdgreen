<?php

declare(strict_types=1);

namespace App\Models\Ride;

use App\Models\Concerns\HasSnowflakeId;
use App\Models\Ride\Enums\RideStatus;
use App\Models\Ride\Enums\RideTrackingStatus;
use App\Models\Ride\Enums\RideType;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Ride extends Model
{
    use HasSnowflakeId;
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'driver_id',
        'pickup_address',
        'pickup_lat',
        'pickup_lng',
        'destination_address',
        'destination_lat',
        'destination_lng',
        'distance',
        'duration',
        'vehicle_type',
        'ride_type',
        'travel_date',
        'travel_time',
        'airport_id',
        'airport_direction',
        'status',
        'base_price',
        'distance_price',
        'time_fare',
        'total_price',
        'voucher_id',
        'voucher_code',
        'discount_amount',
        'tracking_status',
        'is_pushed_to_pool',
        'is_pushed_to_internal_pool',
        'is_paid',
        'cancel_reason',
        'cancellation_fee',
        'service_fee',
        'driver_earnings',
        'driver_assigned_at',
        'driver_arrived_at',
        'pickup_proof_photo_url',
        'pickup_proof_captured_at',
        'pickup_proof_skip_reason',
        'pickup_proof_note',
        'delivery_proof_photo_url',
        'delivery_proof_captured_at',
        'delivery_proof_skip_reason',
        'delivery_proof_note',
        'tracking_last_ping_at',
        'chauffeur_license_plate',
        'chauffeur_vehicle_type',
        'chauffeur_brand',
        'chauffeur_color',
        'started_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'customer_id' => 'string',
            'driver_id' => 'string',
            'pickup_lat' => 'decimal:7',
            'pickup_lng' => 'decimal:7',
            'destination_lat' => 'decimal:7',
            'destination_lng' => 'decimal:7',
            'distance' => 'integer',
            'duration' => 'integer',
            'vehicle_type' => 'integer',
            'ride_type' => RideType::class,
            'travel_date' => 'date',
            'airport_id' => 'integer',
            'airport_direction' => 'integer',
            'status' => RideStatus::class,
            'tracking_status' => RideTrackingStatus::class,
            'is_pushed_to_pool' => 'boolean',
            'is_pushed_to_internal_pool' => 'boolean',
            'base_price' => 'decimal:2',
            'distance_price' => 'decimal:2',
            'time_fare' => 'decimal:2',
            'total_price' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'is_paid' => 'boolean',
            'cancellation_fee' => 'decimal:2',
            'service_fee' => 'decimal:2',
            'driver_earnings' => 'decimal:2',
            'driver_assigned_at' => 'datetime',
            'driver_arrived_at' => 'datetime',
            'pickup_proof_captured_at' => 'datetime',
            'delivery_proof_captured_at' => 'datetime',
            'tracking_last_ping_at' => 'datetime',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function airport(): BelongsTo
    {
        return $this->belongsTo(Airport::class);
    }

    public function vehicleTypeRef(): BelongsTo
    {
        return $this->belongsTo(VehicleTypeRef::class, 'vehicle_type');
    }

    public function rejects(): HasMany
    {
        return $this->hasMany(RideReject::class);
    }

    public function chatMessages(): HasMany
    {
        return $this->hasMany(RideChatMessage::class);
    }

    public function callLogs(): HasMany
    {
        return $this->hasMany(RideCallLog::class);
    }
}
