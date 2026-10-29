const certificate = document.querySelector('#certificate');

if (certificate) {
    initCertificate(certificate);
}

function initCertificate(node) {
    const viewport = document.querySelector('[data-certificate-viewport]');
    const scaler = document.querySelector('[data-certificate-scale]');
    const button = document.querySelector('#certificate-download');
    const status = document.querySelector('#certificate-status');

    const width = Number(node.dataset.width) || node.offsetWidth || 1200;
    const height = Number(node.dataset.height) || node.offsetHeight || 850;
    const exportScale = Number(node.dataset.scale) || 2;

    function fit() {
        if (!viewport || !scaler) {
            return;
        }

        const available = viewport.clientWidth;
        const scale = Math.min(1, available / width);
        const offset = Math.max(0, (available - width * scale) / 2);

        scaler.style.transformOrigin = 'top left';
        scaler.style.transform = `translateX(${offset}px) scale(${scale})`;
        viewport.style.height = `${Math.round(height * scale)}px`;
    }

    fit();
    window.addEventListener('resize', fit);

    button?.addEventListener('click', async () => {
        button.disabled = true;
        button.style.opacity = '0.6';
        status.textContent = 'Menyiapkan gambar…';

        // html2canvas measures the live node, so drop the preview transform first.
        const previousTransform = scaler?.style.transform ?? '';
        const previousHeight = viewport?.style.height ?? '';
        const previousOverflow = viewport?.style.overflow ?? '';

        try {
            if (scaler) {
                scaler.style.transform = 'none';
            }

            if (viewport) {
                viewport.style.height = `${height}px`;
                viewport.style.overflow = 'visible';
            }

            await document.fonts.ready;
            await new Promise((resolve) => window.requestAnimationFrame(() => resolve()));

            const { default: html2canvas } = await import('html2canvas');

            const canvas = await html2canvas(node, {
                scale: exportScale,
                backgroundColor: '#FFF9F5',
                useCORS: true,
                logging: false,
                width,
                height,
                windowWidth: width,
                windowHeight: height,
                scrollX: 0,
                scrollY: -window.scrollY,
                onclone: (clonedDocument) => {
                    const clonedScaler = clonedDocument.querySelector('[data-certificate-scale]');

                    if (clonedScaler) {
                        clonedScaler.style.transform = 'none';
                    }
                },
            });

            const link = document.createElement('a');
            link.download = node.dataset.file || 'sertifikat-mbti-insight.png';
            link.href = canvas.toDataURL('image/png');
            link.click();

            status.textContent = `Sertifikat terunduh · ${width * exportScale} × ${height * exportScale}`;
        } catch (error) {
            console.error(error);
            status.textContent = 'Gagal membuat sertifikat. Coba lagi.';
        } finally {
            if (scaler) {
                scaler.style.transform = previousTransform;
            }

            if (viewport) {
                viewport.style.height = previousHeight;
                viewport.style.overflow = previousOverflow;
            }

            button.disabled = false;
            button.style.opacity = '1';
            fit();
        }
    });
}
