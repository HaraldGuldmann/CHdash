<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Channels') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-table>
                <x-slot name="thead">
                    <tr>
                        <x-table-head>
                            {{ __('Channel') }}
                        </x-table-head>
                        <x-table-head>
                            {{ __('Statistics') }}
                        </x-table-head>
                        <x-table-head>
                            {{ __('Content Owner') }}
                        </x-table-head>
                        <x-table-head>
                            {{ __('Linked At') }}
                        </x-table-head>
                        <x-table-head>
                            {{ __('Created At') }}
                        </x-table-head>
                    </tr>
                </x-slot>

                @foreach($channels as $channel)
                    <tr>
                        <td class="px-6 py-4 whitespace-no-wrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" src="{{ $channel->avatar }}"
                                         alt="{{ $channel->name }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm leading-5 font-medium text-gray-900">
                                        {{ $channel->name }}
                                    </div>
                                    <div class="text-sm leading-5 text-gray-500">
                                        {{ $channel->external_id }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                            {{  number_format($channel->statistics['subscriberCount']) }} Subscribers <br>
                            {{  number_format($channel->statistics['viewCount']) }} Views
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                            {{ $channel->contentOwner->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                            {{ $channel->linked_at->diffForHumans() }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                            {{ $channel->created_at->diffForHumans() }}
                        </td>
                    </tr>

                @endforeach
            </x-table>
            {{ $channels->render() }}
        </div>
    </div>
</x-app-layout>
