<?php

declare(strict_types=1);

namespace App\Models\Ride;

use App\Models\Concerns\HasSnowflakeId;
use App\Models\Ride\Enums\RideCallStatus;
use App\Models\Ride\Enums\RideChatSenderType;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class RideCallLog extends Model
{
    use HasSnowflakeId;

    protected $fillable = [
        'ride_id',
        'caller_id',
        'callee_id',
        'caller_type',
        'status',
        'failure_reason',
    ];

    protected function casts(): array
    {
        return [
            'ride_id' => 'string',
            'caller_id' => 'string',
            'callee_id' => 'string',
            'caller_type' => RideChatSenderType::class,
            'status' => RideCallStatus::class,
        ];
    }

    public function ride(): BelongsTo
    {
        return $this->belongsTo(Ride::class);
    }

    public function caller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'caller_id');
    }

    public function callee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'callee_id');
    }
}
