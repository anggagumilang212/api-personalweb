@extends('layouts.admin')

@section('title', 'Blog Posts')
@section('meta_desc', 'Admin panel untuk mengelola artikel blog personal website.')

@section('styles')
<style>
    /* ── PAGE HEADER ── */
    .page-header {
        display: flex; align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 36px;
    }

    .eyebrow {
        font-size: .7rem; font-weight: 700;
        letter-spacing: 1.5px; text-transform: uppercase;
        color: var(--c-purple-l); margin-bottom: 6px;
        display: flex; align-items: center; gap: 6px;
    }

    .page-header h1 {
        font-size: 2rem; font-weight: 800;
        letter-spacing: -1px; line-height: 1.1;
        background: linear-gradient(135deg, #fff 50%, rgba(255,255,255,.5));
        -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
    }

    .page-header p { color: var(--c-txt-3); font-size: .82rem; margin-top: 6px; }

    /* ── STATS ── */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px; margin-bottom: 28px;
    }

    /* ── BLOG GRID ── */
    .blog-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .blog-card {
        background: rgba(255,255,255,.03);
        border: 1px solid var(--c-border);
        border-radius: var(--r);
        overflow: hidden;
        transition: transform .3s ease, border-color .3s ease, box-shadow .3s ease;
    }

    .blog-card:hover {
        transform: translateY(-5px);
        border-color: rgba(139,92,246,.3);
        box-shadow: 0 20px 60px rgba(0,0,0,.4), 0 0 0 1px rgba(139,92,246,.1);
    }

    .card-thumb {
        height: 165px;
        background: linear-gradient(135deg, #0f0f1e, #1a1035);
        overflow: hidden; position: relative;
    }

    .card-thumb img {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform .5s ease;
    }

    .blog-card:hover .card-thumb img { transform: scale(1.08); }

    .card-thumb::after {
        content: ''; position: absolute;
        bottom: 0; left: 0; right: 0; height: 60%;
        background: linear-gradient(to top, rgba(7,7,17,.7), transparent);
    }

    .card-thumb .no-img {
        width: 100%; height: 100%;
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        gap: 10px; color: var(--c-txt-3);
    }

    .card-thumb .no-img i {
        font-size: 2.2rem;
        background: linear-gradient(135deg, var(--c-purple-l), var(--c-cyan-l));
        -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        opacity: .4;
    }

    .card-thumb .no-img span { font-size: .75rem; opacity: .4; }

    .status-tag {
        position: absolute; top: 12px; right: 12px; z-index: 2;
        padding: 4px 10px; border-radius: 20px;
        font-size: .62rem; font-weight: 800;
        letter-spacing: .5px; text-transform: uppercase;
    }

    .status-tag.published {
        background: rgba(16,185,129,.2); color: #34d399;
        border: 1px solid rgba(16,185,129,.25);
        box-shadow: 0 0 12px rgba(16,185,129,.12);
    }

    .status-tag.draft {
        background: rgba(245,158,11,.15); color: #fbbf24;
        border: 1px solid rgba(245,158,11,.2);
    }

    .card-body { padding: 16px 18px; }

    .card-title {
        font-size: .94rem; font-weight: 700; color: var(--c-txt);
        line-height: 1.45; margin-bottom: 8px;
        display: -webkit-box; -webkit-line-clamp: 2;
        -webkit-box-orient: vertical; overflow: hidden;
    }

    .card-desc {
        font-size: .78rem; color: var(--c-txt-2); line-height: 1.65;
        display: -webkit-box; -webkit-line-clamp: 2;
        -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 12px;
    }

    .card-meta {
        display: flex; flex-wrap: wrap; gap: 10px;
        font-size: .7rem; color: var(--c-txt-3); margin-bottom: 14px;
    }

    .card-meta span { display: flex; align-items: center; gap: 5px; }
    .card-meta i { color: var(--c-purple-l); opacity: .6; }

    .card-footer {
        display: flex; align-items: center; justify-content: space-between;
        padding-top: 12px; border-top: 1px solid rgba(255,255,255,.05);
    }

    .card-slug {
        font-family: 'JetBrains Mono', monospace;
        font-size: .64rem; color: var(--c-txt-3);
        background: rgba(255,255,255,.04);
        padding: 3px 8px; border-radius: 4px;
        max-width: 160px; overflow: hidden;
        text-overflow: ellipsis; white-space: nowrap;
    }

    /* ── EMPTY ── */
    .empty { text-align: center; padding: 70px 20px; }

    .empty-illus {
        width: 80px; height: 80px; border-radius: 50%;
        background: rgba(139,92,246,.08);
        border: 1px solid rgba(139,92,246,.12);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px; font-size: 2rem;
        color: var(--c-purple-l); opacity: .5;
    }

    .empty h3 { font-size: .95rem; font-weight: 700; color: var(--c-txt-2); margin-bottom: 6px; }
    .empty p  { font-size: .8rem; color: var(--c-txt-3); }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .page-header { flex-direction: column; gap: 14px; align-items: flex-start; }
        .page-header h1 { font-size: 1.6rem; }
        .stats-row { grid-template-columns: 1fr 1fr; gap: 12px; }
        .blog-grid { grid-template-columns: 1fr; }
        .card-head { flex-direction: column; align-items: flex-start; }
        .search-wrap { width: 100%; }
        .search-wrap input { width: 100% !important; }
    }

    @media (max-width: 480px) {
        .stats-row { grid-template-columns: 1fr; }
        .page-header h1 { font-size: 1.4rem; }
        .card-footer { flex-direction: column; align-items: flex-start; gap: 10px; }
        .card-footer > div { width: 100%; display: flex; gap: 8px; }
        .thumb-row { flex-direction: column; align-items: flex-start; }
        .drop-zone { padding: 18px 12px; }
    }
