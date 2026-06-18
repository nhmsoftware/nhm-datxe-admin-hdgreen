<?php

declare(strict_types=1);

namespace App\Models\Concerns;

trait EnumHelper
{
    /**
     * @return array<int, int|string>
     */
    public static function values(): array
    {
        return array_map(static fn (self $case): int|string => $case->value, self::cases());
    }

    /**
     * @return array<int, array{value: int|string, label: string}>
     */
    public static function options(): array
    {
        return array_map(static fn (self $case): array => [
            'value' => $case->value,
            'label' => method_exists($case, 'label') ? $case->label() : $case->name,
        ], self::cases());
    }

    public static function fromValue(int|string $value): ?self
    {
        foreach (self::cases() as $case) {
            if ($case->value === $value) {
                return $case;
            }
        }

        return null;
    }
}
