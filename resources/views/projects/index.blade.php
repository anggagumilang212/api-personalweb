@extends('layouts.admin')

@section('title', 'Projects')
@section('meta_desc', 'Admin panel untuk mengelola project portfolio personal website.')

@section('styles')
<style>
    .page-header {
        display: flex; align-items: flex-start;
        justify-content: space-between; margin-bottom: 48px;
        flex-wrap: wrap; gap: 24px;
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
    <div style="display:flex; gap: 10px; align-items: center;">
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

<!-- Project List -->
<div class="card anim anim-d2">
    <div class="card-head">
        <div class="card-title">
            <span class="s-ico cyan"><i class="fas fa-list-ul"></i></span>
            Daftar Projects
            <span class="tag tag-cyan">{{ $projects->count() }} total</span>
        </div>
        <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
            <div class="search-wrap">
                <i class="fas fa-magnifying-glass search-ico"></i>
                <input type="text" placeholder="Cari project..." oninput="filterCards(this.value,'project-card')">
            </div>
            <button class="btn btn-primary" onclick="openFormModal('create')">
                <i class="fas fa-plus"></i> Tambah Project Baru
            </button>
        </div>
    </div>
    <div class="card-body">
        @if ($projects->isEmpty())
            <div class="empty">
                <div class="empty-illus"><i class="fas fa-folder-open"></i></div>
                <h3>Belum ada project</h3>
                <p>Tambahkan project pertamamu dengan menekan tombol Tambah Project Baru.</p>
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
                                        onclick='openFormModal("edit", @json($project))' title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm btn-ico"
                                        onclick="openDel({{ $project->id }},'{{ addslashes($project->judul) }}','projects')" title="Hapus">
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
        <div class="modal-title" id="formModalTitle">Tambah Project Baru</div>
        <div class="modal-desc" id="formModalDesc">Isi form di bawah ini untuk menambahkan project baru.</div>
        
        <form id="projectForm" method="POST" action="{{ route('projects.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" name="keep_tech" value="1">
            
            <div class="form-grid">
                <div class="fg">
                    <label class="flabel">Judul Project <span class="req">*</span></label>
                    <input type="text" name="judul" id="inputJudul" class="finput" placeholder="Masukkan judul..." required>
                </div>
                <div class="fg">
                    <label class="flabel">URL Demo <span class="req">*</span></label>
                    <input type="text" name="url" id="inputUrl" class="finput" placeholder="https://example.com" required>
                </div>
                <div class="fg full">
                    <label class="flabel">Deskripsi <span class="req">*</span></label>
                    <textarea name="deskripsi" id="inputDeskripsi" class="ftextarea" placeholder="Jelaskan project kamu..." required></textarea>
                </div>
                <div class="fg">
                    <label class="flabel">Foto Project</label>
                    <div class="drop-zone" id="mainDrop">
                        <input type="file" name="foto" id="mainFoto" accept="image/*" onchange="previewImg(this,'mainPrev')">
                        <div class="drop-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                        <div class="drop-text">Upload thumbnail project</div>
                        <div class="drop-sub">JPEG, PNG, WebP, GIF</div>
                        <img id="mainPrev" class="img-preview" alt="Preview">
                    </div>
                </div>
                <div class="fg">
                    <label class="flabel">Icon Tech Stack</label>
                    <div class="drop-zone" id="techDrop">
                        <input type="file" name="tech[]" id="mainTech" multiple accept="image/*" onchange="previewTech(this,'techPrev')">
                        <div class="drop-icon" style="background:linear-gradient(135deg,var(--c-cyan-l),var(--c-purple-l));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                            <i class="fas fa-code"></i>
                        </div>
                        <div class="drop-text">Upload icon tech stack</div>
                        <div class="drop-sub">Multiple file diperbolehkan</div>
                        <div id="techPrev" class="tech-strip" style="justify-content:center;margin-top:10px;"></div>
                    </div>
                </div>
            </div>
            <div class="hr" style="margin:24px 0 16px;"></div>
            <div style="display:flex;justify-content:flex-end;gap:10px;">
                <button type="button" class="btn btn-ghost" onclick="closeFormModal()">
                    <i class="fas fa-xmark"></i> Batal
                </button>
                <button type="submit" class="btn btn-primary" id="btnSubmitForm">
                    <i class="fas fa-floppy-disk"></i> Simpan Project
                </button>
            </div>
        </form>
    </div>
</div>

<!-- DELETE MODAL -->
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

    function openFormModal(mode, data = null) {
        const form = document.getElementById('projectForm');
        const title = document.getElementById('formModalTitle');
        const desc = document.getElementById('formModalDesc');
        const method = document.getElementById('formMethod');
        const btnSubmit = document.getElementById('btnSubmitForm');
        
        // Reset previews
        document.getElementById('mainPrev').style.display = 'none';
        document.getElementById('mainPrev').src = '';
        document.getElementById('techPrev').innerHTML = '';
        
        if (mode === 'create') {
            form.reset();
            title.innerHTML = 'Tambah Project Baru';
            desc.innerHTML = 'Isi form di bawah ini untuk menambahkan project baru.';
            method.value = 'POST';
            form.action = "{{ route('projects.store') }}";
            btnSubmit.innerHTML = '<i class="fas fa-floppy-disk"></i> Simpan Project';
        } else if (mode === 'edit' && data) {
            form.reset();
            title.innerHTML = 'Edit Project';
            desc.innerHTML = 'Perbarui data project kamu.';
            method.value = 'PUT';
            form.action = `/projects/${data.id}`;
            btnSubmit.innerHTML = '<i class="fas fa-floppy-disk"></i> Update Project';
            
            // Populate fields
            document.getElementById('inputJudul').value = data.judul;
            document.getElementById('inputUrl').value = data.url;
            document.getElementById('inputDeskripsi').value = data.deskripsi;
            
            // Previews
            if (data.image_url) {
                document.getElementById('mainPrev').src = data.image_url;
                document.getElementById('mainPrev').style.display = 'block';
            }
            if (data.tech && data.tech !== 'null') {
                const techs = typeof data.tech === 'string' ? JSON.parse(data.tech) : data.tech;
                const techContainer = document.getElementById('techPrev');
                if (Array.isArray(techs)) {
                    techs.forEach(t => {
                        const chip = document.createElement('div');
                        chip.className = 'tech-chip';
                        chip.innerHTML = `<img src="${t}" alt="tech">`;
                        techContainer.appendChild(chip);
                    });
                }
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
