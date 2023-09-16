<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-application-mark class="block h-9 w-auto"/>
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-jet-label value="{{ __('Name') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-jet-label value="{{ __('Email') }}" />
                <x-jet-input class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <div class="mt-4">
                <x-jet-label value="{{ __('Payment Method') }}" />
                <select id="payment_method" name="payment_method" class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base leading-6 border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                    <option value="paypal">PayPal</option>
                    <option value="bank">Bank</option>
                </select>
            </div>

            <div class="mt-4">
                <x-jet-label value="{{ __('PayPal Email') }}" />
                <x-jet-input class="block mt-1 w-full" type="email" name="paypal_email" :value="old('paypal_email')" required />
            </div>

            <div class="mt-4">
                <x-jet-label value="{{ __('Bank Account Holder') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="bank_account_holder" :value="old('bank_account_holder')" />
            </div>

            <div class="mt-4">
                <x-jet-label value="{{ __('Bank Account Number') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="bank_account_number" :value="old('bank_account_number')" />
            </div>

            <div class="mt-4">
                <x-jet-label value="{{ __('Bank Sort Code') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" name="bank_sort_code" :value="old('bank_sort_code')" />
            </div>

            <div class="mt-4">
                <x-jet-label value="{{ __('Password') }}" />
                <x-jet-input class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label value="{{ __('Confirm Password') }}" />
                <x-jet-input class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Register') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
