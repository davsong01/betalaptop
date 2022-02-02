@if($avatar)
    <img src="{{ asset($avatar) }}" alt="avatar" style="width:{{ $width }}; height:{{ $height }}; padding-left: 20px;">
@else

@if(\Schema::hasTable('settings'))
    @if(\App\Setting::count() > 0 && \App\Setting::first()->value('logo') )
    @else
    @endif
@endif

