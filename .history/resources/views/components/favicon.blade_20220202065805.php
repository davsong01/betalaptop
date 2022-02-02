@if(\Schema::hasTable('settings'))
    @if(\App\Setting::count() > 0 && \App\Setting::first()->value('logo') )
    <img src="" alt="logo" style="width:{{ $width }}; height:{{ $height }}; padding-left: 20px;">
    <link rel="icon" type="image/png" sizes="16x16" href="">
    
    @else
    <img src="{{ asset('site/assets/images/general/logo.png') }}" alt="logo" style="width:{{ $width }}; height:{{ $height }}; padding-left: 20px;">
    <link rel="icon" type="image/png" sizes="16x16" href="site/assets/images/general/favicon.png">
    @endif
@endif


