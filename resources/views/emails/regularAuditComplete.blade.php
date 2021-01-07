<div>
    Был проведен регулярный замер для сайта {{ $measurement->domain }}
</div>
<div>
    На мобильном устройстве:
    @foreach ($measurement->measure as $measure)
        @if ($measure->audit->name === 'score')
            {{ $measure->value * 100 }} баллов
        @endif
    @endforeach
</div>
<div>
    На компьютере:
    @foreach ($measurement->measureDesktop as $measure)
        @if ($measure->audit->name === 'score')
            {{ $measure->value * 100 }} баллов
        @endif
    @endforeach
</div>