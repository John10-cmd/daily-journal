@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show app-alert" role="alert">
        <div class="d-flex gap-3">
            <i class="bi bi-check-circle-fill flex-shrink-0"></i>
            <div>{{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show app-alert" role="alert">
        <div class="d-flex gap-3">
            <i class="bi bi-exclamation-triangle-fill flex-shrink-0"></i>
            <div>
                <p class="fw-bold mb-2">Please fix the highlighted fields.</p>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
