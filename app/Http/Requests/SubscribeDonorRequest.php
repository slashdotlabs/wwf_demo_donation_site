<?php

namespace App\Http\Requests;

use App\Enums\UserTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\Enum\Laravel\Rules\EnumRule;

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
            'user.email' => ['required', 'unique:users,email', 'email:rfc,dns'],
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
            'user.user_type' => ['required', new EnumRule(UserTypeEnum::class)],

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
}
