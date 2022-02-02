@if($avatar)
    <img src="{{ asset($avatar) }}" alt="avatar" style="width:{{ $width }}; height:{{ $height }};">
@else
    <img src="{{ asset('site/assets/images/avatars/logo.png') }}" alt="logo" style="width:{{ $width }}; height:{{ $height }};">
@endif

