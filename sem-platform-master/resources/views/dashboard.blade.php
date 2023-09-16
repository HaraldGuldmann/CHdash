<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-5">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Statistics
                </h3>
                <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <dl>
                                <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                                    Total Earnings
                                </dt>
                                <dd class="mt-1 text-3xl leading-9 font-semibold text-gray-900">
                                    ${{ number_format($totalEarnings, 2) }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-5">
                @if(auth()->user()->is_admin)
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Admin Statistics
                    </h3>
                    <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <dl>
                                    <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                                        Total Channels
                                    </dt>
                                    <dd class="mt-1 text-3xl leading-9 font-semibold text-gray-900">
                                        {{ number_format(\App\Models\Channel::count()) }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <dl>
                                    <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                                        Total Asset Labels
                                    </dt>
                                    <dd class="mt-1 text-3xl leading-9 font-semibold text-gray-900">
                                        {{ number_format(\App\Models\AssetLabel::count()) }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <dl>
                                    <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                                        Total Users
                                    </dt>
                                    <dd class="mt-1 text-3xl leading-9 font-semibold text-gray-900">
                                        {{ number_format(\App\Models\User::count()) }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            @if(auth()->user()->team)
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-5">
                    Clients
                </h3>
                <x-table>
                    <x-slot name="thead">
                        <tr>
                            <x-table-head>
                                {{ __('Name') }}
                            </x-table-head>
                            <x-table-head>
                                {{ __('Payment Information') }}
                            </x-table-head>
                            <x-table-head>
                                {{ __('Is Active?') }}
                            </x-table-head>
                            <x-table-head>
                                {{ __('Created At') }}
                            </x-table-head>
                            <th class="px-6 py-3 bg-gray-50"></th>
                        </tr>
                    </x-slot>

                    @foreach(auth()->user()->team->users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" src="{{ $user->profile_photo_url }}"
                                             alt="{{ $user->name }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm leading-5 font-medium text-gray-900">
                                            {{ $user->name }}
                                        </div>
                                        <div class="text-sm leading-5 text-gray-500">
                                            {{ $user->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap">
                                <div
                                    class="text-sm leading-5 text-gray-900">  {{ config('paymentmethods.'.$user->payment_method)['name'] }}</div>
                                @if($user->payment_method == 'paypal')
                                    <div class="text-sm leading-5 text-gray-500">{{ $user->paypal_email }}</div>
                                @endif
                                @if($user->payment_method == 'bank')
                                    <div class="text-sm leading-5 text-gray-500">
                                        {{ $user->bank_account_holder }}<br>
                                        {{ $user->bank_account_number }}<br>
                                        {{ $user->bank_sort_code }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                  Active
                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                {{ $user->created_at->diffForHumans() }}
                            </td>

                            <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                @if(auth()->user()->is_admin)
                                <a href="{{ route('users.impersonate', $user->id) }}"
                                   class="text-indigo-600 hover:text-indigo-900 mr-2">Log In As User</a>
                                    @endif
                            </td>
                        </tr>

                    @endforeach
                </x-table>
            @endif
        </div>
    </div>
</x-app-layout>
