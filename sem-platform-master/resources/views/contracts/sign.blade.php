<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Sign {{ __($contract->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <iframe src="{{ asset('storage/'.$contract->file_path) }}" frameborder="0" width="100%" height="500px" class="pb-5"></iframe>

            <div class="mt-10 sm:mt-0">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Contract</h3>
                            <p class="mt-1 text-sm leading-5 text-gray-600">
                                Please review our terms and sign with your account below.
                            </p>
                        </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <form action="{{ route('contracts.sign.patch', $contract->id) }}" method="POST">
                            @method('PATCH')
                            @csrf
                            <div class="shadow overflow-hidden sm:rounded-md">
                                <div class="px-4 py-5 bg-white sm:p-6">
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-12 sm:col-span-3">
                                            <x-text-field label="Full Legal Name (Digital Signature)" name="full_legal_name" required/>
                                        </div>
                                        <div class="col-span-12">
                                            <div class="flex items-center">
                                                <input id="confirm" name="confirm" type="checkbox"
                                                       class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" required>
                                                <label for="confirm"
                                                       class="ml-2 block text-sm leading-5 text-gray-900">
                                                    I (<strong>{{ auth()->user()->name }}</strong>) confirm to have reviewed the terms and acknowledges that I am authorized to bind myself to this contract.
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    <button
                                        class="py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 shadow-sm hover:bg-indigo-500 focus:outline-none focus:shadow-outline-blue active:bg-indigo-600 transition duration-150 ease-in-out">
                                        Sign Contract
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
