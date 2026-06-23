<?php

declare(strict_types=1);

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class SubscriptionPackage extends Model
{
    use SoftDeletes;

    protected $table = 'subscription_packages';

    protected $fillable = [
        'name',
        'package_type',
        'description',
        'price',
        'duration_days',
        'service_fee_reduction_percent',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'price' => 'float',
            'duration_days' => 'integer',
            'service_fee_reduction_percent' => 'float',
            'is_active' => 'boolean',
        ];
    }

    public function driverSubscriptions(): HasMany
    {
        return $this->hasMany(DriverSubscription::class, 'package_id');
    }
}
