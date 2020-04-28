@component('mail::message')
# Important  !!!

Your password has been changed!


If you did not change your password please click below to recover your password !!!
@component('mail::button', ['url' => 'https://127.0.0.1:8000/login'])
Reset Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
