@if(\Schema::hasTable('settings'))
    @if(\App\Setting::count() > 0 && \App\Setting::first()->value('logo') )
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset(\App\Setting::first()->value('favicon')) }}">
    @else
    <img src="{{ asset('site/assets/images/general/logo.png') }}" alt="logo">
    <link rel="icon" type="image/png" sizes="16x16" href="site/assets/images/general/favicon.png">
    @endif
@endif


