@extends('layouts.admin')

@section('title', 'Projects')
@section('meta_desc', 'Admin panel untuk mengelola project portfolio personal website.')

@section('styles')
<style>
    .page-header {
        display: flex; align-items: flex-start;
        justify-content: space-between; margin-bottom: 36px;
    }

    .eyebrow {
        font-size: .7rem; font-weight: 700;
        letter-spacing: 1.5px; text-transform: uppercase;
        color: var(--c-cyan-l); margin-bottom: 6px;
        display: flex; align-items: center; gap: 6px;
    }

    .page-header h1 {
        font-size: 2rem; font-weight: 800; letter-spacing: -1px; line-height: 1.1;
        background: linear-gradient(135deg, #fff 50%, rgba(255,255,255,.5));
        -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
    }

    .page-header p { color: var(--c-txt-3); font-size: .82rem; margin-top: 6px; }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px; margin-bottom: 28px;
    }

    /* Project Grid */
    .project-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .project-card {
        background: rgba(255,255,255,.03);
        border: 1px solid var(--c-border);
        border-radius: var(--r); overflow: hidden;
        transition: transform .3s ease, border-color .3s ease, box-shadow .3s ease;
    }

    .project-card:hover {
        transform: translateY(-5px);
        border-color: rgba(6,182,212,.3);
        box-shadow: 0 20px 60px rgba(0,0,0,.4), 0 0 0 1px rgba(6,182,212,.1);
    }

    .card-thumb {
        height: 165px;
        background: linear-gradient(135deg, #0f0f1e, #0d1f2d);
        overflow: hidden; position: relative;
    }

    .card-thumb img {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform .5s ease;
    }

    .project-card:hover .card-thumb img { transform: scale(1.08); }

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
        background: linear-gradient(135deg, var(--c-cyan-l), var(--c-purple-l));
        -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        opacity: .4;
    }

    .card-thumb .no-img span { font-size: .75rem; opacity: .4; }

    .card-body { padding: 16px 18px; }

    .card-title {
        font-size: .94rem; font-weight: 700; color: var(--c-txt);
        margin-bottom: 8px;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }

    .card-desc {
        font-size: .78rem; color: var(--c-txt-2); line-height: 1.65;
        display: -webkit-box; -webkit-line-clamp: 2;
        -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 12px;
    }

    .tech-strip { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 12px; }

    .tech-chip {
        width: 28px; height: 28px;
        background: rgba(255,255,255,.05);
        border: 1px solid var(--c-border);
        border-radius: var(--r-xs);
        display: flex; align-items: center; justify-content: center;
        overflow: hidden; transition: transform .2s;
    }

    .tech-chip:hover { transform: scale(1.15); border-color: rgba(6,182,212,.3); }
    .tech-chip img { width: 18px; height: 18px; object-fit: contain; }

    .card-footer {
        display: flex; align-items: center; justify-content: space-between;
        padding-top: 12px; border-top: 1px solid rgba(255,255,255,.05);
    }

    .empty { text-align: center; padding: 70px 20px; }

    .empty-illus {
        width: 80px; height: 80px; border-radius: 50%;
        background: rgba(6,182,212,.08); border: 1px solid rgba(6,182,212,.12);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px; font-size: 2rem; color: var(--c-cyan-l); opacity: .5;
    }

    .empty h3 { font-size: .95rem; font-weight: 700; color: var(--c-txt-2); margin-bottom: 6px; }
    .empty p  { font-size: .8rem; color: var(--c-txt-3); }

    .edit-slide { background: rgba(6,182,212,.03); }
    .einput:focus, .etextarea:focus { border-color: var(--c-cyan); background: rgba(6,182,212,.05); }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .page-header { flex-direction: column; gap: 14px; align-items: flex-start; }
        .page-header h1 { font-size: 1.6rem; }
        .stats-row { grid-template-columns: 1fr 1fr; gap: 12px; }
        .project-grid { grid-template-columns: 1fr; }
        .card-head { flex-direction: column; align-items: flex-start; }
        .search-wrap { width: 100%; }
        .search-wrap input { width: 100% !important; }
    }

    @media (max-width: 480px) {
        .stats-row { grid-template-columns: 1fr; }
        .page-header h1 { font-size: 1.4rem; }
        .card-footer { flex-direction: column; align-items: flex-start; gap: 10px; }
        .card-footer > div { width: 100%; display: flex; gap: 8px; }
        .card-footer .btn-ghost { width: 100%; justify-content: center; }
        .thumb-row { flex-direction: column; align-items: flex-start; }
        .drop-zone { padding: 18px 12px; }
    }
</style>
@endsection

@section('content')

