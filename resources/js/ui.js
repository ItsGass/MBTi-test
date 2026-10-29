document.querySelectorAll('[data-copy]').forEach((button) => {
    button.addEventListener('click', async () => {
        const value = button.dataset.copy;
        const original = button.textContent;

        try {
            await navigator.clipboard.writeText(value);
            button.textContent = 'Tautan tersalin';
        } catch (error) {
            window.prompt('Salin tautan hasil ini:', value);
        }

        window.setTimeout(() => {
            button.textContent = original;
        }, 2000);
    });
});

/**
 * Submit the compatibility picker without a full page reload when both selects
 * keep their defaults; the server still redirects normally on no-JS browsers.
 */
const picker = document.querySelector('form[action*="kecocokan"]');

if (picker && picker.method.toLowerCase() === 'get') {
    picker.addEventListener('submit', (event) => {
        const left = picker.querySelector('select[name="a"]')?.value;
        const right = picker.querySelector('select[name="b"]')?.value;

        if (!left || !right) {
            return;
        }

        event.preventDefault();
        window.location.href = `/kecocokan/${left}/${right}`;
    });
}
