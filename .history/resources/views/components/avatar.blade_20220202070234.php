@if($avatar)
    <img src="{{ asset($avatar) }}" alt="avatar" style="width:{{ $width }}; height:{{ $height }};">
@else
    <img src="{{ asset('site/assets/images/avatars/d2.png') }}" alt="logo" style="width:{{ $width }}; height:{{ $height }};">
@endif
 <img src="{{ ('board/assets/images/users/1.jpg')}}" alt="user" class="profile-pic me-2">
