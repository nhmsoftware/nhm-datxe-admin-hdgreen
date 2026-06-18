<?php

declare(strict_types=1);

namespace App\Models\Driver\Enums;

enum DriverServiceType: int
{
    case BIKE_RIDE = 1;
    case TAXI_4_SEATS = 2;
    case TAXI_7_SEATS = 3;
    case FOOD_DELIVERY = 4;
    case PARCEL_DELIVERY = 5;
    case INTERCITY = 6;
    case AIRPORT = 7;
    case DRIVER_FOR_HIRE = 8;

    public function getLabel(): string
    {
        return match ($this) {
            self::BIKE_RIDE => 'Xe ôm',
            self::TAXI_4_SEATS => 'Taxi 4 chỗ',
            self::TAXI_7_SEATS => 'Taxi 7 chỗ',
            self::FOOD_DELIVERY => 'Giao đồ ăn',
            self::PARCEL_DELIVERY => 'Giao hàng',
            self::INTERCITY => 'Xe đi tỉnh',
            self::AIRPORT => 'Xe sân bay',
            self::DRIVER_FOR_HIRE => 'Lái hộ',
        };
    }

    /**
     * @return list<string>
     */
    public function getServiceScopes(): array
    {
        return match ($this) {
            self::BIKE_RIDE, self::TAXI_4_SEATS, self::TAXI_7_SEATS => ['city'],
            self::FOOD_DELIVERY, self::PARCEL_DELIVERY => ['delivery'],
            self::INTERCITY => ['intercity'],
            self::AIRPORT => ['airport'],
            self::DRIVER_FOR_HIRE => ['chauffeur'],
        };
    }
}
