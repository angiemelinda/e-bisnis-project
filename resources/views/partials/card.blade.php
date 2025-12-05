@props(['title' => '', 'value' => '', 'icon' => '', 'color' => 'primary'])

<div class="card">
    <div class="card-header">
        @if($icon)
            <i class="{{ $icon }}"></i>
        @endif
        {{ $title }}
    </div>
    <div class="card-body">
        <div class="stat-value">{{ $value }}</div>
        {{ $slot }}
    </div>
</div>

