<?php

declare(strict_types=1);

namespace App\Models\Driver;

use App\Models\Concerns\HasSnowflakeId;
use App\Models\Driver\Enums\FileableType;
use App\Models\Driver\Enums\KycStatus;
use App\Models\Driver\Enums\KycType;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        return $this->belongsTo(User::class, 'user_id');
    }

    public function files(): HasMany
    {
        $driverDocumentTypes = array_map(
            static fn (FileableType $type): int => $type->value,
            FileableType::requiredForDriverRegistration(),
        );

        return $this->hasMany(FileRecord::class, 'fileable_id')
            ->whereIn('fileable_type', $driverDocumentTypes);
    }
}
