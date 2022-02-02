@if(\Schema::hasTable('settings'))
    @if(\Setting::count() > 0)

    @endif

@endif

