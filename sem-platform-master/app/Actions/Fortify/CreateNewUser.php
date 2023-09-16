<?php

namespace App\Actions\Fortify;

use App\Jobs\CreateAssetLabelJob;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'payment_method' => ['required', 'string', 'max:255'],

            'paypal_email' => ['sometimes', 'nullable', 'email', 'max:255'],
            'bank_account_holder' => ['sometimes', 'nullable', 'string', 'max:255'],
            'bank_account_number' => ['sometimes', 'nullable', 'string', 'max:255'],
            'bank_sort_code' => ['sometimes', 'nullable', 'string', 'max:255'],

            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'payment_method' => $input['payment_method'],
            'paypal_email' => $input['paypal_email'],
            'bank_account_holder' => $input['bank_account_holder'],
            'bank_account_number' => $input['bank_account_number'],
            'bank_sort_code' => $input['bank_sort_code'],
            'password' => Hash::make($input['password']),
        ]);

        CreateAssetLabelJob::dispatch($user);

        return $user;
    }
}
