@if ($errors->any())
    <div class="alert alert-danger border-0 shadow-sm mb-4">
        <div class="fw-semibold mb-2"><i class="bi bi-x-circle me-2"></i>Corrigez les erreurs suivantes</div>
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
