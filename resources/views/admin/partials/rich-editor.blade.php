@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trix@2.1.1/dist/trix.css">
<style>
    trix-editor {
        border-radius: 0 0 12px 12px;
        min-height: 280px;
        border: 1px solid var(--girona-border);
        border-top: none;
        padding: 1rem;
    }
    trix-toolbar {
        border-radius: 12px 12px 0 0;
        border: 1px solid var(--girona-border);
        background: #fafafa;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/trix@2.1.1/dist/trix.umd.min.js"></script>
@endpush
