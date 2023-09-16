<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Video Submissions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-10 sm:mt-0">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-7 text-gray-900">Important Information</h3>
                            <p class="mt-1 text-sm leading-5 text-gray-600">
                               Please ensure that you have the audiovisual exclusive rights to the video you're submitting.
                                <br> <br> If you do not own the audiovisual rights of your submission, please get in touch with your contact and they will manually process your request.
                            </p>
                        </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="shadow overflow-hidden sm:rounded-md">
                                <div class="px-4 py-5 bg-white sm:p-6">
                                    <div class="grid grid-cols-6 gap-5">
                                        <div class="col-span-3">
                                            <x-text-field label="Video Title" name="name" />
                                        </div>

                                        <div class="col-span-3">
                                            <x-text-field label="Video Description" name="description" />
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

                                            @error('description')
                                                <div class="rounded-md bg-red-50 p-4 mt-5">
                                                    <div class="text-sm text-red-700">
                                                        {{ $message }}
                                                    </div>
                                                </div>
                                            @enderror
                                        </div>

                                        <div id="musicContainer" class="hidden col-span-6 grid grid-cols-6 gap-5">
                                            <div class="col-span-4">
                                                <x-text-field label="ISRC" name="isrc" class="audioRequired"/>
                                            </div>

                                            <div class="col-span-4">
                                                <x-text-field label="Artist" name="artist"/>
                                            </div>

                                            <div class="col-span-4">
                                                <x-text-field label="Album" name="album"/>
                                            </div>
                                        </div>

                                        <script>
                                            const source = document.querySelector("#type");
                                            const target = document.querySelector("#musicContainer");

                                            const displayWhenSelected = (source, value, target) => {
                                                target.classList[source.value === value ? "remove" : "add"]("hidden");
                                            };
                                            source.addEventListener("change", (evt) =>
                                                displayWhenSelected(source, "audio", target)
                                            );

                                            displayWhenSelected(source, "audio", target)
                                        </script>

                                        <div class="col-span-6 mt-5">
                                            <input type="file" name="file">

                                            @error('file')
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
                                        Submit Video
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
