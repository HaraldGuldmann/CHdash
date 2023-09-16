<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit') }} {{ $earningrun->month }}/{{ $earningrun->year }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-table>
                <x-slot name="thead">
                    <tr>
                        <x-table-head>
                            {{ __('Type') }}
                        </x-table-head>
                        <x-table-head>
                            {{ __('Status') }}
                        </x-table-head>
                        <x-table-head>
                            {{ __('File Path') }}
                        </x-table-head>
                        <x-table-head>
                            {{ __('Created At') }}
                        </x-table-head>
                    </tr>
                </x-slot>

                @foreach($earningrun->reports as $report)
                    <tr>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                            {{ $report->type }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                            {{ $report->status }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                            {{ $report->file_path }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                            {{ $report->created_at->diffForHumans() }}
                        </td>
                    </tr>
                @endforeach
            </x-table>

            <div class="bg-white overflow-hidden shadow rounded-lg mb-5">
                <div class="px-4 py-5 sm:p-6">
                    <form action="{{ route('reports.store', $earningrun->id) }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf

                        <x-jet-label value="{{ __('Report Type') }}"/>
                        <select id="report_type" name="report_type"
                                class="mt-1 form-select block w-full pl-3 pr-10 py-2 mb-3 text-base leading-6 border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                            @foreach(config('reports') as $key => $value)
                                <option value="{{ $key }}">{{ $value['name'] }}</option>
                            @endforeach
                        </select>

                        <x-text-field type="file" name="file"/>


                        @if(!$earningrun->locked)
                            <button
                                class="mt-3 py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 shadow-sm hover:bg-indigo-500 focus:outline-none focus:shadow-outline-blue active:bg-indigo-600 transition duration-150 ease-in-out">
                                Upload Report
                            </button>


                            <a href="{{ route('earningruns.lock', $earningrun->id) }}"
                               class="mt-3 py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-red-600 shadow-sm hover:bg-red-500 focus:outline-none focus:shadow-outline-blue active:bg-red-600 transition duration-150 ease-in-out">
                                Lock Earning Run
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hiddenshadow rounded-lg mb-3">
                <div x-data="{ openTab: 1 }" class="p-6">
                    <ul class="flex border-b">
                        <li @click="openTab = 1" :class="{ '-mb-px': openTab === 1 }" class="-mb-px mr-1">
                            <a :class="openTab === 1 ? 'border-l border-t border-r rounded-t text-blue-700' : 'text-blue-500 hover:text-blue-800'"
                               class="bg-white inline-block py-2 px-4 font-semibold" href="#">
                                PayPal Payments
                            </a>
                        </li>
                        <li @click="openTab = 2" :class="{ '-mb-px': openTab === 2 }" class="mr-1">
                            <a :class="openTab === 2 ? 'border-l border-t border-r rounded-t text-blue-700' : 'text-blue-500 hover:text-blue-800'"
                               class="bg-white inline-block py-2 px-4 font-semibold" href="#">
                                Bank Payments
                            </a>
                        </li>
                    </ul>
                    <div class="w-full pt-4">
                        <div x-show="openTab === 1">
                            <x-table>
                                <x-slot name="thead">
                                    <tr>
                                        <x-table-head>
                                            {{ __('User') }}
                                        </x-table-head>
                                        <x-table-head>
                                            {{ __('Payment Method') }}
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

                                @foreach($earningrun->earnings()->whereHas('user', function($q)
{
    $q->where('payment_method', '=', 'paypal');

})->get() as $earning)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                            {{ $earning->user->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                            {{ $earning->user->paypal_email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                            {{ $earning->amount / 100 * $earning->user->revenue_share }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                            {{ $earning->paid ? 'Yes' : 'No' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                            {{ $earning->created_at }}
                                        </td>

                                    </tr>
                                @endforeach
                            </x-table>
                        </div>
                        <div x-show="openTab === 2">
                            <x-table>
                                <x-slot name="thead">
                                    <tr>
                                        <x-table-head>
                                            {{ __('User') }}
                                        </x-table-head>
                                        <x-table-head>
                                            {{ __('Payment Method') }}
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

                                @foreach($earningrun->earnings()->whereHas('user', function($q)
{
    $q->where('payment_method', '=', 'bank');

})->get() as $earning)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                            {{ $earning->user->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                            {{ $earning->user->bank_account_holder }}<br>
                                            {{ $earning->user->bank_account_number }}<br>
                                            {{ $earning->user->bank_sort_code }}<br>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                            {{ $earning->amount / 100 * $earning->user->revenue_share }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                            {{ $earning->paid ? 'Yes' : 'No' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                            {{ $earning->created_at }}
                                        </td>

                                    </tr>
                                @endforeach
                            </x-table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-5">
                <a href="{{ route('earningruns.paypal', $earningrun->id) }}"
                   class="mt-5 py-2 mr-4 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 shadow-sm hover:bg-blue-500 focus:outline-none focus:shadow-outline-blue active:bg-blue-600 transition duration-150 ease-in-out">
                    Export PayPal File
                </a>

                <a href="{{ route('earningruns.paid', $earningrun->id) }}"
                   class="mt-5 py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 shadow-sm hover:bg-blue-500 focus:outline-none focus:shadow-outline-blue active:bg-blue-600 transition duration-150 ease-in-out">
                    Mark As Paid
                </a>
            </div>
        </div>
</x-app-layout>
