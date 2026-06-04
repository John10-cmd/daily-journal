@if (session('success') || $errors->any())
    <div class="toast-container position-fixed top-0 end-0 p-3 app-toast-container">
        @if (session('success'))
            <div class="toast app-toast app-toast-success show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="4500">
                <div class="toast-body d-flex align-items-center gap-3">
                    <i class="bi bi-check-circle"></i>
                    <span class="flex-grow-1">{{ session('success') }}</span>
                    <button type="button" class="btn-close btn-close-white ms-2" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="toast app-toast app-toast-danger show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="7000">
                <div class="toast-body d-flex align-items-start gap-3">
                    <i class="bi bi-exclamation-triangle mt-1"></i>
                    <div class="flex-grow-1">
                        <p class="fw-bold mb-1">Please fix the highlighted fields.</p>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close btn-close-white ms-2" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>
@endif
