@if($avatar)
    <img src="{{ asset($avatar)}}" alt="user" class="profile-pic me-2">
@else
    <img src="{{ asset('site/assets/images/avatars/d2.png') }}">
@endif