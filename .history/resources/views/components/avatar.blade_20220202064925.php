

@if(\Schema::hasTable('settings'))
    @if(\App\Setting::count() > 0 && \App\Setting::first()->value('logo') )
    <img src="{{ asset(\App\Setting::first()->value('logo')) }}" alt="logo" style="width:{{ $width }}; height:{{ $height }}; padding-left: 20px;">
    @else
    <img src="{{ asset('site/assets/images/general/logo.png') }}" alt="logo" style="width:{{ $width }}; height:{{ $height }}; padding-left: 20px;">
    @endif
@endif

