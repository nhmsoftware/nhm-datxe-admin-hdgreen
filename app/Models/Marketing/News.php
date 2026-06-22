<?php

declare(strict_types=1);

namespace App\Models\Marketing;

use App\Models\Marketing\Enums\MarketingItemStatus;
use App\Support\FileHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use SoftDeletes;

    protected $table = 'news';

    protected $fillable = [
        'title',
        'description',
        'content',
        'image_url',
        'tag',
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
