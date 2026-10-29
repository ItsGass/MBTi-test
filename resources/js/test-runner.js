const form = document.querySelector('[data-test-form]');

if (form) {
    initRunner(form);
}

function initRunner(form) {
    document.body.classList.add('js-ready');

    const pages = Array.from(form.querySelectorAll('[data-page]'));
    const pageCount = pages.length;
    const total = Number(form.dataset.total || 40);
    const saveUrl = form.dataset.saveUrl;
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    const prevButton = form.querySelector('[data-nav="prev"]');
    const nextButton = form.querySelector('[data-nav="next"]');
    const submitButton = form.querySelector('[data-submit]');
    const indicator = document.querySelector('[data-save-indicator]');
    const progressBar = document.querySelector('[data-progress-bar]');
    const answeredLabel = document.querySelector('[data-answered-count]');
    const pageLabel = document.querySelector('[data-current-page]');

    const pending = new Map();
    let activePage = Math.min(Math.max(Number(form.dataset.activePage) || 1, 1), pageCount);
    let saving = false;
    let timer = null;

    function render() {
        pages.forEach((page) => {
            if (Number(page.dataset.page) === activePage) {
                page.setAttribute('data-active', 'true');
            } else {
                page.removeAttribute('data-active');
            }
        });

        prevButton.disabled = activePage === 1;
        prevButton.classList.toggle('opacity-40', activePage === 1);
        prevButton.classList.toggle('pointer-events-none', activePage === 1);

        nextButton.classList.toggle('hidden', activePage === pageCount);
        submitButton.classList.toggle('hidden', activePage !== pageCount);
        pageLabel.textContent = String(activePage);

        const url = new URL(window.location.href);
        url.searchParams.set('halaman', String(activePage));
        window.history.replaceState({}, '', url);

        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function answeredCount() {
        return form.querySelectorAll('input[type="radio"]:checked').length;
    }

    function refreshProgress() {
        const answered = answeredCount();
        answeredLabel.textContent = String(answered);
        progressBar.style.width = `${Math.round((answered / total) * 100)}%`;
        progressBar.setAttribute('aria-valuenow', String(answered));
    }

    function setIndicator(text, tone = 'muted') {
        indicator.textContent = text;
        indicator.className = 'chip text-[0.7rem] ' + (tone === 'error'
            ? 'bg-blush-soft text-ink'
            : 'bg-white text-ink-muted');
    }

    function markDirty(position, value) {
        pending.set(String(position), Number(value));
        window.clearTimeout(timer);
        timer = window.setTimeout(flush, 600);
    }

    async function flush() {
        if (saving || pending.size === 0) {
            return;
        }

        saving = true;
        const payload = Object.fromEntries(pending);
        setIndicator('Menyimpan…');

        try {
            const response = await fetch(saveUrl, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': csrf,
                },
                body: JSON.stringify({ answers: payload }),
            });

            if (response.status === 409 || response.status === 410) {
                const data = await response.json().catch(() => ({}));
                window.location.href = data.redirect ?? window.location.href;
                return;
            }

            if (!response.ok) {
                throw new Error(`Save failed with ${response.status}`);
            }

            const data = await response.json();
            Object.keys(payload).forEach((position) => pending.delete(position));
            progressBar.style.width = `${data.progress}%`;
            setIndicator(`Tersimpan ${new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })}`);
        } catch (error) {
            setIndicator('Gagal menyimpan, mencoba lagi…', 'error');
            window.setTimeout(flush, 2500);
        } finally {
            saving = false;

            if (pending.size > 0 && indicator.textContent.startsWith('Gagal') === false) {
                flush();
            }
        }
    }

    function missingPositions() {
        return Array.from(form.querySelectorAll('[data-answer-fieldset]'))
            .filter((fieldset) => !fieldset.querySelector('input[type="radio"]:checked'))
            .map((fieldset) => Number(fieldset.dataset.position));
    }

    form.addEventListener('change', (event) => {
        const input = event.target;

        if (!(input instanceof HTMLInputElement) || input.type !== 'radio') {
            return;
        }

        const fieldset = input.closest('[data-answer-fieldset]');
        fieldset?.classList.remove('ring-2', 'ring-blush');
        markDirty(fieldset.dataset.position, input.value);
        refreshProgress();
    });

    form.addEventListener('keydown', (event) => {
        const fieldset = document.activeElement?.closest('[data-answer-fieldset]');

        if (!fieldset || !['1', '2', '3', '4', '5'].includes(event.key)) {
            return;
        }

        const input = fieldset.querySelector(`input[type="radio"][value="${event.key}"]`);

        if (input) {
            event.preventDefault();
            input.checked = true;
            input.dispatchEvent(new Event('change', { bubbles: true }));
        }
    });

    form.addEventListener('submit', (event) => {
        const missing = missingPositions();

        if (missing.length === 0) {
            return;
        }

        event.preventDefault();
        const perPage = Math.max(1, Math.ceil(total / pageCount));
        const first = missing[0];
        activePage = Math.floor(first / perPage) + 1;
        render();

        const fieldset = form.querySelector(`[data-answer-fieldset][data-position="${first}"]`);
        fieldset?.classList.add('ring-2', 'ring-blush');
        fieldset?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setIndicator(`Masih ada ${missing.length} pernyataan kosong`, 'error');
    });

    prevButton.addEventListener('click', () => {
        activePage = Math.max(1, activePage - 1);
        render();
    });

    nextButton.addEventListener('click', () => {
        flush();
        activePage = Math.min(pageCount, activePage + 1);
        render();
    });

    window.addEventListener('beforeunload', (event) => {
        if (pending.size > 0) {
            event.preventDefault();
            event.returnValue = '';
        }
    });

    refreshProgress();
    render();
}
