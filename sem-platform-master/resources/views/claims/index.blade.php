<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manual Claims') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('claims.index') }}" method="GET">
                <label for=""></label>
                <select onchange="this.form.submit()" name="status" class="mt-1 block w-25 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="">SELECT STATUS</option>
                    <option value="pending" @if(request()->get('status') == 'pending') selected @endif>PENDING</option>
                    <option value="claimed" @if(request()->get('status') == 'claimed') selected @endif>CLAIMED</option>
                    <option value="rejected" @if(request()->get('status') == 'rejected') selected @endif>REJECTED</option>
                </select>

            </form>

            <div class="float-right">
                <a
                    href="{{ route('claims.create') }}"
                    class="py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 shadow-sm hover:bg-indigo-500 focus:outline-none focus:shadow-outline-blue active:bg-indigo-600 transition duration-150 ease-in-out">
                    Submit Video
                </a>
            </div>
            <br><br>

            <x-table>
                <x-slot name="thead">
                    <tr>
                        <x-table-head>
                            {{ __('Video') }}
                        </x-table-head>
                        <x-table-head>
                            {{ __('Status') }}
                        </x-table-head>
                        <x-table-head>
                            {{ __('Timestamps') }}
                        </x-table-head>
                        <x-table-head>
                            {{ __('Match Policy') }}
                        </x-table-head>
                        <x-table-head>
                            {{ __('Content Type') }}
                        </x-table-head>
                        @if(auth()->user()->is_admin)
                            <x-table-head>
                                Asset Label
                            </x-table-head>
                            <x-table-head>
                                Admin Actions
                            </x-table-head>
                        @endif
                    </tr>
                </x-slot>

                @foreach($claims as $claim)
                    <tr>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                            <a href="{{ $claim->video_url }}" target="_blank">
                            {{ $claim->video_url }}
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                            {{ $claim->status }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                            {{ $claim->timestamp_start }}<br>
                            {{ $claim->timestamp_end }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                            {{ $claim->match_policy }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                            {{ $claim->content_type }}
                        </td>
                        @if(auth()->user()->is_admin)
                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                @if($claim->user)
                                {{ \Str::slug($claim->user->name) }}
                                    @endif
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                <a href="{{ route('claims.claim', $claim->id) }}"
                                   class="text-green-600 hover:text-green-900 mr-2">Claim</a>
                                <a href="{{ route('claims.reject', $claim->id) }}"
                                   class="text-red-600 hover:text-red-900 mr-2">Reject</a>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </x-table>

            {{ $claims->links() }}
        </div>
    </div>
</x-app-layout>
