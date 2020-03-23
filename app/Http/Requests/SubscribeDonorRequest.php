<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscribeDonorRequest extends FormRequest
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
            'user' => ['required', 'array'],
            'user.first_name' => 'required',
            'user.last_name' => 'required',
            'user.email' => ['required', 'unique:users,email', 'email:rfc'],
            'user.user_type' => ['required', 'in:donor'],

            'donor_details' => ['required', 'array'],
            'donor_details.phone_number' => 'required',
            'donor_details.city' => 'required',
            'donor_details.country' => 'required',
            'donor_details.postal_code' => 'required',

            'subscription' => ['required', 'array'],
            'subscription.subscription_type' => ['required', 'in:adoption,membership'],
            'subscription.amount' => ['required', 'integer'],
            'subscription.cycle' => ['required', 'in:monthly,quarterly,yearly']
        ];
    }

    public function attributes()
    {
        return [
            'user.first_name' => 'first name',
            'user.last_name' => 'last name',
            'user.email' => 'email',
            'user.user_type' => 'user type',

//            'donor_details' => ['required', 'array'],
//            'donor_details.phone_number' => 'required',
//            'donor_details.city' => 'required',
//            'donor_details.country' => 'required',
//            'donor_details.postal_code' => 'required',
//
//            'subscription' => ['required', 'array'],
//            'subscription.subscription_type' => ['required', 'in:adoption,membership'],
//            'subscription.amount' => ['required', 'integer'],
//            'subscription.cycle' => ['required', 'in:monthly,quarterly,yearly']
        ];
    }

    public function messages()
    {
        return [
            '*.required' => 'This field is required',
            'user.email.unique' => 'Email address already registered'
        ];
    }
}
