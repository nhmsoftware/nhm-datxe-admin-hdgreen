<?php

declare(strict_types=1);

namespace App\Models\Driver;

use App\Models\Concerns\HasSnowflakeId;
use App\Models\Driver\Enums\FileDisk;
use App\Models\Driver\Enums\FileableType;
use Illuminate\Database\Eloquent\Model;

final class FileRecord extends Model
{
    use HasSnowflakeId;

    protected $table = 'files';

    protected $appends = ['link'];

    protected $fillable = [
        'name',
        'real_name',
        'path',
        'disk',
        'size',
        'mime_type',
        'fileable_type',
        'fileable_id',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'disk' => FileDisk::class,
            'fileable_type' => FileableType::class,
            'fileable_id' => 'integer',
            'size' => 'integer',
        ];
    }

    public function getLinkAttribute(): string
    {
        $baseUrl = app()->runningInConsole() ? config('app.url') : request()->root();

        return rtrim((string) $baseUrl, '/') . '/api/v1/driver/files/' . $this->id;
    }
}
