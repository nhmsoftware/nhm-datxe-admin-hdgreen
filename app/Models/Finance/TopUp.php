<?php

declare(strict_types=1);

namespace App\Models\Finance;

use App\Models\Finance\Enums\TopUpStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class TopUp extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'wallet_id',
        'amount',
        'status',
        'payment_method',
        'external_id',
        'metadata',
        'expired_at',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'user_id' => 'string',
            'wallet_id' => 'string',
            'amount' => 'float',
            'status' => TopUpStatus::class,
            'metadata' => 'array',
            'expired_at' => 'datetime',
        ];
    }
}
