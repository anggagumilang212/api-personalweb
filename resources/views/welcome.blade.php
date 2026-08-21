@extends('layouts.admin')

@section('title', 'Dashboard')
@section('meta_desc', 'Admin dashboard untuk mengelola konten personal website.')

@section('styles')
<style>
    /* ── HERO ── */
    .hero {
        position: relative;
        padding: 52px 0 40px;
        margin-bottom: 36px;
    }

    .hero-eyebrow {
        font-size: .7rem; font-weight: 700;
        letter-spacing: 2px; text-transform: uppercase;
        color: var(--c-purple-l); margin-bottom: 12px;
        display: flex; align-items: center; gap: 8px;
    }

    .hero-eyebrow span {
        display: inline-block;
        width: 28px; height: 1px;
        background: var(--c-purple-l); opacity: .5;
    }

    .hero h1 {
        font-size: 3.2rem; font-weight: 800;
        letter-spacing: -2px; line-height: 1.05;
        margin-bottom: 16px;
    }

    .hero h1 .line-1 {
        background: linear-gradient(135deg, #fff 60%, rgba(255,255,255,.6));
        -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        display: block;
    }

    .hero h1 .line-2 {
        background: linear-gradient(135deg, var(--c-purple-l) 30%, var(--c-cyan-l));
        -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        display: block;
    }

    .hero-desc {
        font-size: 1rem; color: var(--c-txt-2); line-height: 1.7;
        max-width: 500px; margin-bottom: 28px;
    }

    .hero-actions { display: flex; gap: 12px; flex-wrap: wrap; }

    .hero-glow {
        position: absolute;
        top: -60px; right: -60px;
        width: 400px; height: 400px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(139,92,246,.08) 0%, transparent 70%);
        pointer-events: none;
    }

    /* ── STATS GRID ── */
    .stats-4 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px; margin-bottom: 28px;
    }

    /* ── QUICK ACTIONS ── */
    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 16px;
        margin-bottom: 28px;
    }

    .action-card {
        background: var(--c-glass);
        backdrop-filter: blur(20px);
        border: 1px solid var(--c-border);
        border-radius: var(--r);
        padding: 24px;
        text-decoration: none;
        color: var(--c-txt);
        transition: transform .3s ease, border-color .3s ease, box-shadow .3s ease;
        display: flex; flex-direction: column; gap: 14px;
        position: relative; overflow: hidden;
    }

    .action-card::before {
        content: '';
        position: absolute; inset: 0;
        opacity: 0;
        transition: opacity .3s ease;
    }

    .action-card.purple::before { background: linear-gradient(135deg, rgba(139,92,246,.08), transparent); }
    .action-card.cyan::before   { background: linear-gradient(135deg, rgba(6,182,212,.08), transparent); }
    .action-card.pink::before   { background: linear-gradient(135deg, rgba(236,72,153,.08), transparent); }

    .action-card:hover { transform: translateY(-5px); box-shadow: 0 20px 60px rgba(0,0,0,.35); }
    .action-card:hover::before { opacity: 1; }

    .action-card.purple:hover { border-color: rgba(139,92,246,.3); }
    .action-card.cyan:hover   { border-color: rgba(6,182,212,.3); }
    .action-card.pink:hover   { border-color: rgba(236,72,153,.3); }

    .action-icon {
        width: 48px; height: 48px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem; color: #fff;
    }

    .action-icon.purple { background: linear-gradient(135deg, var(--c-purple), var(--c-purple-d)); box-shadow: 0 6px 20px rgba(139,92,246,.35); }
    .action-icon.cyan   { background: linear-gradient(135deg, var(--c-cyan), #0284c7); box-shadow: 0 6px 20px rgba(6,182,212,.35); }
    .action-icon.pink   { background: linear-gradient(135deg, var(--c-pink), #be185d); box-shadow: 0 6px 20px rgba(236,72,153,.35); }

    .action-title { font-size: 1rem; font-weight: 700; }
    .action-desc  { font-size: .8rem; color: var(--c-txt-2); line-height: 1.6; }

    .action-arrow {
        display: flex; align-items: center; gap: 4px;
        font-size: .78rem; font-weight: 700;
        margin-top: auto;
        transition: gap .2s;
    }

    .action-card.purple .action-arrow { color: var(--c-purple-l); }
    .action-card.cyan   .action-arrow { color: var(--c-cyan-l); }
    .action-card.pink   .action-arrow { color: #f9a8d4; }

    .action-card:hover .action-arrow { gap: 8px; }

    /* ── API ENDPOINTS ── */
    .endpoints-list { display: flex; flex-direction: column; gap: 8px; }

    .endpoint-row {
        display: flex; align-items: center; gap: 12px;
        padding: 10px 14px;
        background: rgba(255,255,255,.03);
        border: 1px solid var(--c-border);
        border-radius: var(--r-sm);
        text-decoration: none; color: var(--c-txt);
        transition: all .2s;
    }

    .endpoint-row:hover {
        background: rgba(255,255,255,.06);
        border-color: rgba(139,92,246,.2);
        transform: translateX(4px);
    }

    .ep-method {
        font-family: 'JetBrains Mono', monospace;
        font-size: .7rem; font-weight: 700;
        padding: 3px 8px; border-radius: 4px;
        flex-shrink: 0;
    }

    .ep-method.get  { background: rgba(16,185,129,.15); color: #34d399; }
    .ep-method.post { background: rgba(245,158,11,.15);  color: #fbbf24; }
    .ep-method.put  { background: rgba(6,182,212,.15);   color: var(--c-cyan-l); }
    .ep-method.del  { background: rgba(239,68,68,.15);   color: #f87171; }

    .ep-path {
        font-family: 'JetBrains Mono', monospace;
        font-size: .78rem; color: var(--c-txt-2);
        flex: 1;
    }

    .ep-desc { font-size: .72rem; color: var(--c-txt-3); }

    .ep-arrow { color: var(--c-txt-3); font-size: .7rem; transition: transform .2s; }
    .endpoint-row:hover .ep-arrow { transform: translateX(4px); color: var(--c-purple-l); }

    /* ── 2 COL ── */
    .two-col { display: grid; grid-template-columns: 1.3fr 1fr; gap: 20px; margin-bottom: 28px; }

    @media (max-width: 1100px) { .two-col { grid-template-columns: 1fr; } }
    @media (max-width: 860px)  { .stats-4 { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 480px)  { .stats-4 { grid-template-columns: 1fr; } .hero h1 { font-size: 2rem; } }
</style>
@endsection

@section('content')

@php
    $totalProjects = \App\Models\Project::count();
    $totalBlogs    = \App\Models\Blog::count();
    $published     = \App\Models\Blog::whereNotNull('published_at')->count();
    $drafts        = \App\Models\Blog::whereNull('published_at')->count();
@endphp

<!-- ═══ HERO ═══ -->
<div class="hero anim">
    <div class="hero-glow"></div>
    <div class="hero-eyebrow"><span></span> Personal Website CMS <span></span></div>
    <h1>
        <span class="line-1">Selamat datang</span>
        <span class="line-2">di Admin Panel.</span>
    </h1>
    <p class="hero-desc">
        Kelola semua konten website kamu — dari project portfolio hingga artikel blog —
        dalam satu tempat yang rapi dan efisien.
    </p>
    <div class="hero-actions">
        <a href="{{ route('projects.index') }}" class="btn btn-primary">
            <i class="fas fa-folder-open"></i> Kelola Projects
        </a>
        <a href="{{ route('blogs.index') }}" class="btn btn-ghost">
            <i class="fas fa-pen-nib"></i> Kelola Blog
        </a>
    </div>
</div>

<!-- ═══ STATS ═══ -->
<div class="stats-4">
    <div class="stat-box v-purple anim">
        <div class="stat-label">Total Projects</div>
        <div class="stat-num">{{ $totalProjects }}</div>
        <div class="stat-icon"><i class="fas fa-folder-open"></i></div>
    </div>
    <div class="stat-box v-cyan anim anim-d1">
        <div class="stat-label">Total Artikel</div>
        <div class="stat-num">{{ $totalBlogs }}</div>
        <div class="stat-icon"><i class="fas fa-newspaper"></i></div>
    </div>
    <div class="stat-box v-green anim anim-d2">
        <div class="stat-label">Published</div>
        <div class="stat-num">{{ $published }}</div>
        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
    </div>
    <div class="stat-box v-pink anim anim-d3">
        <div class="stat-label">Draft</div>
        <div class="stat-num">{{ $drafts }}</div>
        <div class="stat-icon"><i class="fas fa-pencil"></i></div>
    </div>
</div>

<!-- ═══ QUICK ACTIONS ═══ -->
<div class="actions-grid">
    <a href="{{ route('projects.index') }}" class="action-card purple anim">
        <div class="action-icon purple"><i class="fas fa-folder-open"></i></div>
        <div>
            <div class="action-title">Project Management</div>
            <div class="action-desc">Tambah, edit, dan hapus project portfolio. Upload thumbnail dan tech stack icons.</div>
        </div>
        <div class="action-arrow">Buka Projects <i class="fas fa-arrow-right"></i></div>
    </a>

    <a href="{{ route('blogs.index') }}" class="action-card cyan anim anim-d1">
        <div class="action-icon cyan"><i class="fas fa-pen-nib"></i></div>
        <div>
            <div class="action-title">Blog Management</div>
            <div class="action-desc">Tulis dan publish artikel dengan Markdown. Kelola status draft & published.</div>
        </div>
        <div class="action-arrow">Buka Blog <i class="fas fa-arrow-right"></i></div>
    </a>

    <a href="/api/blogs" target="_blank" class="action-card pink anim anim-d2">
        <div class="action-icon pink"><i class="fas fa-code"></i></div>
        <div>
            <div class="action-title">REST API</div>
            <div class="action-desc">Akses data lewat REST API untuk diintegrasikan ke frontend website kamu.</div>
        </div>
        <div class="action-arrow">Lihat API <i class="fas fa-arrow-right"></i></div>
    </a>
</div>

<!-- ═══ 2 COL: API Docs + Recent ═══ -->
<div class="two-col">

    <!-- API Endpoints -->
    <div class="card anim">
        <div class="card-head">
            <div class="card-title">
                <span class="s-ico pink"><i class="fas fa-code"></i></span>
                API Endpoints
            </div>
            <span class="tag tag-purple">{{ 10 }} routes</span>
        </div>
        <div class="card-body">
            <div class="endpoints-list">
                {{-- Projects --}}
                <a href="/api/projects" target="_blank" class="endpoint-row">
                    <span class="ep-method get">GET</span>
                    <span class="ep-path">/api/projects</span>
                    <span class="ep-desc">List all projects</span>
                    <i class="fas fa-arrow-up-right-from-square ep-arrow"></i>
                </a>
                <div class="endpoint-row" style="cursor:default;">
                    <span class="ep-method get">GET</span>
                    <span class="ep-path">/api/projects/{id}</span>
                    <span class="ep-desc">Detail project</span>
                </div>
                <div class="endpoint-row" style="cursor:default;">
                    <span class="ep-method post">POST</span>
                    <span class="ep-path">/api/create-projects</span>
                    <span class="ep-desc">Create project</span>
                </div>
                <div class="endpoint-row" style="cursor:default;">
                    <span class="ep-method put">PUT</span>
                    <span class="ep-path">/api/update-projects/{id}</span>
                    <span class="ep-desc">Update project</span>
                </div>
                <div class="endpoint-row" style="cursor:default;">
                    <span class="ep-method del">DEL</span>
                    <span class="ep-path">/api/delete-projects/{id}</span>
                    <span class="ep-desc">Delete project</span>
                </div>
                {{-- Blogs --}}
                <a href="/api/blogs" target="_blank" class="endpoint-row">
                    <span class="ep-method get">GET</span>
                    <span class="ep-path">/api/blogs</span>
                    <span class="ep-desc">List all blogs</span>
                    <i class="fas fa-arrow-up-right-from-square ep-arrow"></i>
                </a>
                <div class="endpoint-row" style="cursor:default;">
                    <span class="ep-method get">GET</span>
                    <span class="ep-path">/api/blogs/{id}</span>
                    <span class="ep-desc">Detail blog</span>
                </div>
                <div class="endpoint-row" style="cursor:default;">
                    <span class="ep-method post">POST</span>
                    <span class="ep-path">/api/create-blogs</span>
                    <span class="ep-desc">Create blog</span>
                </div>
                <div class="endpoint-row" style="cursor:default;">
                    <span class="ep-method put">PUT</span>
                    <span class="ep-path">/api/update-blogs/{id}</span>
                    <span class="ep-desc">Update blog</span>
                </div>
                <div class="endpoint-row" style="cursor:default;">
                    <span class="ep-method del">DEL</span>
                    <span class="ep-path">/api/delete-blogs/{id}</span>
                    <span class="ep-desc">Delete blog</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary -->
    <div style="display:flex; flex-direction:column; gap: 20px;">

        <!-- Recent Blogs -->
        <div class="card anim anim-d1" style="flex:1;">
            <div class="card-head">
                <div class="card-title">
                    <span class="s-ico cyan"><i class="fas fa-clock-rotate-left"></i></span>
                    Artikel Terbaru
                </div>
            </div>
            <div class="card-body" style="padding: 12px 18px;">
                @php $recentBlogs = \App\Models\Blog::orderBy('created_at','desc')->limit(4)->get(); @endphp
                @if ($recentBlogs->isEmpty())
                    <p style="font-size:.8rem;color:var(--c-txt-3);text-align:center;padding:20px 0;">
                        Belum ada artikel.
                    </p>
                @else
                    @foreach ($recentBlogs as $blog)
                        <div style="display:flex;align-items:center;gap:10px;padding:9px 0;border-bottom:1px solid var(--c-border);">
                            <div style="width:34px;height:34px;border-radius:8px;background:rgba(6,182,212,.1);border:1px solid rgba(6,182,212,.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fas fa-newspaper" style="font-size:.75rem;color:var(--c-cyan-l);"></i>
                            </div>
                            <div style="flex:1;min-width:0;">
                                <div style="font-size:.82rem;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $blog->title }}</div>
                                <div style="font-size:.68rem;color:var(--c-txt-3);">{{ \Carbon\Carbon::parse($blog->created_at)->diffForHumans() }}</div>
                            </div>
                            <span style="font-size:.6rem;font-weight:700;padding:2px 8px;border-radius:20px;{{ $blog->published_at ? 'background:rgba(16,185,129,.15);color:#34d399;border:1px solid rgba(16,185,129,.2)' : 'background:rgba(245,158,11,.12);color:#fbbf24;border:1px solid rgba(245,158,11,.18)' }}">
                                {{ $blog->published_at ? 'Live' : 'Draft' }}
                            </span>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Recent Projects -->
        <div class="card anim anim-d2" style="flex:1;">
            <div class="card-head">
                <div class="card-title">
                    <span class="s-ico purple"><i class="fas fa-folder-open"></i></span>
                    Project Terbaru
                </div>
            </div>
            <div class="card-body" style="padding: 12px 18px;">
                @php $recentProjects = \App\Models\Project::orderBy('created_at','desc')->limit(4)->get(); @endphp
                @if ($recentProjects->isEmpty())
                    <p style="font-size:.8rem;color:var(--c-txt-3);text-align:center;padding:20px 0;">
                        Belum ada project.
                    </p>
                @else
                    @foreach ($recentProjects as $proj)
                        <div style="display:flex;align-items:center;gap:10px;padding:9px 0;border-bottom:1px solid var(--c-border);">
                            @if ($proj->image_url)
                                <img src="{{ $proj->image_url }}" style="width:34px;height:34px;border-radius:8px;object-fit:cover;flex-shrink:0;border:1px solid var(--c-border);">
                            @else
                                <div style="width:34px;height:34px;border-radius:8px;background:rgba(139,92,246,.1);border:1px solid rgba(139,92,246,.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="fas fa-folder" style="font-size:.75rem;color:var(--c-purple-l);"></i>
                                </div>
                            @endif
                            <div style="flex:1;min-width:0;">
                                <div style="font-size:.82rem;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $proj->judul }}</div>
                                <div style="font-size:.68rem;color:var(--c-txt-3);">{{ \Carbon\Carbon::parse($proj->created_at)->diffForHumans() }}</div>
                            </div>
                            <a href="{{ $proj->url }}" target="_blank" style="color:var(--c-txt-3);font-size:.75rem;transition:color .2s;" onmouseover="this.style.color='var(--c-purple-l)'" onmouseout="this.style.color='var(--c-txt-3)'">
                                <i class="fas fa-arrow-up-right-from-square"></i>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

    </div>
</div>

@endsection
