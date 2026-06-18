<?php

declare(strict_types=1);

namespace App\Models\Ride;

use Illuminate\Database\Eloquent\Model;

final class VehicleTypeRef extends Model
{
    protected $table = 'vehicle_types';

    protected $fillable = [
        'id',
        'code',
        'name_vi',
        'description_vi',
        'capacity',
        'estimated_wait_time',
        'service_scopes',
        'is_bookable',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'capacity' => 'integer',
            'service_scopes' => 'array',
            'is_bookable' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}
