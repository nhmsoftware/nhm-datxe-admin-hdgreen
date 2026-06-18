<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use App\Support\Snowflake;

trait HasSnowflakeId
{
    protected static function bootHasSnowflakeId(): void
    {
        static::creating(function ($model): void {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Snowflake::id();
            }
        });
    }

    public function getIncrementing(): bool
    {
        return false;
    }

    public function getKeyType(): string
    {
        return 'int';
    }
}
