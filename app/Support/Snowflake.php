<?php

declare(strict_types=1);

namespace App\Support;

final class Snowflake
{
    private const EPOCH = 1700000000000;
    private const RANDOM_BITS = 21;
    private const MAX_RANDOM = 0x1FFFFF;

    /**
     * Generate a positive 63-bit identifier suitable for BIGINT primary keys.
     *
     * @throws \Random\RandomException
     */
    public static function id(): int
    {
        $time = (int) (microtime(true) * 1000) - self::EPOCH;
        $random = random_int(0, self::MAX_RANDOM);

        return (($time << self::RANDOM_BITS) | $random) & 0x7FFFFFFFFFFFFFFF;
    }
}
