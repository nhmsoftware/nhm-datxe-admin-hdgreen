<x-filament-panels::page>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <div class="space-y-6">
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($this->stats() as $stat)
                <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $stat['label'] }}</p>
                    <p class="mt-3 text-2xl font-semibold text-gray-950 dark:text-white">{{ $stat['value'] }}</p>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">{{ $stat['hint'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            @foreach ($this->menuOptions() as $option)
                <a href="{{ $option['url'] }}"
                    class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-primary-400 hover:shadow-md dark:border-gray-800 dark:bg-gray-900">
                    <h3 class="text-base font-semibold text-gray-950 dark:text-white">
                        {{ $option['label'] }}
                    </h3>
                    <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-300">
                        {{ $option['description'] }}
                    </p>
                </a>
            @endforeach
        </div>

        <x-filament::section>
            <x-slot name="heading">Tỷ lệ hoa hồng đang hoạt động</x-slot>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-gray-800">
                    <thead>
                        <tr class="text-left text-gray-500 dark:text-gray-400">
                            <th class="py-3 pr-4 font-medium">Loại dịch vụ</th>
                            <th class="py-3 pr-4 font-medium">Tỷ lệ</th>
                            <th class="py-3 pr-4 font-medium">Phạm vi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse ($this->commissionSummary() as $item)
                            <tr>
                                <td class="py-3 pr-4 text-gray-900 dark:text-white">{{ $item['service'] }}</td>
                                <td class="py-3 pr-4 text-gray-600 dark:text-gray-300">{{ $item['rate'] }}%</td>
                                <td class="py-3 pr-4 text-gray-600 dark:text-gray-300">{{ $item['scope'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-4 text-gray-500 dark:text-gray-400">
                                    Chưa có cấu hình hoa hồng tài xế đang hoạt động.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
