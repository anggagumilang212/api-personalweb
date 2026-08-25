@extends('layouts.admin')

@section('title', 'Blog Posts')
@section('meta_desc', 'Admin panel untuk mengelola artikel blog personal website.')

@section('styles')
<style>
    /* ── PAGE HEADER ── */
    .page-header {
        display: flex; align-items: flex-start;
        justify-content: space-between; margin-bottom: 48px;
        flex-wrap: wrap; gap: 24px;
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
    <div style="display:flex; gap: 10px; align-items: center;">
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

<!-- Blog List -->
<div class="card anim anim-d2">
    <div class="card-head">
        <div class="card-title">
            <span class="s-ico cyan"><i class="fas fa-list-ul"></i></span>
            Daftar Artikel
            <span class="tag tag-purple">{{ $blogs->count() }} total</span>
        </div>
        <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
            <div class="search-wrap">
                <i class="fas fa-magnifying-glass search-ico"></i>
                <input type="text" placeholder="Cari artikel..." oninput="filterCards(this.value,'blog-card')">
            </div>
            <button class="btn btn-primary" onclick="openFormModal('create')">
                <i class="fas fa-plus"></i> Tambah Blog Baru
            </button>
        </div>
    </div>
    <div class="card-body">
        @if ($blogs->isEmpty())
            <div class="empty">
                <div class="empty-illus"><i class="fas fa-newspaper"></i></div>
                <h3>Belum ada artikel</h3>
                <p>Mulai tulis artikel pertamamu dengan menekan tombol Tambah Blog Baru.</p>
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
                                        onclick='openFormModal("edit", @json($blog))' title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm btn-ico"
                                        onclick="openDel({{ $blog->id }},'{{ addslashes($blog->title) }}','blogs')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
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

<!-- FORM MODAL (Create/Edit) -->
<div class="overlay" id="formOverlay">
    <div class="modal-box modal-box-lg">
        <div class="modal-title" id="formModalTitle">Tambah Blog Baru</div>
        <div class="modal-desc" id="formModalDesc">Isi form di bawah ini untuk menambahkan artikel blog.</div>
        
        <form id="blogForm" method="POST" action="{{ route('blogs.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            
            <div class="form-grid">
                <div class="fg">
                    <label class="flabel">Judul Artikel <span class="req">*</span></label>
                    <input type="text" name="title" id="inputTitle" class="finput" placeholder="Masukkan judul..." required>
                </div>
                <div class="fg">
                    <label class="flabel">Tanggal Publish</label>
                    <input type="datetime-local" name="published_at" id="inputPublishedAt" class="finput">
                </div>
                <div class="fg full">
                    <label class="flabel">Deskripsi Singkat</label>
                    <textarea name="description" id="inputDescription" class="ftextarea" placeholder="Ringkasan singkat artikel..."></textarea>
                </div>
                <div class="fg full">
                    <label class="flabel">Body Markdown</label>
                    <textarea name="body_markdown" id="inputBodyMarkdown" class="ftextarea fmono" style="min-height:130px;"
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
            <div class="hr" style="margin:24px 0 16px;"></div>
            <div style="display:flex;justify-content:flex-end;gap:10px;">
                <button type="button" class="btn btn-ghost" onclick="closeFormModal()">
                    <i class="fas fa-xmark"></i> Batal
                </button>
                <button type="submit" class="btn btn-primary" id="btnSubmitForm">
                    <i class="fas fa-floppy-disk"></i> Simpan Artikel
                </button>
            </div>
        </form>
    </div>
</div>

<!-- DELETE MODAL -->
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

    function openFormModal(mode, data = null) {
        const form = document.getElementById('blogForm');
        const title = document.getElementById('formModalTitle');
        const desc = document.getElementById('formModalDesc');
        const method = document.getElementById('formMethod');
        const btnSubmit = document.getElementById('btnSubmitForm');
        
        // Reset previews
        document.getElementById('mainPrev').style.display = 'none';
        document.getElementById('mainPrev').src = '';
        
        if (mode === 'create') {
            form.reset();
            title.innerHTML = 'Tambah Blog Baru';
            desc.innerHTML = 'Isi form di bawah ini untuk menambahkan artikel blog.';
            method.value = 'POST';
            form.action = "{{ route('blogs.store') }}";
            btnSubmit.innerHTML = '<i class="fas fa-floppy-disk"></i> Simpan Artikel';
        } else if (mode === 'edit' && data) {
            form.reset();
            title.innerHTML = 'Edit Blog';
            desc.innerHTML = 'Perbarui artikel blog kamu.';
            method.value = 'PUT';
            form.action = `/blogs/${data.id}`;
            btnSubmit.innerHTML = '<i class="fas fa-floppy-disk"></i> Update Artikel';
            
            // Populate fields
            document.getElementById('inputTitle').value = data.title;
            document.getElementById('inputDescription').value = data.description || '';
            document.getElementById('inputBodyMarkdown').value = data.body_markdown || '';
            
            if (data.published_at) {
                // Konversi tanggal ke format yang diterima input datetime-local (YYYY-MM-DDTHH:mm)
                const date = new Date(data.published_at);
                const isoString = new Date(date.getTime() - (date.getTimezoneOffset() * 60000)).toISOString().slice(0,16);
                document.getElementById('inputPublishedAt').value = isoString;
            } else {
                document.getElementById('inputPublishedAt').value = '';
            }
            
            // Previews
            if (data.cover_image) {
                document.getElementById('mainPrev').src = `/cover_images/${data.cover_image}`;
                document.getElementById('mainPrev').style.display = 'block';
            }
        }
        
        document.getElementById('formOverlay').classList.add('open');
    }

    function closeFormModal() {
        document.getElementById('formOverlay').classList.remove('open');
    }

    // Close form modal when clicking outside
    document.addEventListener('DOMContentLoaded', () => {
        const formOverlay = document.getElementById('formOverlay');
        if (formOverlay) {
            formOverlay.addEventListener('click', e => { 
                if (e.target === formOverlay) closeFormModal(); 
            });
        }
    });
</script>
@endsection
