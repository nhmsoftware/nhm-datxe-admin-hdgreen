<?php

declare(strict_types=1);

namespace App\Models\Pricing;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

final class PricingSurgeRule extends Model
{
    use HasUlids;

    protected $table = 'pricing_surge_rules';

    protected $fillable = [
        'vehicle_type_id',
        'conditions',
        'multiplier',
        'start_time',
        'end_time',
        'area_id',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'vehicle_type_id' => 'integer',
            'conditions' => 'array',
            'multiplier' => 'float',
            'is_active' => 'boolean',
        ];
    }
}
