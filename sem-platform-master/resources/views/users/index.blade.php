<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex items-center pb-4">
            <div class="w-1/2">
                <form action="{{ route('users.index') }}" method="GET">
                    <input type="text" name="q"
                           class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                           placeholder="Search"
                    value="{{ request()->get('q') }}">
                </form>
            </div>
            <div class=" w-1/2 ml-3">
                <a
                    href="{{ route('teams.index') }}"
                    class="py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 shadow-sm hover:bg-indigo-500 focus:outline-none focus:shadow-outline-blue active:bg-indigo-600 transition duration-150 ease-in-out">
                    Manage teams
                </a>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

                @foreach($users as $user)
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
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Active
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                            {{ $user->created_at->diffForHumans() }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                            <a href="{{ route('users.edit', $user->id) }}"
                               class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>

                            <a href="#"
                               onclick="document.getElementById('deleteUser-{{ $user->id }}').submit();"
                               class="text-red-600 hover:text-red-900 mr-2">Delete</a>

                            <form id="deleteUser-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}"
                                  method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>

                @endforeach
            </x-table>
            {{ $users->render() }}
        </div>
    </div>
</x-app-layout>