<div class="page-header anim">
    <div>
        <div class="eyebrow"><i class="fas fa-circle-dot"></i> Portfolio Management</div>
        <h1>Projects</h1>
        <p>Kelola semua project portfolio kamu dari sini</p>
    </div>
    <div style="display:flex;gap:10px;">
        <a href="/api/projects" target="_blank" class="btn btn-ghost btn-sm">
            <i class="fas fa-external-link-alt"></i> API
        </a>
    </div>
</div>

<!-- Stats -->
<div class="stats-row">
    <div class="stat-box v-cyan anim">
        <div class="stat-label">Total Projects</div>
        <div class="stat-num">{{ $projects->count() }}</div>
        <div class="stat-icon"><i class="fas fa-folder-open"></i></div>
    </div>
    <div class="stat-box v-purple anim anim-d1">
        <div class="stat-label">Dengan Tech Stack</div>
        <div class="stat-num">{{ $projects->filter(fn($p) => $p->tech && $p->tech !== 'null')->count() }}</div>
        <div class="stat-icon"><i class="fas fa-code"></i></div>
    </div>
</div>

<!-- Create Form -->
<div class="card anim anim-d1">
    <div class="card-head">
        <div class="card-title">
            <span class="s-ico purple"><i class="fas fa-plus"></i></span>
            Tambah Project Baru
        </div>
        <button class="btn btn-ghost btn-sm" onclick="toggleCreate('createBody','createChev')">
            <i class="fas fa-chevron-up" id="createChev"></i>
        </button>
    </div>
    <div class="card-body" id="createBody">
        <form method="POST" action="{{ route('projects.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-grid">
                <div class="fg">
                    <label class="flabel">Judul Project <span class="req">*</span></label>
                    <input type="text" name="judul" class="finput" placeholder="Masukkan judul..." required>
                </div>
                <div class="fg">
                    <label class="flabel">URL Demo <span class="req">*</span></label>
                    <input type="text" name="url" class="finput" placeholder="https://example.com" required>
                </div>
                <div class="fg full">
                    <label class="flabel">Deskripsi <span class="req">*</span></label>
                    <textarea name="deskripsi" class="ftextarea" placeholder="Jelaskan project kamu..." required></textarea>
                </div>
                <div class="fg">
                    <label class="flabel">Foto Project <span class="req">*</span></label>
                    <div class="drop-zone" id="mainDrop">
                        <input type="file" name="foto" id="mainFoto" accept="image/*"
                            onchange="previewImg(this,'mainPrev')">
                        <div class="drop-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                        <div class="drop-text">Upload thumbnail project</div>
                        <div class="drop-sub">JPEG, PNG, WebP, GIF</div>
                        <img id="mainPrev" class="img-preview" alt="Preview">
                    </div>
                </div>
                <div class="fg">
                    <label class="flabel">Icon Tech Stack</label>
                    <div class="drop-zone" id="techDrop">
                        <input type="file" name="tech[]" id="mainTech" multiple accept="image/*"
                            onchange="previewTech(this,'techPrev')">
                        <div class="drop-icon" style="background:linear-gradient(135deg,var(--c-cyan-l),var(--c-purple-l));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                            <i class="fas fa-code"></i>
                        </div>
                        <div class="drop-text">Upload icon tech stack</div>
                        <div class="drop-sub">Multiple file diperbolehkan</div>
                        <div id="techPrev" class="tech-strip" style="justify-content:center;margin-top:10px;"></div>
                    </div>
                </div>
            </div>
            <div class="hr"></div>
            <div style="display:flex;justify-content:flex-end;gap:10px;">
                <button type="reset" class="btn btn-ghost btn-sm"
                    onclick="document.getElementById('mainPrev').style.display='none';document.getElementById('techPrev').innerHTML=''">
                    <i class="fas fa-rotate-left"></i> Reset
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-floppy-disk"></i> Simpan Project
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Project List -->
<div class="card anim anim-d2">
    <div class="card-head">
        <div class="card-title">
            <span class="s-ico cyan"><i class="fas fa-list-ul"></i></span>
            Daftar Projects
            <span class="tag tag-cyan">{{ $projects->count() }} total</span>
        </div>
        <div class="search-wrap">
            <i class="fas fa-magnifying-glass search-ico"></i>
            <input type="text" placeholder="Cari project..." oninput="filterCards(this.value,'project-card')">
        </div>
    </div>
    <div class="card-body">
        @if ($projects->isEmpty())
            <div class="empty">
                <div class="empty-illus"><i class="fas fa-folder-open"></i></div>
                <h3>Belum ada project</h3>
                <p>Tambahkan project pertamamu menggunakan form di atas.</p>
            </div>
        @else
            <div class="project-grid">
                @foreach ($projects as $i => $project)
                    <div class="project-card" data-search="{{ strtolower($project->judul) }}"
                        id="pc-{{ $project->id }}"
                        style="animation: fadeUp .5s ease {{ $i * 0.05 }}s both;">
                        <div class="card-thumb">
                            @if ($project->image_url)
                                <img src="{{ $project->image_url }}" alt="{{ $project->judul }}">
                            @else
                                <div class="no-img">
                                    <i class="fas fa-image"></i>
                                    <span>No image</span>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="card-title">{{ $project->judul }}</div>
                            <div class="card-desc">{{ $project->deskripsi }}</div>
                            @if ($project->tech && $project->tech !== 'null')
                                <div class="tech-strip">
                                    @foreach (json_decode($project->tech) ?? [] as $tech)
                                        <div class="tech-chip"><img src="{{ $tech }}" alt="tech"></div>
                                    @endforeach
                                </div>
                            @endif
                            <div class="card-footer">
                                <a href="{{ $project->url }}" target="_blank" class="btn btn-ghost btn-sm">
                                    <i class="fas fa-arrow-up-right-from-square"></i> Demo
                                </a>
                                <div style="display:flex;gap:6px;">
                                    <button type="button" class="btn btn-warn btn-sm btn-ico"
                                        onclick="toggleEdit('pe-{{ $project->id }}','pc-{{ $project->id }}')" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm btn-ico"
                                        onclick="openDel({{ $project->id }},'{{ addslashes($project->judul) }}','projects')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Edit Slide -->
                        <div class="edit-slide" id="pe-{{ $project->id }}">
                            <div class="edit-body">
                                <form method="POST" action="{{ route('projects.update', $project->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="edit-grid">
                                        <div>
                                            <span class="elabel">Judul *</span>
                                            <input type="text" name="judul" class="einput" value="{{ $project->judul }}" required>
                                        </div>
                                        <div>
                                            <span class="elabel">Deskripsi *</span>
                                            <textarea name="deskripsi" class="etextarea" rows="2">{{ $project->deskripsi }}</textarea>
                                        </div>
                                        <div>
                                            <span class="elabel">URL *</span>
                                            <input type="text" name="url" class="einput" value="{{ $project->url }}" required>
                                        </div>
                                        <div>
                                            <span class="elabel">Ganti Foto</span>
                                            <div class="thumb-row">
                                                @if ($project->image_url)
                                                    <img src="{{ $project->image_url }}" class="e-thumb" id="et-{{ $project->id }}" alt="thumb">
                                                @endif
                                                <label class="upload-btn-fake">
                                                    <i class="fas fa-upload"></i> Ganti Foto
                                                    <input type="file" name="foto" style="display:none" accept="image/*"
                                                        onchange="updateThumb(this,'et-{{ $project->id }}')">
                                                </label>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="elabel">Tech Stack (tambah)</span>
                                            <div class="tech-strip" style="margin-bottom:8px;">
                                                @foreach (json_decode($project->tech) ?? [] as $tech)
                                                    <div class="tech-chip"><img src="{{ $tech }}" alt="tech"></div>
                                                @endforeach
                                            </div>
                                            <label class="upload-btn-fake">
                                                <i class="fas fa-code"></i> Tambah Icons
                                                <input type="file" name="tech[]" multiple style="display:none" accept="image/*">
                                            </label>
                                            <input type="hidden" name="keep_tech" value="1">
                                        </div>
                                    </div>
                                    <div class="hr" style="margin:12px 0;"></div>
                                    <div style="display:flex;justify-content:flex-end;gap:8px;">
                                        <button type="button" class="btn btn-ghost btn-sm"
                                            onclick="toggleEdit('pe-{{ $project->id }}','pc-{{ $project->id }}')">
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
        <div class="modal-title">Hapus Project</div>
        <div class="modal-desc" id="delDesc">Kamu yakin?</div>
        <div class="modal-actions">
            <button class="btn btn-ghost btn-sm" onclick="closeDel()">
                <i class="fas fa-xmark"></i> Batal
            </button>
            <form id="delForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function previewTech(input, containerId) {
        const c = document.getElementById(containerId);
        c.innerHTML = '';
        Array.from(input.files).forEach(f => {
            const r = new FileReader();
            const chip = document.createElement('div');
            chip.className = 'tech-chip';
            r.onload = e => { chip.innerHTML = `<img src="${e.target.result}" alt="tech">`; };
            r.readAsDataURL(f);
            c.appendChild(chip);
        });
    }
</script>
@endsection
