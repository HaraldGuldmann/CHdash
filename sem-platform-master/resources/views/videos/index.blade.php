<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Asset Uploader') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('videos.index') }}" method="GET">
                <label for=""></label>
                <select onchange="this.form.submit()" name="status"
                        class="mt-1 block w-25 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="">SELECT STATUS</option>
                    <option value="approved" @if(request()->get('status') == 'approved') selected @endif>APPROVED
                    </option>
                    <option value="pending" @if(request()->get('status') == 'pending') selected @endif>PENDING</option>
                    <option value="denied" @if(request()->get('status') == 'denied') selected @endif>DENIED</option>
                </select>

            </form>
            <div class="float-right">
                <a
                    href="{{ route('videos.create') }}"
                    class="py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 shadow-sm hover:bg-indigo-500 focus:outline-none focus:shadow-outline-blue active:bg-indigo-600 transition duration-150 ease-in-out">
                    Submit Video
                </a>
            </div>
            <br><br>

            <x-table>
                <x-slot name="thead">
                    <tr>
                        <x-table-head>
                            {{ __('Title') }}
                        </x-table-head>
                        <x-table-head>
                            {{ __('Description') }}
                        </x-table-head>
                        <x-table-head>
                            {{ __('Status') }}
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

                @foreach($videos as $video)
                    <tr>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                            {{ $video->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                            {{ $video->description }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $video->status->equals(\App\Enums\VideoStatusEnum::approved()) ? 'green' : 'grey' }}-100 text-{{ $video->status->equals(\App\Enums\VideoStatusEnum::approved()) ? 'green' : 'gray' }}-800">
                              {{ $video->status }}
                            </span>
                        </td>
                        @if(auth()->user()->is_admin)
                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                @if( $video->user)
                                    {{ \Str::slug($video->user->name) }}
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                <a href="{{ route('videos.show', $video->id) }}"
                                   class="text-indigo-600 hover:text-indigo-900 mr-2">Show</a>
                                <a href="{{ route('videos.approve', $video->id) }}"
                                   class="text-green-600 hover:text-green-900 mr-2">Approve</a>
                                <a href="{{ route('videos.deny', $video->id) }}"
                                   class="text-red-600 hover:text-red-900 mr-2">Deny</a>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </x-table>
            {{ $videos->links() }}
        </div>
    </div>
</x-app-layout>
