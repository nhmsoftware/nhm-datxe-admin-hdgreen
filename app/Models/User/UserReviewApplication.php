<?php

declare(strict_types=1);

namespace App\Models\User;

use App\Models\Concerns\HasSnowflakeId;
use App\Models\User;
use App\Models\User\Enums\KycStatus;
use App\Models\User\Enums\KycType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class UserReviewApplication extends Model
{
    use HasSnowflakeId;

    protected $table = 'user_review_applications';

    protected $fillable = [
        'user_id',
        'snapshot_data',
        'kyc_type',
        'kyc_status',
        'cancel_reason',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'user_id' => 'string',
            'snapshot_data' => 'array',
            'kyc_type' => KycType::class,
            'kyc_status' => KycStatus::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
