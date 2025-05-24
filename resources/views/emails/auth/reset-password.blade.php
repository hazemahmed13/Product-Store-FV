@component('mail::message')
# Hello {{ $name }}!

You are receiving this email because we received a password reset request for your account.

@component('mail::button', ['url' => route('password.reset', ['token' => $token])])
Reset Password
@endcomponent

This password reset link will expire in 24 hours.

If you did not request a password reset, no further action is required.

Thanks,<br>
{{ config('app.name') }}
@endcomponent 