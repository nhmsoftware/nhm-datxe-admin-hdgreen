<?php

declare(strict_types=1);

namespace App\Models\User;

use App\Models\Concerns\HasSnowflakeId;
use App\Models\User\Enums\UserOtpType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

final class UserOtp extends Model
{
    use HasSnowflakeId;

    protected $table = 'user_otp';

    public ?string $plain_code = null;

    protected $fillable = [
        'phone',
        'otp_hash',
        'type',
        'attempts',
        'expired_at',
        'verified_at',
        'used_at',
        'last_sent_at',
        'send_count',
        'ip_address',
    ];

    protected function casts(): array
    {
        return [
            'expired_at' => 'datetime',
            'verified_at' => 'datetime',
            'used_at' => 'datetime',
            'last_sent_at' => 'datetime',
            'type' => UserOtpType::class,
        ];
    }

    public function isExpired(): bool
    {
        return $this->expired_at->isPast();
    }

    public function isUsed(): bool
    {
        return $this->used_at !== null;
    }

    public function isVerified(): bool
    {
        return $this->verified_at !== null;
    }

    public function checkCode(string $plainCode): bool
    {
        return Hash::check($plainCode, $this->otp_hash);
    }
}
