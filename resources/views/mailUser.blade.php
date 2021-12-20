@component('mail::message')
# Activation Email

Thanks so much for registering!

@component('mail::button', ['url' => 'http://localhost:8081/cek/'.$detail['email'].'/'.$detail['password'].'/'.\Carbon\Carbon::parse($detail['date'])->format('Y-m-d H:i:s')])
Click Me :)
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent