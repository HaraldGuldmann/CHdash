<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manual Claim Request') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-10 sm:mt-0">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-7 text-gray-900">Important Information</h3>
                            <p class="mt-1 text-sm leading-5 text-gray-600"></p>
                        </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <form action="{{ route('claims.store') }}" method="POST">
                            @csrf
                            <div class="shadow overflow-hidden sm:rounded-md">
                                <div class="px-4 py-5 bg-white sm:p-6">
                                    <div class="grid grid-cols-6 gap-5">
                                        <div class="col-span-6">
                                            <x-text-field label="Video URL" name="video_url" placeholder="https://www.youtube.com/watch?v=" />
                                        </div>

                                        <div class="col-span-3">
                                            <x-text-field label="Start Time" name="timestamp_start" placeholder="hh:mm:ss" />
                                        </div>

                                        <div class="col-span-3">
                                            <x-text-field label="End Time" name="timestamp_end" placeholder="hh:mm:ss" />
                                        </div>

                                        <div class="col-span-6">
                                            <label class="block text-sm font-medium leading-5 text-gray-700" for="policy">
                                                Match Policy
                                            </label>
                                            <select id="policy" name="match_policy" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                                @foreach(\App\Enums\MatchPolicyEnum::toArray() as $type => $name)
                                                    <option value="{{ $type }}">{{ $name }}</option>
                                                @endforeach
                                            </select>

                                            @error('content_type')
                                            <div class="rounded-md bg-red-50 p-4 mt-5">
                                                <div class="text-sm text-red-700">
                                                    {{ $message }}
                                                </div>
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="col-span-6">
                                            <label class="block text-sm font-medium leading-5 text-gray-700" for="type">
                                                Content Type
                                            </label>
                                            <select id="type" name="content_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                                @foreach(\App\Enums\ReferenceContentTypeEnum::toArray() as $type => $name)
                                                    <option value="{{ $type }}">{{ $name }}</option>
                                                @endforeach
                                            </select>

                                            @error('content_type')
                                                <div class="rounded-md bg-red-50 p-4 mt-5">
                                                    <div class="text-sm text-red-700">
                                                        {{ $message }}
                                                    </div>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    <button
                                        class="py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 shadow-sm hover:bg-indigo-500 focus:outline-none focus:shadow-outline-blue active:bg-indigo-600 transition duration-150 ease-in-out">
                                        Submit Request
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
