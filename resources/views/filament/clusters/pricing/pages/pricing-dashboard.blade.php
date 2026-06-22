<x-filament-panels::page>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
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
</x-filament-panels::page>
