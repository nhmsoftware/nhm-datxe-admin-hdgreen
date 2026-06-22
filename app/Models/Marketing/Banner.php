<?php

declare(strict_types=1);

namespace App\Models\Marketing;

use App\Models\Marketing\Enums\MarketingItemStatus;
use App\Support\FileHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use SoftDeletes;

    protected $table = 'banners';

    protected $fillable = [
        'title',
        'description',
        'label',
        'tag',
        'image_url',
        'action_url',
        'order',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'order' => 'integer',
            'status' => MarketingItemStatus::class,
        ];
    }

    public function getImageUrlAttribute(?string $value): ?string
    {
        return FileHelper::serveUrl($value);
    }

    public function getRawImagePathAttribute(): ?string
    {
        return $this->attributes['image_url'] ?? null;
    }
}
