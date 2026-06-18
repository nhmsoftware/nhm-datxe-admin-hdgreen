<?php

declare(strict_types=1);

namespace App\Models\User;

use App\Models\Concerns\HasSnowflakeId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class DriverGroup extends Model
{
    use HasSnowflakeId;
    use SoftDeletes;

    protected $table = 'driver_groups';

    protected $fillable = [
        'name',
        'description',
    ];

    public function profiles(): HasMany
    {
        return $this->hasMany(DriverProfile::class, 'driver_group_id');
    }
}