</style>
@endsection

@section('content')

<!-- Page Header -->
<div class="page-header anim">
    <div>
        <div class="eyebrow"><i class="fas fa-circle-dot"></i> Content Management</div>
        <h1>Blog Posts</h1>
        <p>Tulis, kelola, dan publish artikel dari sini</p>
    </div>
    <div style="display:flex;gap:10px;align-items:center;">
        <a href="/api/blogs" target="_blank" class="btn btn-ghost btn-sm">
            <i class="fas fa-external-link-alt"></i> API
        </a>
    </div>
</div>

<!-- Stats -->
<div class="stats-row">
    <div class="stat-box v-purple anim">
        <div class="stat-label">Total Artikel</div>
        <div class="stat-num">{{ $blogs->count() }}</div>
        <div class="stat-icon"><i class="fas fa-newspaper"></i></div>
    </div>
    <div class="stat-box v-cyan anim anim-d1">
        <div class="stat-label">Published</div>
        <div class="stat-num">{{ $blogs->whereNotNull('published_at')->count() }}</div>
        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
    </div>
    <div class="stat-box v-green anim anim-d2">
        <div class="stat-label">Draft</div>
        <div class="stat-num">{{ $blogs->whereNull('published_at')->count() }}</div>
        <div class="stat-icon"><i class="fas fa-pencil"></i></div>
    </div>
</div>

