@props([
'icon' => '',
'text' => '',
'link' => '#'
])

<li {{ $attributes }}>
    <a href="{{ $link }}" {{ $attributes }}>
        @if($icon)
            <i data-feather="{{ $icon }}"></i>
        @endif
        <span data-key="t-{{ $text }}">{{ $text }}</span>
    </a>
</li>
