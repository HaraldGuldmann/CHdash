
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manual Claim
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-5 flex justify-end">
                @if(auth()->user()->is_admin)
                    <a href="{{ route('claims.claim', $claim->id) }}"
                       class="py-2 px-4 mr-3 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-green-600 shadow-sm hover:bg-green-500 focus:outline-none focus:shadow-outline-blue active:bg-green-600 transition duration-150 ease-in-out">
                        Claim
                    </a>
                    <a href="{{ route('claims.reject', $claim->id) }}"
                       class="py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-red-600 shadow-sm hover:bg-red-500 focus:outline-none focus:shadow-outline-blue active:bg-red-600 transition duration-150 ease-in-out">
                        Reject
                    </a>
                @endif
            </div>
            <div class="flex justify-center">
                <iframe id="ytplayer" type="text/html" width="640" height="360"
                        src="http://www.youtube.com/embed/{{ $claim->video_id }}?autoplay=1&origin=http://example.com"
                        frameborder="0" />
            </div>


        </div>
    </div>
</x-app-layout>
