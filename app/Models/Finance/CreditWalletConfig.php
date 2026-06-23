<?php

declare(strict_types=1);

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;

final class CreditWalletConfig extends Model
{
    protected $table = 'credit_wallet_configs';

    protected $attributes = [
        'min_balance' => 50000,
        'auto_lock' => true,
        'commission_rule' => 'Default rule',
    ];

    protected $fillable = [
        'min_balance',
        'auto_lock',
        'commission_rule',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'min_balance' => 'float',
            'auto_lock' => 'boolean',
        ];
    }
}
