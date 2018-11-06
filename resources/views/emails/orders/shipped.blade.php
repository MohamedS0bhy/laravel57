@component('mail::message')
# Registration

Your new password is : $pass

@component('mail::button', ['url' => $url])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
