@component('mail::message')
# Welcome to {{env('APP_NAME')}}

Dear {{$resource->name}},

Welcome to **[{{env('APP_NAME')}}]({{env('APP_URL')}})**, ***an account has been created for you*** by *admin*.

Your login details are:<br>
*Email:* ***{{$resource->recipient}}***<br>
*Password:* ***password12345***

@component('mail::button', ['url' => "{{env('APP_URL')}}/login"])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent