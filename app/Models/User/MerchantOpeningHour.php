<?php

declare(strict_types=1);

namespace App\Models\User;

use App\Models\Concerns\HasSnowflakeId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class MerchantOpeningHour extends Model
{
    use HasSnowflakeId;

    protected $table = 'merchant_opening_hours';

    protected $fillable = [
        'merchant_profile_id',
        'day_of_week',
        'opening_time',
        'closing_time',
        'is_closed',
        'is_overnight',
    ];

    protected function casts(): array
    {
        return [
            'is_closed' => 'boolean',
            'is_overnight' => 'boolean',
            'day_of_week' => 'integer',
        ];
    }

    public function merchantProfile(): BelongsTo
    {
        return $this->belongsTo(MerchantProfile::class);
    }
}
