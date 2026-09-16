@props(['field', 'label', 'default' => 'ordre'])

@php
    $currentSort = request('sort', $default);
    $currentDir = request('dir', 'asc');
    $nextDir = ($currentSort === $field && $currentDir === 'asc') ? 'desc' : 'asc';
    $active = $currentSort === $field;
@endphp

<a href="{{ request()->fullUrlWithQuery(['sort' => $field, 'dir' => $nextDir]) }}"
   class="text-white text-decoration-none {{ $active ? 'fw-bold' : '' }}">
    {{ $label }}
    @if($active)
        <i class="bi bi-caret-{{ $currentDir === 'asc' ? 'up' : 'down' }}-fill small"></i>
    @endif
</a>
