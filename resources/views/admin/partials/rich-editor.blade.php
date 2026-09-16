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
<script>
    document.addEventListener('trix-attachment-add', function (event) {
        const attachment = event.attachment;
        if (!attachment.file) return;

        const formData = new FormData();
        formData.append('file', attachment.file);
        formData.append('_token', @json(csrf_token()));

        fetch(@json(route('admin.editor.upload')), {
            method: 'POST',
            body: formData,
            credentials: 'same-origin',
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        })
            .then(r => r.ok ? r.json() : Promise.reject())
            .then(data => {
                attachment.setAttributes({ url: data.url, href: data.url });
            })
            .catch(() => alert('Échec de l’upload de l’image.'));
    });
</script>
@endpush
