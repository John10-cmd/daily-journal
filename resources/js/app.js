import './bootstrap';

document.querySelectorAll('.toast').forEach((toast) => {
    window.setTimeout(() => {
        toast.style.transition = 'opacity 180ms ease, transform 180ms ease';
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(-4px)';
        window.setTimeout(() => toast.remove(), 220);
    }, 3500);
});

document.querySelectorAll('[data-confirm]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        if (! window.confirm(form.dataset.confirm)) {
            event.preventDefault();
        }
    });
});

document.querySelectorAll('[data-mood-picker]').forEach((picker) => {
    picker.addEventListener('change', (event) => {
        if (! event.target.matches('input[type="radio"]')) {
            return;
        }

        picker.querySelectorAll('.mood-option').forEach((option) => option.classList.remove('is-selected'));
        event.target.closest('.mood-option').classList.add('is-selected');
    });
});

document.querySelectorAll('input[type="file"][data-preview]').forEach((input) => {
    input.addEventListener('change', () => {
        const file = input.files?.[0];
        const preview = document.getElementById(input.dataset.preview);

        if (! file || ! preview) {
            return;
        }

        preview.src = URL.createObjectURL(file);
    });
});
