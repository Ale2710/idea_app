<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-primary-button
                class="flex items-center"
                onclick="location.href='{{ route('register') }}'"
            >
                Crear Usuario
            </x-primary-button>

        </div>
    </div>
</x-app-layout>
