<?php

declare(strict_types=1);

namespace App\Models\Finance;

use App\Models\Finance\Enums\CommissionScope;
use App\Models\Finance\Enums\CommissionServiceType;
use App\Models\Finance\Enums\CommissionTargetType;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class CommissionRule extends Model
{
    use HasUlids;
    use SoftDeletes;

    protected $table = 'commission_rules';

    protected $fillable = [
        'name',
        'target_type',
        'service_type',
        'scope',
        'area_id',
        'commission_rate',
        'min_commission',
        'max_commission',
        'is_active',
        'effective_from',
        'effective_to',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'target_type' => CommissionTargetType::class,
            'service_type' => CommissionServiceType::class,
            'scope' => CommissionScope::class,
            'commission_rate' => 'float',
            'min_commission' => 'float',
            'max_commission' => 'float',
            'is_active' => 'boolean',
            'effective_from' => 'datetime',
            'effective_to' => 'datetime',
        ];
    }
}
