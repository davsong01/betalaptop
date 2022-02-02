@if(\Schema::hasTable('settings'))
    @if(\Setting::count() > 0)
    

@endif

<img src="{{ asset('site/assets/images/general/logo.png') }}" alt="logo" style="width:{{ $width }}; height:{{ $height }}; padding-left: 20px;">