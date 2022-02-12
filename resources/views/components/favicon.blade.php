@if(\Schema::hasTable('settings'))
    @if(\App\Setting::count() > 0 && \App\Setting::first()->value('favicon') )
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset(\App\Setting::first()->value('favicon')) }}">
    @else
    <link rel="icon" type="image/png" sizes="16x16" href="site/assets/images/general/favicon.png">
    @endif
@endif


