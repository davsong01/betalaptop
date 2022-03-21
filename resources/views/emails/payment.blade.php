@component('mail::message')
# {{config('app.name')}} Payment Notification

Dear {{$resource->user}},

We have recieved your payment of ***#{{$resource->amount}}***

Your transaction id is:***{{$resource->transaction_id}}***

Kindly [login to your back office to view your wallet balance and history]({{config('app.url') . '/wallet'}})

Warm Regards,<br>
{{ config('app.name') }}
@endcomponent