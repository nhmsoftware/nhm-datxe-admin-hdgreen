<?php

declare(strict_types=1);

namespace App\Models\Finance;

use App\Models\Concerns\HasSnowflakeId;
use App\Models\Finance\Enums\RewardTransactionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class RewardTransaction extends Model
{
    use HasSnowflakeId;
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'type',
        'points',
        'description',
        'reference_type',
        'reference_id',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'customer_id' => 'string',
            'type' => RewardTransactionType::class,
            'points' => 'integer',
            'reference_id' => 'string',
        ];
    }

    public function reference(): MorphTo
    {
        return $this->morphTo();
    }
}
