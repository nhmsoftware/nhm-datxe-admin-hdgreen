<x-filament-panels::page>
    <form wire:submit="save" class="space-y-6">
        <x-filament::section>
            <x-slot name="heading">Phạm vi áp dụng</x-slot>

            <div class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                <p>Credit Wallet chỉ áp dụng cho tài xế đối tác tự do.</p>
                <p>Tài xế đội xe nhà sẽ bỏ qua credit check và không bị ảnh hưởng bởi cấu hình này.</p>
                <p>Nếu số dư ví thấp hơn ngưỡng tối thiểu và bật tự động khóa, tài xế đối tác sẽ bị chuyển sang trạng thái <strong>Khóa nhận cuốc</strong>.</p>
            </div>
        </x-filament::section>

        {{ $this->form }}

        <div class="flex justify-end">
            <x-filament::button type="submit">
                Lưu cấu hình
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
