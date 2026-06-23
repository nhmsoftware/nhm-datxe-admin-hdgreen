<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\HasSnowflakeId;
use App\Models\User\CustomerProfile;
use App\Models\User\DriverProfile;
use App\Models\User\Enums\Gender;
use App\Models\User\Enums\KycStatus;
use App\Models\User\Enums\KycType;
use App\Models\User\Enums\UserRole;
use App\Models\User\MerchantProfile;
use App\Models\User\UserDevice;
use App\Models\User\UserReviewApplication;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements HasName, FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;
    use HasSnowflakeId;
    use Notifiable;
    use SoftDeletes;

    protected $table = 'users';

    public function canAccessPanel(Panel $panel): bool
    {
        return $panel->getId() === 'admin'
            && $this->isAdmin()
            && $this->isActive();
    }

    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'role',
        'is_verified',
        'is_phone_verified',
        'is_active',
        'google_id',
        'apple_id',
        'avatar',
        'address',
        'citizen_id',
        'lock_reason',
        'locked_days',
        'locked_at',
        'lock_expired_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'gender' => Gender::class,
            'is_verified' => 'boolean',
            'is_phone_verified' => 'boolean',
            'is_active' => 'boolean',
            'deleted_at' => 'datetime',
            'locked_at' => 'datetime',
            'lock_expired_at' => 'datetime',
            'locked_days' => 'integer',
        ];
    }

    public function customerProfile(): HasOne
    {
        return $this->hasOne(CustomerProfile::class);
    }

    public function driverProfile(): HasOne
    {
        return $this->hasOne(DriverProfile::class);
    }

    public function merchantProfile(): HasOne
    {
        return $this->hasOne(MerchantProfile::class);
    }

    public function userDevices(): HasMany
    {
        return $this->hasMany(UserDevice::class);
    }

    public function userReviewApplications(): HasMany
    {
        return $this->hasMany(UserReviewApplication::class);
    }

    public function latestDriverApplication(): HasOne
    {
        return $this->hasOne(UserReviewApplication::class)
            ->where('kyc_type', KycType::Driver->value)
            ->latestOfMany();
    }

    public function isCustomer(): bool
    {
        return $this->role === UserRole::Customer;
    }

    public function isDriver(): bool
    {
        return $this->role === UserRole::Driver;
    }

    public function isMerchant(): bool
    {
        return $this->role === UserRole::Merchants;
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }

    public function getFullNameAttribute(): ?string
    {
        return $this->customerProfile?->full_name
            ?? $this->driverProfile?->full_name
            ?? $this->merchantProfile?->store_name
            ?? $this->attributes['name']
            ?? null;
    }

    public function getFilamentName(): string
    {
        return $this->full_name
            ?? $this->attributes['name']
            ?? $this->email
            ?? $this->phone
            ?? 'User #' . $this->getKey();
    }

    public function getGenderAttribute(): ?Gender
    {
        return $this->customerProfile?->gender;
    }

    public function getAvatarAttribute(): ?string
    {
        return $this->attributes['avatar']
            ?? $this->customerProfile?->avatar
            ?? $this->driverProfile?->avatar
            ?? null;
    }

    public function getAddressAttribute(): ?string
    {
        return $this->attributes['address']
            ?? $this->customerProfile?->address
            ?? $this->merchantProfile?->store_address
            ?? null;
    }

    public function getBirthdayAttribute(): mixed
    {
        return $this->customerProfile?->birthday;
    }

    public function getCitizenIdAttribute(): ?string
    {
        return $this->attributes['citizen_id']
            ?? $this->customerProfile?->citizen_id
            ?? $this->driverProfile?->citizen_id
            ?? null;
    }

    public function isLocked(): bool
    {
        return !$this->is_active;
    }

    public function isActive(): bool
    {
        return $this->is_active && $this->deleted_at === null;
    }

    public function isProfileApproved(): bool
    {
        if ($this->role === UserRole::Customer) {
            $latestApp = $this->userReviewApplications()->latest()->first();

            return $latestApp !== null && $latestApp->kyc_status === KycStatus::Approved;
        }

        if ($this->role === UserRole::Driver) {
            return $this->driverProfile !== null;
        }

        if ($this->role === UserRole::Merchants) {
            return $this->merchantProfile !== null
                && $this->merchantProfile->status === KycStatus::Approved;
        }

        return true;
    }

    public function getProfileStatus(): KycStatus
    {
        if ($this->role === UserRole::Customer) {
            $latestApp = $this->userReviewApplications()->latest()->first();

            return $latestApp?->kyc_status ?? KycStatus::NotSubmitted;
        }

        if ($this->role === UserRole::Driver) {
            if ($this->driverProfile !== null) {
                return KycStatus::Approved;
            }

            $latestApp = $this->userReviewApplications()
                ->where('kyc_type', KycType::Driver->value)
                ->latest()
                ->first();

            return $latestApp?->kyc_status ?? KycStatus::NotSubmitted;
        }

        if ($this->role === UserRole::Merchants) {
            return $this->merchantProfile?->status ?? KycStatus::NotSubmitted;
        }

        return KycStatus::Approved;
    }
}
