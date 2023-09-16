<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Earnings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-table>
                <x-slot name="thead">
                    <tr>
                        <x-table-head>
                            {{ __('Month/Year') }}
                        </x-table-head>
                        <x-table-head>
                            {{ __('Amount') }}
                        </x-table-head>
                        <x-table-head>
                            {{ __('Paid') }}
                        </x-table-head>
                        <x-table-head>
                            {{ __('Created At') }}
                        </x-table-head>
                    </tr>
                </x-slot>

                @foreach($earnings as $earning)
                    <tr>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                            {{ $earning->earningRun->month }}/{{ $earning->earningRun->year }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                            ${{ number_format($earning->amount, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                            {{ $earning->paid ? 'Yes' : 'No' }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                            {{ $earning->created_at->diffForHumans() }}
                        </td>
                    </tr>
                @endforeach
            </x-table>
        </div>
    </div>
</x-app-layout>
