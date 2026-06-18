<?php

declare(strict_types=1);

namespace App\Models\Ride;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class RideReject extends Model
{
    protected $fillable = [
        'ride_id',
        'driver_id',
    ];

    protected function casts(): array
    {
        return [
            'ride_id' => 'string',
            'driver_id' => 'string',
        ];
    }

    public function ride(): BelongsTo
    {
        return $this->belongsTo(Ride::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
}
