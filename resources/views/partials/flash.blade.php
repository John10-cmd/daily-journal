@if (session('success') || $errors->any())
    <div class="toast-container position-fixed top-0 end-0 p-3 app-toast-container">
        @if (session('success'))
            <div class="toast app-toast app-toast-success show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="4500">
                <div class="toast-body d-flex align-items-start gap-3">
                    <i class="bi bi-check-circle"></i>
                    <div class="flex-grow-1">
                        <strong class="d-block">Success</strong>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" class="btn-close btn-close-white ms-2" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="toast app-toast app-toast-danger show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="7000">
                <div class="toast-body d-flex align-items-start gap-3">
                    <i class="bi bi-exclamation-triangle mt-1"></i>
                    <div class="flex-grow-1">
                        <strong class="d-block">Unable to continue</strong>
                        <span>{{ $errors->first() }}</span>
                    </div>
                    <button type="button" class="btn-close btn-close-white ms-2" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>
@endif
