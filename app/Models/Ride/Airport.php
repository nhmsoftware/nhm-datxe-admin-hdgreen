<?php

declare(strict_types=1);

namespace App\Models\Ride;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Airport extends Model
{
    protected $fillable = [
        'name',
        'code',
        'lat',
        'lng',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'lat' => 'decimal:7',
            'lng' => 'decimal:7',
            'is_active' => 'boolean',
        ];
    }

    public function rides(): HasMany
    {
        return $this->hasMany(Ride::class);
    }
}
