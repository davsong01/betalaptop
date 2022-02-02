@if($avatar)
    <img src="{{ asset($avatar) }}" alt="avatar" style="width:{{ $width }}; height:{{ $height }}; padding-left: 20px;">
@else
    <img src="{{ asset('site/assets/images/general/logo.png') }}" alt="logo" style="width:{{ $width }}; height:{{ $height }};">
@endif

