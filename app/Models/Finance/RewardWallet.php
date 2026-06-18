<?php

declare(strict_types=1);

namespace App\Models\Finance;

use App\Models\Concerns\HasSnowflakeId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class RewardWallet extends Model
{
    use HasSnowflakeId;
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'balance',
        'total_earned',
        'total_used',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'customer_id' => 'string',
            'balance' => 'integer',
            'total_earned' => 'integer',
            'total_used' => 'integer',
        ];
    }
}
