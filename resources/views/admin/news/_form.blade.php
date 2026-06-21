@csrf
@if ($post->exists)
    @method('PUT')
@endif

@pushOnce('styles')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
@endPushOnce

<section class="grid gap-6 border-t border-cloud pt-8 lg:grid-cols-[260px_1fr]">
    <div>
        <h2 class="text-[1.0625rem] font-medium text-carbon">Konten berita</h2>
        <p class="mt-2 text-sm leading-6 text-pewter">Judul, ringkasan, dan isi utama berita.</p>
    </div>
    <div class="space-y-5">
        <div class="space-y-2">
            <label for="title" class="site-label">Judul</label>
            <input id="title" name="title" value="{{ old('title', $post->title) }}" class="site-field" required>
        </div>
        <div class="space-y-2">
            <label for="slug" class="site-label">Slug</label>
            <input id="slug" name="slug" value="{{ old('slug', $post->slug) }}" class="site-field">
            <p class="site-help">Kosongkan untuk dibuat otomatis dari judul.</p>
        </div>
        <div class="space-y-2">
            <label for="excerpt" class="site-label">Ringkasan</label>
            <textarea id="excerpt" name="excerpt" rows="3" class="site-field">{{ old('excerpt', $post->excerpt) }}</textarea>
        </div>
        <div class="space-y-2">
            <span id="content-label" class="site-label">Isi berita</span>
            <textarea id="content" name="content" rows="12" class="site-field" data-news-editor-input required>{{ old('content', $post->content) }}</textarea>
            <div
                class="news-editor-shell hidden"
                data-news-editor
                data-upload-url="{{ route('admin.news.content-images.store') }}"
                role="textbox"
                aria-labelledby="content-label"
            ></div>
            <p class="site-help">Gunakan toolbar untuk format teks, menambahkan tautan, daftar, kutipan, dan gambar di dalam isi berita.</p>
            <p class="hidden text-xs font-medium" data-news-editor-status role="status"></p>
        </div>
    </div>
</section>

<section class="grid gap-6 border-t border-cloud pt-8 lg:grid-cols-[260px_1fr]">
    <div>
        <h2 class="text-[1.0625rem] font-medium text-carbon">Publikasi</h2>
        <p class="mt-2 text-sm leading-6 text-pewter">Status terbit dan gambar berita.</p>
    </div>
    <div class="grid gap-5 md:grid-cols-2">
        <input type="hidden" name="is_published" value="0">
        <label class="flex items-center gap-2 text-sm text-graphite md:col-span-2">
            <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $post->is_published)) class="h-4 w-4 rounded-sm border-cloud">
            Terbitkan berita
        </label>
        <div class="space-y-2">
            <label for="published_at" class="site-label">Waktu terbit</label>
            <input id="published_at" name="published_at" type="datetime-local" value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}" class="site-field">
        </div>
        <div class="space-y-2">
            <label for="featured_image" class="site-label">Gambar berita</label>
            <input id="featured_image" name="featured_image" type="file" accept="image/*" class="site-field">
            @if ($post->featured_image_path)
                <label class="flex items-center gap-2 text-sm text-graphite">
                    <input type="checkbox" name="remove_featured_image" value="1" class="h-4 w-4 rounded-sm border-cloud">
                    Hapus gambar saat ini
                </label>
            @endif
        </div>
    </div>
</section>

<div class="flex flex-col gap-3 border-t border-cloud pt-8 sm:flex-row sm:justify-end">
    <a href="{{ route('admin.news.index') }}" class="site-button-muted w-full sm:w-[160px]">Batal</a>
    <button type="submit" class="site-button-primary w-full sm:w-[200px]">Simpan</button>
</div>
