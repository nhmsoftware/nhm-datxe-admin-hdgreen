<?php

declare(strict_types=1);

namespace App\Models\Finance;

use App\Models\Concerns\HasSnowflakeId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class VoucherWallet extends Model
{
    use HasSnowflakeId;
    use SoftDeletes;

    protected $table = 'voucher_wallets';

    protected $fillable = [
        'customer_id',
        'voucher_id',
        'saved_at',
        'used_at',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'customer_id' => 'string',
            'voucher_id' => 'string',
            'saved_at' => 'datetime',
            'used_at' => 'datetime',
        ];
    }

    public function voucher(): BelongsTo
    {
        return $this->belongsTo(Voucher::class, 'voucher_id');
    }
}
