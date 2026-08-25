@extends('layouts.admin')

@section('title', 'Manage CV / Resume')
@section('meta_desc', 'Admin panel untuk mengelola upload dan manajemen file CV/Resume PDF.')

@section('styles')
<style>
    .page-header {
        display: flex; align-items: flex-start;
        justify-content: space-between; margin-bottom: 40px;
        flex-wrap: wrap; gap: 16px;
    }

    .eyebrow {
        font-size: .7rem; font-weight: 700;
        letter-spacing: 1.5px; text-transform: uppercase;
        color: var(--c-green-l, #34d399); margin-bottom: 6px;
        display: flex; align-items: center; gap: 6px;
    }

    .page-header h1 {
        font-size: 2rem; font-weight: 800; letter-spacing: -1px; line-height: 1.1;
        background: linear-gradient(135deg, #fff 50%, rgba(255,255,255,.5));
        -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
    }

    .page-header p { color: var(--c-txt-3); font-size: .82rem; margin-top: 6px; }

    /* Active badge */
    .badge-active {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: 20px;
        font-size: .62rem; font-weight: 800; text-transform: uppercase;
        background: rgba(16,185,129,.18); color: #34d399;
        border: 1px solid rgba(16,185,129,.25);
        box-shadow: 0 0 10px rgba(16,185,129,.1);
    }

    .badge-active::before {
        content: '';
        width: 6px; height: 6px; border-radius: 50%;
        background: #34d399;
        animation: pulse-dot 1.5s ease-in-out infinite;
    }

    @keyframes pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50%       { opacity: .5; transform: scale(.7); }
    }

    .badge-inactive {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: 20px;
        font-size: .62rem; font-weight: 800; text-transform: uppercase;
        background: rgba(255,255,255,.05); color: var(--c-txt-3);
        border: 1px solid var(--c-border);
    }

    /* Active CV Card */
    .active-card {
        background: linear-gradient(135deg, rgba(16,185,129,.08), rgba(6,182,212,.05));
        border: 1px solid rgba(16,185,129,.25);
        border-radius: var(--r);
        padding: 24px 28px;
        margin-bottom: 28px;
        display: flex; align-items: center; gap: 20px;
        position: relative; overflow: hidden;
    }

    .active-card::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
        background: linear-gradient(90deg, #10b981, #06b6d4);
    }

    .active-card-icon {
        width: 56px; height: 56px; border-radius: 14px;
        background: rgba(16,185,129,.15);
        border: 1px solid rgba(16,185,129,.2);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; color: #34d399; flex-shrink: 0;
    }

    .active-card-body h3 {
        font-size: .9rem; font-weight: 700; color: var(--c-txt);
        margin-bottom: 4px;
    }

    .active-card-body p {
        font-size: .75rem; color: var(--c-txt-3);
        margin-bottom: 10px;
    }

    .active-card-url {
        font-family: 'JetBrains Mono', monospace;
        font-size: .68rem; color: #34d399;
        background: rgba(16,185,129,.08);
        border: 1px solid rgba(16,185,129,.15);
        padding: 5px 10px; border-radius: 6px;
        word-break: break-all; display: inline-block;
    }

    /* Resume table */
    .resume-table { width: 100%; border-collapse: collapse; }

    .resume-table thead tr {
        border-bottom: 1px solid var(--c-border);
    }

    .resume-table th {
        text-align: left; padding: 12px 16px;
        font-size: .68rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 1px;
        color: var(--c-txt-3);
    }

    .resume-table tbody tr {
        border-bottom: 1px solid rgba(255,255,255,.04);
        transition: background .2s;
    }

    .resume-table tbody tr:hover { background: rgba(255,255,255,.02); }

    .resume-table td {
        padding: 16px 16px;
        font-size: .8rem; color: var(--c-txt-2);
        vertical-align: middle;
    }

    .file-name-cell {
        display: flex; align-items: center; gap: 10px;
    }

    .file-icon {
        width: 34px; height: 34px; border-radius: 8px;
        background: rgba(239,68,68,.12);
        border: 1px solid rgba(239,68,68,.2);
        display: flex; align-items: center; justify-content: center;
        color: #f87171; font-size: .9rem; flex-shrink: 0;
    }

    .file-label { font-weight: 600; color: var(--c-txt); font-size: .82rem; }
    .file-date  { font-size: .7rem; color: var(--c-txt-3); margin-top: 2px; }

    .empty { text-align: center; padding: 60px 20px; }
    .empty-illus {
        width: 72px; height: 72px; border-radius: 50%;
        background: rgba(52,211,153,.08); border: 1px solid rgba(52,211,153,.12);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px; font-size: 1.8rem; color: #34d399; opacity: .5;
    }
    .empty h3 { font-size: .9rem; font-weight: 700; color: var(--c-txt-2); margin-bottom: 6px; }
    .empty p  { font-size: .78rem; color: var(--c-txt-3); }
</style>
@endsection

@section('content')

<div class="page-header anim">
    <div>
        <div class="eyebrow"><i class="fas fa-circle-dot"></i> Document Management</div>
        <h1>CV / Resume</h1>
        <p>Upload dan kelola file CV PDF kamu</p>
    </div>
    <div style="display:flex;gap:10px;align-items:center;">
        <a href="/api/resume/active" target="_blank" class="btn btn-ghost btn-sm">
            <i class="fas fa-external-link-alt"></i> API
        </a>
    </div>
</div>

{{-- Active CV Card --}}
@php $active = $resumes->where('is_active', true)->first(); @endphp
@if ($active)
    <div class="active-card anim">
        <div class="active-card-icon"><i class="fas fa-file-pdf"></i></div>
        <div class="active-card-body">
            <h3>{{ $active->file_name }}</h3>
            <p>Diupload {{ \Carbon\Carbon::parse($active->created_at)->diffForHumans() }} &bull; CV ini sedang aktif di frontend</p>
            <span class="active-card-url">{{ $active->file_url }}</span>
        </div>
        <a href="{{ $active->file_url }}" target="_blank" class="btn btn-ghost btn-sm" style="margin-left:auto;flex-shrink:0;">
            <i class="fas fa-eye"></i> Preview
        </a>
    </div>
@endif

{{-- Upload Card --}}
<div class="card anim anim-d1" style="margin-bottom:24px;">
    <div class="card-head">
        <div class="card-title">
            <span class="s-ico cyan"><i class="fas fa-upload"></i></span>
            Upload CV Baru
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('resumes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="display:flex;gap:16px;align-items:flex-end;flex-wrap:wrap;">
                <div class="fg" style="flex:1;min-width:240px;">
                    <label class="flabel">File CV (PDF) <span class="req">*</span></label>
                    <div class="drop-zone" id="cvDrop" style="padding:14px 18px;">
                        <input type="file" name="cv_file" id="cvFile" accept=".pdf" onchange="showFileName(this)" required>
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div class="drop-icon" style="font-size:1.6rem; background:linear-gradient(135deg,#f87171,#fb923c);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                                <i class="fas fa-file-pdf"></i>
                            </div>
                            <div>
                                <div class="drop-text" id="cvDropText">Klik untuk pilih file PDF</div>
                                <div class="drop-sub">Maksimal 10MB · hanya format .pdf</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-cloud-upload-alt"></i> Upload & Aktifkan
                    </button>
                </div>
            </div>
        </form>

        @if ($errors->any())
            <div style="margin-top:12px;padding:12px 16px;background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);border-radius:8px;font-size:.78rem;color:#f87171;">
                <i class="fas fa-circle-exclamation" style="margin-right:6px;"></i>
                {{ $errors->first() }}
            </div>
        @endif
    </div>
</div>

{{-- List Card --}}
<div class="card anim anim-d2">
    <div class="card-head">
        <div class="card-title">
            <span class="s-ico cyan"><i class="fas fa-list-ul"></i></span>
            Riwayat CV
            <span class="tag tag-cyan">{{ $resumes->count() }} file</span>
        </div>
    </div>
    <div class="card-body">
        @if ($resumes->isEmpty())
            <div class="empty">
                <div class="empty-illus"><i class="fas fa-file-pdf"></i></div>
                <h3>Belum ada CV</h3>
                <p>Upload CV pertamamu di atas.</p>
            </div>
        @else
            <table class="resume-table">
                <thead>
                    <tr>
                        <th>File</th>
                        <th>Status</th>
                        <th>URL</th>
                        <th style="text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resumes as $resume)
                        <tr id="row-{{ $resume->id }}">
                            <td>
                                <div class="file-name-cell">
                                    <div class="file-icon"><i class="fas fa-file-pdf"></i></div>
                                    <div>
                                        <div class="file-label">{{ $resume->file_name }}</div>
                                        <div class="file-date">{{ \Carbon\Carbon::parse($resume->created_at)->format('d M Y, H:i') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if ($resume->is_active)
                                    <span class="badge-active"><i class="fas fa-check"></i> Aktif</span>
                                @else
                                    <span class="badge-inactive">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ $resume->file_url }}" target="_blank"
                                    style="font-family:'JetBrains Mono',monospace;font-size:.65rem;color:var(--c-cyan-l);word-break:break-all;">
                                    {{ Str::limit($resume->file_url, 55) }}
                                </a>
                            </td>
                            <td>
                                <div style="display:flex;gap:8px;justify-content:flex-end;">
                                    @if (!$resume->is_active)
                                        <form action="{{ route('resumes.setActive', $resume->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-ghost btn-sm" title="Set sebagai aktif">
                                                <i class="fas fa-check-circle"></i> Set Aktif
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ $resume->file_url }}" target="_blank" class="btn btn-ghost btn-sm btn-ico" title="Preview">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm btn-ico"
                                        onclick="openDel({{ $resume->id }},'{{ addslashes($resume->file_name) }}','resumes')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

@endsection

@section('modal')
<!-- DELETE MODAL -->
<div class="overlay" id="delOverlay">
    <div class="modal-box">
        <div class="modal-icon"><i class="fas fa-triangle-exclamation"></i></div>
        <div class="modal-title">Hapus CV</div>
        <div class="modal-desc" id="delDesc">Kamu yakin ingin menghapus CV ini?</div>
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
    function showFileName(input) {
        const el = document.getElementById('cvDropText');
        if (input.files && input.files[0]) {
            el.textContent = input.files[0].name;
            el.style.color = 'var(--c-cyan-l)';
        }
    }
</script>
@endsection
