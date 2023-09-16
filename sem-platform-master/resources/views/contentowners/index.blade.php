<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Content Owners') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <ul class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                @foreach($contentOwners as $contentOwner)
                    <li class="col-span-1 flex flex-col text-center bg-white rounded-lg shadow">
                        <div class="flex-1 flex flex-col p-8">
                            <img class="w-32 h-32 flex-shrink-0 mx-auto bg-black rounded-full"
                                 src="{{ asset('img/contentowners/1.png') }}"
                                 alt="{{ $contentOwner->name }}">
                            <h3 class="mt-6 text-gray-900 text-sm leading-5 font-medium">{{ $contentOwner->name }}</h3>
                            <dl class="mt-1 flex-grow flex flex-col justify-between">
                                <dd class="text-gray-500 text-sm leading-5">{{ number_format(count($contentOwner->assetLabels)) }} {{ __('Asset Labels') }}</dd>
                                <dd class="text-gray-500 text-sm leading-5">{{ number_format(count($contentOwner->channels)) }} {{ __('Channels') }}</dd>
                                <dd class="mt-3">
                                    <span
                                        class="px-2 py-1 text-{{ $contentOwner->is_active ? 'teal' : 'red' }}-800 text-xs leading-4 font-medium bg-{{ $contentOwner->is_active ? 'teal' : 'red' }}-100 rounded-full">
                                        {{ __($contentOwner->is_active ? 'Connected' : 'Disconnected') }}
                                    </span>
                                </dd>
                            </dl>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>
