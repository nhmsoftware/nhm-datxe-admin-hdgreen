<?php

declare(strict_types=1);

namespace App\Models\Pricing;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

final class PricingConfigHistory extends Model
{
    use HasUlids;

    protected $table = 'pricing_config_history';

    protected $fillable = [
        'vehicle_type_id',
        'old_config',
        'new_config',
        'admin_id',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'vehicle_type_id' => 'integer',
            'old_config' => 'array',
            'new_config' => 'array',
        ];
    }
}
