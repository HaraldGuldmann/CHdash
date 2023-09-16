<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'revenue_share' => ['required', 'integer', 'max:100'],
            'payment_method' => ['required', Rule::in(array_keys(config('paymentmethods')))],

            'paypal_email' => ['sometimes', 'nullable', 'email', 'max:255'],
            'bank_account_holder' => ['sometimes', 'nullable', 'string', 'max:255'],
            'bank_account_number' => ['sometimes', 'nullable', 'string', 'max:255'],
            'bank_sort_code' => ['sometimes', 'nullable', 'string', 'max:255'],
            'team' => ['sometimes', 'nullable', 'exists:teams,id'],

            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user->id)]
        ];
    }
}
