<?php

declare(strict_types=1);

namespace App\Models\Finance;

use App\Models\Finance\Enums\PaymentMethodType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class PaymentMethod extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type',
        'code',
        'name',
        'is_active',
        'min_amount',
        'max_amount',
        'transfer_info',
        'icon_url',
        'metadata',
        'sort_order',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'type' => PaymentMethodType::class,
            'is_active' => 'boolean',
            'min_amount' => 'float',
            'max_amount' => 'float',
            'transfer_info' => 'array',
            'metadata' => 'array',
            'sort_order' => 'integer',
        ];
    }
}
