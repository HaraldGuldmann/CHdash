<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($contract->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <iframe src="{{ asset('storage/'.$contract->file_path) }}" frameborder="0" width="100%" height="500px" class="pb-5"></iframe>
        </div>
    </div>
</x-app-layout>
