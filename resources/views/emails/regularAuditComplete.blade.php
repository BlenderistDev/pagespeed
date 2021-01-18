@component('mail::message')

Был проведен регулярный замер для сайта {{ $measurement->domain }}

@component('mail::panel')
На мобильном устройстве:
@foreach ($measurement->measure as $measure)
    @if ($measure->audit->name === 'score')
        {{ $measure->value * 100 }} баллов
    @endif
@endforeach
@endcomponent

@component('mail::panel')
На компьютере:
@foreach ($measurement->measureDesktop as $measure)
    @if ($measure->audit->name === 'score')
        {{ $measure->value * 100 }} баллов
    @endif
@endforeach
@endcomponent

@endcomponent