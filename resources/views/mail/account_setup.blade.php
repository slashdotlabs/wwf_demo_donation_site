@component('mail::message')
# Dear {{ $donor->last_name }},

Thank you for supporting the cause and contributing to the
WWF Kenyan Chapter.

Setup your account to access your details and monitor your contributions.

@component('mail::button', ['url' => $setup_url])
    Setup Your Account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
