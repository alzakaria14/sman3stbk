const quillScriptUrls = [
    'https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js',
    'https://unpkg.com/quill@2.0.3/dist/quill.js',
];

const showEditorStatus = (statusElement, message, isError = false) => {
    statusElement.textContent = message;
    statusElement.classList.remove('hidden', 'text-red-600', 'text-pewter');
    statusElement.classList.add(isError ? 'text-red-600' : 'text-pewter');
};

const loadScript = (source) =>
    new Promise((resolve, reject) => {
        const script = document.createElement('script');

        script.src = source;
        script.async = true;
        script.addEventListener('load', resolve, { once: true });
        script.addEventListener('error', reject, { once: true });
        document.head.append(script);
    });

const loadQuill = async () => {
    if (window.Quill) {
        return window.Quill;
    }

    for (const scriptUrl of quillScriptUrls) {
        try {
            await loadScript(scriptUrl);

            if (window.Quill) {
                return window.Quill;
            }
        } catch {
            continue;
        }
    }

    throw new Error('Editor gagal dimuat. Periksa koneksi internet lalu muat ulang halaman.');
};

const uploadContentImage = async (file, uploadUrl) => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    const formData = new FormData();

    formData.append('image', file);

    const response = await fetch(uploadUrl, {
        method: 'POST',
        headers: {
            Accept: 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: formData,
        credentials: 'same-origin',
    });

    const responseBody = await response.json();

    if (!response.ok) {
        throw new Error(responseBody.message ?? 'Gambar gagal diunggah.');
    }

    return responseBody.url;
};

const createImageHandler = (quill, editorElement, statusElement) => () => {
    const fileInput = document.createElement('input');

    fileInput.type = 'file';
    fileInput.accept = 'image/jpeg,image/png,image/gif,image/webp';

    fileInput.addEventListener('change', async () => {
        const [file] = fileInput.files;

        if (!file) {
            return;
        }

        showEditorStatus(statusElement, 'Mengunggah gambar...');

        try {
            const imageUrl = await uploadContentImage(file, editorElement.dataset.uploadUrl);
            const range = quill.getSelection(true);

            quill.insertEmbed(range.index, 'image', imageUrl, 'user');
            quill.setSelection(range.index + 1, 0, 'silent');
            showEditorStatus(statusElement, 'Gambar berhasil ditambahkan.');
        } catch (error) {
            showEditorStatus(statusElement, error.message, true);
        }
    });

    fileInput.click();
};

const initializeNewsEditor = async () => {
    const editorElement = document.querySelector('[data-news-editor]');
    const inputElement = document.querySelector('[data-news-editor-input]');
    const statusElement = document.querySelector('[data-news-editor-status]');

    if (!editorElement || !inputElement || !statusElement) {
        return;
    }

    showEditorStatus(statusElement, 'Memuat editor...');

    try {
        const Quill = await loadQuill();

        editorElement.classList.remove('hidden');

        const quill = new Quill(editorElement, {
            bounds: editorElement,
            placeholder: 'Tulis isi berita...',
            theme: 'snow',
            modules: {
                toolbar: {
                    container: [
                        [{ header: [2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        [{ align: [] }],
                        ['blockquote'],
                        ['link', 'image'],
                        ['clean'],
                    ],
                },
            },
        });

        if (inputElement.value.trim() !== '') {
            quill.clipboard.dangerouslyPasteHTML(inputElement.value);
        }

        quill.getModule('toolbar').addHandler('image', createImageHandler(quill, editorElement, statusElement));

        inputElement.classList.add('hidden');
        inputElement.removeAttribute('required');
        inputElement.setAttribute('aria-hidden', 'true');
        statusElement.classList.add('hidden');

        inputElement.form?.addEventListener('submit', () => {
            inputElement.value = quill.getSemanticHTML();
        });
    } catch (error) {
        showEditorStatus(statusElement, error.message, true);
    }
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeNewsEditor, { once: true });
} else {
    initializeNewsEditor();
}
