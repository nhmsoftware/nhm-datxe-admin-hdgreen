<x-filament-panels::page>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <div class="grid gap-6 md:grid-cols-2">
        <x-filament::section>
            <x-slot name="heading">Trạng thái hiện tại</x-slot>

            <div class="space-y-4">
                <div>
                    <span @class([
                        'inline-flex rounded-full px-3 py-1 text-sm font-semibold',
                        'bg-green-100 text-green-700' => $this->setting->is_free_mode,
                        'bg-gray-100 text-gray-700' => ! $this->setting->is_free_mode,
                    ])>
                        {{ $this->setting->is_free_mode ? 'Free Mode đang bật' : 'Free Mode đang tắt' }}
                    </span>
                </div>

                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Khi bật Free Mode, hệ thống coi hoa hồng runtime là 0. Khi tắt, hệ thống dùng lại cấu hình hoa hồng đang hoạt động.
                </p>
            </div>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">Luồng xử lý</x-slot>

            <ul class="list-disc space-y-2 pl-5 text-sm text-gray-600 dark:text-gray-300">
                <li>Hiển thị trạng thái hiện tại.</li>
                <li>Admin xác nhận bật hoặc tắt.</li>
                <li>Hệ thống cập nhật và lưu vào database.</li>
            </ul>
        </x-filament::section>
    </div>
</x-filament-panels::page>
