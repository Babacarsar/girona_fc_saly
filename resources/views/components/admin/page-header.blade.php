@props(['title', 'description' => null, 'breadcrumb' => null])

<div class="admin-page-header">
    @if($breadcrumb)
        <div class="admin-page-header__breadcrumb">{!! $breadcrumb !!}</div>
    @endif
    <div class="admin-page-header__row">
        <div>
            <h1 class="admin-page-header__title">{{ $title }}</h1>
            @if($description)
                <p class="admin-page-header__desc">{{ $description }}</p>
            @endif
        </div>
        @isset($actions)
            <div class="d-flex flex-wrap gap-2">{{ $actions }}</div>
        @endisset
    </div>
</div>
