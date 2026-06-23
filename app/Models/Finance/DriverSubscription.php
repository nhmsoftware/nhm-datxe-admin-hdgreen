<?php

declare(strict_types=1);

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class DriverSubscription extends Model
{
    use SoftDeletes;

    protected $table = 'driver_subscriptions';

    protected $fillable = [
        'driver_id',
        'package_id',
        'started_at',
        'expires_at',
        'status',
        'price_paid',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'driver_id' => 'string',
            'package_id' => 'string',
            'started_at' => 'datetime',
            'expires_at' => 'datetime',
            'price_paid' => 'float',
        ];
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPackage::class, 'package_id');
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'driver_id');
    }
}
