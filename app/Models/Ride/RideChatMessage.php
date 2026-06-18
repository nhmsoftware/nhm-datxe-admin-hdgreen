<?php

declare(strict_types=1);

namespace App\Models\Ride;

use App\Models\Concerns\HasSnowflakeId;
use App\Models\Ride\Enums\RideChatMessageStatus;
use App\Models\Ride\Enums\RideChatSenderType;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class RideChatMessage extends Model
{
    use HasSnowflakeId;

    protected $fillable = [
        'ride_id',
        'sender_id',
        'sender_type',
        'message',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'ride_id' => 'string',
            'sender_id' => 'string',
            'sender_type' => RideChatSenderType::class,
            'status' => RideChatMessageStatus::class,
        ];
    }

    public function ride(): BelongsTo
    {
        return $this->belongsTo(Ride::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