<!-- Create Form -->
<div class="card anim anim-d1">
    <div class="card-head">
        <div class="card-title">
            <span class="s-ico purple"><i class="fas fa-plus"></i></span>
            Tambah Blog Baru
        </div>
        <button class="btn btn-ghost btn-sm" onclick="toggleCreate('createBody','createChev')">
            <i class="fas fa-chevron-up" id="createChev"></i>
        </button>
    </div>
    <div class="card-body" id="createBody">
        <form method="POST" action="{{ route('blogs.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-grid">
                <div class="fg">
                    <label class="flabel">Judul Artikel <span class="req">*</span></label>
                    <input type="text" name="title" class="finput" placeholder="Masukkan judul..." required>
                </div>
                <div class="fg">
                    <label class="flabel">Tanggal Publish</label>
                    <input type="datetime-local" name="published_at" class="finput">
                </div>
                <div class="fg full">
                    <label class="flabel">Deskripsi Singkat</label>
                    <textarea name="description" class="ftextarea" placeholder="Ringkasan singkat artikel..."></textarea>
                </div>
                <div class="fg full">
                    <label class="flabel">Body Markdown</label>
                    <textarea name="body_markdown" class="ftextarea fmono" style="min-height:130px;"
                        placeholder="# Judul&#10;&#10;## Heading 2&#10;&#10;Tulis konten di sini..."></textarea>
                </div>
                <div class="fg full">
                    <label class="flabel">Cover Image</label>
                    <div class="drop-zone" id="mainDrop">
                        <input type="file" name="cover_image" id="mainFile" accept="image/*"
                            onchange="previewImg(this,'mainPrev')">
                        <div class="drop-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                        <div class="drop-text">Klik atau drag &amp; drop gambar</div>
                        <div class="drop-sub">JPEG, PNG, WebP · maks. 4MB</div>
                        <img id="mainPrev" class="img-preview" alt="Preview">
                    </div>
                </div>
            </div>
            <div class="hr"></div>
            <div style="display:flex;justify-content:flex-end;gap:10px;">
                <button type="reset" class="btn btn-ghost btn-sm" onclick="document.getElementById('mainPrev').style.display='none'">
                    <i class="fas fa-rotate-left"></i> Reset
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-floppy-disk"></i> Simpan Artikel
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Blog List -->
<div class="card anim anim-d2">
    <div class="card-head">
        <div class="card-title">
            <span class="s-ico cyan"><i class="fas fa-list-ul"></i></span>
            Daftar Artikel
            <span class="tag tag-purple">{{ $blogs->count() }} total</span>
        </div>
        <div class="search-wrap">
            <i class="fas fa-magnifying-glass search-ico"></i>
            <input type="text" placeholder="Cari artikel..." oninput="filterCards(this.value,'blog-card')">
        </div>
    </div>
    <div class="card-body">
        @if ($blogs->isEmpty())
            <div class="empty">
                <div class="empty-illus"><i class="fas fa-newspaper"></i></div>
                <h3>Belum ada artikel</h3>
                <p>Mulai tulis artikel pertamamu menggunakan form di atas.</p>
            </div>
        @else
            <div class="blog-grid">
                @foreach ($blogs as $i => $blog)
                    <div class="blog-card" data-search="{{ strtolower($blog->title) }}"
                        id="bc-{{ $blog->id }}"
                        style="animation: fadeUp .5s ease {{ $i * 0.05 }}s both;">
                        <!-- Thumb -->
                        <div class="card-thumb">
                            @if ($blog->cover_image)
                                <img src="{{ asset('cover_images/' . $blog->cover_image) }}" alt="{{ $blog->title }}">
                            @else
                                <div class="no-img">
                                    <i class="fas fa-image"></i>
                                    <span>No cover image</span>
                                </div>
                            @endif
                            <span class="status-tag {{ $blog->published_at ? 'published' : 'draft' }}">
                                <i class="fas {{ $blog->published_at ? 'fa-check' : 'fa-pencil' }}"></i>
                                {{ $blog->published_at ? 'Live' : 'Draft' }}
                            </span>
                        </div>
                        <!-- Body -->
                        <div class="card-body">
                            <div class="card-title">{{ $blog->title }}</div>
                            @if ($blog->description)
                                <div class="card-desc">{{ $blog->description }}</div>
                            @endif
                            <div class="card-meta">
                                <span><i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($blog->created_at)->format('d M Y') }}</span>
                                @if ($blog->published_at)
                                    <span><i class="fas fa-rocket"></i> {{ \Carbon\Carbon::parse($blog->published_at)->format('d M Y, H:i') }}</span>
                                @endif
                            </div>
                            <div class="card-footer">
                                <span class="card-slug">/{{ $blog->slug }}</span>
                                <div style="display:flex;gap:6px;">
                                    <button type="button" class="btn btn-warn btn-sm btn-ico"
                                        onclick="toggleEdit('be-{{ $blog->id }}','bc-{{ $blog->id }}')" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm btn-ico"
                                        onclick="openDel({{ $blog->id }},'{{ addslashes($blog->title) }}','blogs')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Edit Slide -->
                        <div class="edit-slide" id="be-{{ $blog->id }}">
                            <div class="edit-body">
                                <form method="POST" action="{{ route('blogs.update', $blog->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="edit-grid">
                                        <div>
                                            <span class="elabel">Judul *</span>
                                            <input type="text" name="title" class="einput" value="{{ $blog->title }}" required>
                                        </div>
                                        <div>
                                            <span class="elabel">Deskripsi</span>
                                            <textarea name="description" class="etextarea" rows="2">{{ $blog->description }}</textarea>
                                        </div>
                                        <div>
                                            <span class="elabel">Body Markdown</span>
                                            <textarea name="body_markdown" class="etextarea fmono" rows="3">{{ $blog->body_markdown }}</textarea>
                                        </div>
                                        <div>
                                            <span class="elabel">Tanggal Publish</span>
                                            <input type="datetime-local" name="published_at" class="einput"
                                                value="{{ $blog->published_at ? \Carbon\Carbon::parse($blog->published_at)->format('Y-m-d\TH:i') : '' }}">
                                        </div>
                                        <div>
                                            <span class="elabel">Cover Image</span>
                                            <div class="thumb-row">
                                                @if ($blog->cover_image)
                                                    <img src="{{ asset('cover_images/'.$blog->cover_image) }}"
                                                        class="e-thumb" id="et-{{ $blog->id }}" alt="thumb">
                                                @else
                                                    <div class="e-thumb" id="et-{{ $blog->id }}"
                                                        style="background:rgba(255,255,255,.04);display:flex;align-items:center;justify-content:center;color:var(--c-txt-3);">
                                                        <i class="fas fa-image"></i>
                                                    </div>
                                                @endif
                                                <label class="upload-btn-fake">
                                                    <i class="fas fa-upload"></i> Ganti Gambar
                                                    <input type="file" name="cover_image" style="display:none" accept="image/*"
                                                        onchange="updateThumb(this,'et-{{ $blog->id }}')">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hr" style="margin:12px 0;"></div>
                                    <div style="display:flex;justify-content:flex-end;gap:8px;">
                                        <button type="button" class="btn btn-ghost btn-sm"
                                            onclick="toggleEdit('be-{{ $blog->id }}','bc-{{ $blog->id }}')">
                                            <i class="fas fa-xmark"></i> Batal
                                        </button>
                                        <button type="submit" class="btn btn-warn btn-sm">
                                            <i class="fas fa-floppy-disk"></i> Update
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@endsection

@section('modal')
<div class="overlay" id="delOverlay">
    <div class="modal-box">
        <div class="modal-icon"><i class="fas fa-triangle-exclamation"></i></div>
        <div class="modal-title">Hapus Artikel</div>
        <div class="modal-desc" id="delDesc">Kamu yakin?</div>
        <div class="modal-actions">
            <button class="btn btn-ghost btn-sm" onclick="closeDel()">
                <i class="fas fa-xmark"></i> Batal
            </button>
            <form id="delForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash"></i> Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    /* Drag & Drop */
    (function() {
        const zone  = document.getElementById('mainDrop');
        const input = document.getElementById('mainFile');
        if (!zone || !input) return;
        zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('drag-over'); });
        zone.addEventListener('dragleave', () => zone.classList.remove('drag-over'));
        zone.addEventListener('drop', e => {
            e.preventDefault(); zone.classList.remove('drag-over');
            const f = e.dataTransfer.files[0];
            if (f && f.type.startsWith('image/')) {
                const dt = new DataTransfer(); dt.items.add(f); input.files = dt.files;
                previewImg(input, 'mainPrev');
            }
        });
    })();
</script>
@endsection
