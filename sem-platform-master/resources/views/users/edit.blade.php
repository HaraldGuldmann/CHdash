<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit').' '.$user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-10 sm:mt-0">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">User Information</h3>
                            <p class="mt-1 text-sm leading-5 text-gray-600">
                                Update settings for this user.
                            </p>
                        </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                            @method('PATCH')
                            @csrf
                            <div class="shadow overflow-hidden sm:rounded-md">
                                <div class="px-4 py-5 bg-white sm:p-6">
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-12 sm:col-span-3">
                                            <x-text-field label="Name" name="name" :value="$user->name" required/>
                                        </div>

                                        <div class="col-span-6 sm:col-span-4">
                                            <x-text-field label="Email" name="email" :value="$user->email" required/>
                                        </div>

                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="payment_method"
                                                   class="block text-sm font-medium leading-5 text-gray-700">Payment Method</label>
                                            <select id="payment_method" name="payment_method"
                                                    class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                                                @foreach(config('paymentmethods') as $key => $value)
                                                    <option
                                                        value="{{ $key }}" {{ $key == $user->payment_method ? 'selected' : ''}}>{{ $value['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-span-6">
                                            <x-text-field label="PayPal Email" name="paypal_email" :value="$user->paypal_email"/>
                                        </div>

                                        <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                            <x-text-field label="Bank Account Holder" name="bank_account_holder" :value="$user->bank_account_holder"/>
                                        </div>

                                        <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                            <x-text-field label="Bank Account Number" name="bank_account_number" :value="$user->bank_account_number"/>
                                        </div>

                                        <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                            <x-text-field label="Bank Sort Code" name="bank_sort_code" :value="$user->bank_sort_code"/>
                                        </div>

                                        <div class="col-span-12 sm:col-span-3">
                                            <x-text-field label="Revenue Share" name="revenue_share" :value="$user->revenue_share" required/>
                                        </div>

                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="team"
                                                   class="block text-sm font-medium leading-5 text-gray-700">Agency</label>
                                            <select id="team" name="team"
                                                    class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                                                <option value="">Select Team</option>
                                                @foreach(\App\Models\Team::all() as $team)
                                                    <option
                                                        value="{{ $team->id }}" @if($user->team_id == $team->id) selected @endif>{{ $team->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="flex items-center">
                                            <input id="is_admin" name="is_admin" type="checkbox" class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" {{ $user->is_admin ? 'checked' : '' }}>
                                            <label for="is_admin" class="ml-2 block text-sm leading-5 text-gray-900">
                                               Is Admin?
                                            </label>
                                        </div>

                                    </div>
                                </div>

                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    <button
                                        class="py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 shadow-sm hover:bg-indigo-500 focus:outline-none focus:shadow-outline-blue active:bg-indigo-600 transition duration-150 ease-in-out">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
