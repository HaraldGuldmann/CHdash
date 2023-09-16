<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($video->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                {{ $video->description }}
            </div>
            <iframe src="{{ asset('storage/'.$video->file_path) }}" frameborder="0" width="100%" height="500px" class="pb-5"></iframe>

            @if(auth()->user()->is_admin)
                <a href="{{ route('videos.approve', $video->id) }}"
                    class="py-2 px-4 mr-3 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-green-600 shadow-sm hover:bg-green-500 focus:outline-none focus:shadow-outline-blue active:bg-green-600 transition duration-150 ease-in-out">
                    Approve
                </a>
                <a href="{{ route('videos.deny', $video->id) }}"
                   class="py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-red-600 shadow-sm hover:bg-red-500 focus:outline-none focus:shadow-outline-blue active:bg-red-600 transition duration-150 ease-in-out">
                    Deny
                </a>
                @endif
        </div>
    </div>
</x-app-layout>
