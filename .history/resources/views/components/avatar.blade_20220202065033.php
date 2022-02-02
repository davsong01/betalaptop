@if($avatar)
    <img src="{{ asset() }}" alt="logo" style="width:{{ $width }}; height:{{ $height }}; padding-left: 20px;">
@endif

@if(\Schema::hasTable('settings'))
    @if(\App\Setting::count() > 0 && \App\Setting::first()->value('logo') )
    @else
    <img src="{{ asset('site/assets/images/general/logo.png') }}" alt="logo" style="width:{{ $width }}; height:{{ $height }}; padding-left: 20px;">
    @endif
@endif

