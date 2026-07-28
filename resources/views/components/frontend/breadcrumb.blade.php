@props(['items' => null])

@php
    $items = $items ?? [
        ['label' => 'Instituto Nacional de Investigaciones Forestales, Agrícolas y Pecuarias'],
        ['label' => 'Blog', 'current' => true],
    ];
@endphp

<nav class="gob-institutional-breadcrumb" aria-label="Ruta de navegación">
    <div class="gob-institutional-breadcrumb__inner">
        <a class="gob-institutional-breadcrumb__home" href="{{ route('frontend.home') }}" aria-label="Inicio">
            <i class="las la-home" aria-hidden="true"></i>
        </a>
        @foreach($items as $item)
            <span class="gob-institutional-breadcrumb__separator" aria-hidden="true">&rsaquo;</span>
            @if(!empty($item['url']) && empty($item['current']))
                <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
            @else
                <span @class(['gob-institutional-breadcrumb__current' => !empty($item['current'])])>{{ $item['label'] }}</span>
            @endif
        @endforeach
    </div>
</nav>
