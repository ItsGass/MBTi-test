const certificate = document.querySelector('#certificate');

if (certificate) {
    initCertificate(certificate);
}

function initCertificate(node) {
    const viewport = document.querySelector('[data-certificate-viewport]');
    const scaler = document.querySelector('[data-certificate-scale]');
    const button = document.querySelector('#certificate-download');
    const status = document.querySelector('#certificate-status');

    const width = node.offsetWidth || 1200;
    const height = node.offsetHeight || 1600;

    function fit() {
        if (!viewport || !scaler) {
            return;
        }

        const available = viewport.clientWidth;
        const scale = Math.min(1, available / width);

        scaler.style.transform = `scale(${scale})`;
        viewport.style.height = `${Math.round(height * scale)}px`;
    }

    fit();
    window.addEventListener('resize', fit);

    button?.addEventListener('click', async () => {
        button.disabled = true;
        button.style.opacity = '0.6';
        status.textContent = 'Menyiapkan gambar…';

        try {
            await document.fonts.ready;

            const { default: html2canvas } = await import('html2canvas');

            const canvas = await html2canvas(node, {
                scale: 2,
                backgroundColor: '#FFF9F5',
                useCORS: true,
                width,
                height,
                windowWidth: width,
                windowHeight: height,
                scrollX: 0,
                scrollY: -window.scrollY,
            });

            const link = document.createElement('a');
            link.download = node.dataset.file || 'sertifikat-mbti-insight.png';
            link.href = canvas.toDataURL('image/png');
            link.click();

            status.textContent = 'Sertifikat terunduh';
        } catch (error) {
            console.error(error);
            status.textContent = 'Gagal membuat sertifikat. Coba lagi.';
        } finally {
            button.disabled = false;
            button.style.opacity = '1';
        }
    });
}
