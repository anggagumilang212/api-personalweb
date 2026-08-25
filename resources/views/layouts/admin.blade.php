<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') — Personal CMS</title>
    <meta name="description" content="@yield('meta_desc', 'Admin panel untuk mengelola konten personal website.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* ══════════════════════════════════════
           DESIGN TOKENS
        ══════════════════════════════════════ */
        :root {
            --c-bg:       #070711;
            --c-glass:    rgba(255,255,255,0.04);
            --c-border:   rgba(255,255,255,0.08);
            --c-purple:   #8b5cf6;
            --c-purple-l: #a78bfa;
            --c-purple-d: #6d28d9;
            --c-cyan:     #06b6d4;
            --c-cyan-l:   #67e8f9;
            --c-pink:     #ec4899;
            --c-green:    #10b981;
            --c-amber:    #f59e0b;
            --c-red:      #ef4444;
            --c-txt:      #f0f0fc;
            --c-txt-2:    #9090b0;
            --c-txt-3:    #4a4a6a;
            --sidebar:    260px;
            --r:          14px;
            --r-sm:       8px;
            --r-xs:       6px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--c-bg);
            color: var(--c-txt);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        /* Aurora background */
        body::before {
            content: '';
            position: fixed; inset: 0;
            background:
                radial-gradient(ellipse 80% 50% at 10% 10%,  rgba(139,92,246,.10) 0%, transparent 60%),
                radial-gradient(ellipse 60% 40% at 90% 80%,  rgba(6,182,212,.07)  0%, transparent 60%),
                radial-gradient(ellipse 50% 60% at 50% 50%,  rgba(236,72,153,.03) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        /* ══════════════════════════════════════
           SIDEBAR
        ══════════════════════════════════════ */
        .sidebar {
            width: var(--sidebar);
            min-height: 100vh;
            background: rgba(8,8,18,0.85);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-right: 1px solid var(--c-border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
        }

        /* Brand */
        .sb-brand {
            padding: 26px 20px 20px;
            border-bottom: 1px solid var(--c-border);
        }

        .sb-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            margin-bottom: 3px;
        }

        .sb-logo-icon {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--c-purple), var(--c-cyan));
            display: flex; align-items: center; justify-content: center;
            font-size: .9rem; color: #fff;
            box-shadow: 0 4px 16px rgba(139,92,246,.4);
            flex-shrink: 0;
        }

        .sb-logo-name {
            font-size: 1rem;
            font-weight: 800;
            background: linear-gradient(135deg, #fff 40%, var(--c-purple-l));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .sb-sub {
            font-size: .67rem;
            color: var(--c-txt-3);
            padding-left: 46px;
        }

        /* Nav */
        .sb-nav { padding: 16px 12px; flex: 1; overflow-y: auto; }

        .sb-section {
            font-size: .59rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--c-txt-3);
            padding: 0 10px;
            margin: 18px 0 6px;
        }

        .sb-section:first-child { margin-top: 0; }

        .sb-link {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 9px 10px;
            border-radius: var(--r-sm);
            color: var(--c-txt-2);
            text-decoration: none;
            font-size: .83rem;
            font-weight: 500;
            transition: all .2s ease;
            margin-bottom: 2px;
            position: relative;
        }

        .sb-link:hover {
            background: rgba(255,255,255,.04);
            color: var(--c-txt);
        }

        .sb-link.active {
            background: linear-gradient(135deg, rgba(139,92,246,.18), rgba(6,182,212,.08));
            color: var(--c-purple-l);
            border: 1px solid rgba(139,92,246,.18);
        }

        .sb-link.active::before {
            content: '';
            position: absolute;
            left: -12px; top: 50%;
            transform: translateY(-50%);
            width: 3px; height: 60%;
            background: linear-gradient(to bottom, var(--c-purple), var(--c-cyan));
            border-radius: 0 2px 2px 0;
        }

        .sb-ico {
            width: 30px; height: 30px;
            border-radius: var(--r-xs);
            display: flex; align-items: center; justify-content: center;
            font-size: .77rem;
            background: rgba(255,255,255,.05);
            flex-shrink: 0;
            transition: all .2s;
        }

        .sb-link.active .sb-ico {
            background: linear-gradient(135deg, var(--c-purple), var(--c-cyan));
            color: #fff;
            box-shadow: 0 2px 10px rgba(139,92,246,.4);
        }

        .sb-badge {
            margin-left: auto;
            font-size: .6rem; font-weight: 700;
            padding: 1px 7px; border-radius: 20px;
            background: rgba(139,92,246,.18);
            color: var(--c-purple-l);
            border: 1px solid rgba(139,92,246,.18);
        }

        .sb-get {
            font-family: 'JetBrains Mono', monospace;
            font-size: .7rem;
            color: var(--c-green);
            margin-right: 2px;
        }

        /* Footer */
        .sb-footer {
            padding: 14px 20px;
            border-top: 1px solid var(--c-border);
        }

        .sb-status {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: .71rem;
            color: var(--c-txt-3);
            background: rgba(16,185,129,.07);
            border: 1px solid rgba(16,185,129,.14);
            padding: 7px 12px;
            border-radius: 20px;
        }

        .sb-dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: var(--c-green);
            box-shadow: 0 0 8px var(--c-green);
            animation: breathe 2.5s ease-in-out infinite;
        }

        @keyframes breathe {
            0%,100%{opacity:1;box-shadow:0 0 8px var(--c-green);}
            50%{opacity:.5;box-shadow:0 0 3px var(--c-green);}
        }

        /* ══════════════════════════════════════
           MAIN WRAPPER
        ══════════════════════════════════════ */
        .main {
            margin-left: var(--sidebar);
            flex: 1;
            padding: 36px 36px 72px;
            max-width: calc(100vw - var(--sidebar));
            position: relative;
            z-index: 1;
        }

        /* ══════════════════════════════════════
           REUSABLE: BUTTONS
        ══════════════════════════════════════ */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 20px;
            border-radius: var(--r-sm);
            font-size: .83rem;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            border: none;
            transition: all .2s ease;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--c-purple), var(--c-purple-d));
            color: #fff;
            box-shadow: 0 4px 20px rgba(139,92,246,.35);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(139,92,246,.55);
        }

        .btn-ghost {
            background: rgba(255,255,255,.06);
            color: var(--c-txt-2);
            border: 1px solid var(--c-border);
        }

        .btn-ghost:hover { background: rgba(255,255,255,.1); color: var(--c-txt); }

        .btn-warn {
            background: linear-gradient(135deg, var(--c-amber), #d97706);
            color: #fff;
        }

        .btn-warn:hover { transform: translateY(-1px); }

        .btn-danger {
            background: linear-gradient(135deg, var(--c-red), #b91c1c);
            color: #fff;
        }

        .btn-danger:hover { transform: translateY(-1px); }

        .btn-sm { padding: 6px 14px; font-size: .77rem; }

        .btn-ico {
            width: 34px; height: 34px;
            padding: 0; border-radius: var(--r-xs);
            justify-content: center; font-size: .8rem;
        }

        /* ══════════════════════════════════════
           REUSABLE: SECTION CARD
        ══════════════════════════════════════ */
        .card {
            background: var(--c-glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--c-border);
            border-radius: var(--r);
            overflow: hidden;
            margin-bottom: 24px;
        }

        .card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 24px;
            border-bottom: 1px solid var(--c-border);
            background: rgba(255,255,255,.02);
        }

        .card-title {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: .95rem;
            font-weight: 700;
        }

        .card-body { padding: 24px; }

        /* section icon */
        .s-ico {
            width: 32px; height: 32px;
            border-radius: var(--r-xs);
            display: flex; align-items: center; justify-content: center;
            font-size: .8rem; color: #fff;
        }

        .s-ico.purple { background: linear-gradient(135deg, var(--c-purple), var(--c-purple-d)); box-shadow: 0 4px 12px rgba(139,92,246,.35); }
        .s-ico.cyan   { background: linear-gradient(135deg, var(--c-cyan), #0284c7); box-shadow: 0 4px 12px rgba(6,182,212,.35); }
        .s-ico.pink   { background: linear-gradient(135deg, var(--c-pink), #be185d); box-shadow: 0 4px 12px rgba(236,72,153,.35); }

        /* ══════════════════════════════════════
           REUSABLE: STATS BOX
        ══════════════════════════════════════ */
        .stat-box {
            background: var(--c-glass);
            backdrop-filter: blur(16px);
            border: 1px solid var(--c-border);
            border-radius: var(--r);
            padding: 22px 24px;
            position: relative; overflow: hidden;
            transition: transform .25s, box-shadow .25s;
        }

        .stat-box::after {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 1px;
        }

        .stat-box.v-purple::after { background: linear-gradient(90deg, transparent, var(--c-purple), transparent); }
        .stat-box.v-cyan::after   { background: linear-gradient(90deg, transparent, var(--c-cyan), transparent); }
        .stat-box.v-green::after  { background: linear-gradient(90deg, transparent, var(--c-green), transparent); }
        .stat-box.v-pink::after   { background: linear-gradient(90deg, transparent, var(--c-pink), transparent); }

        .stat-box:hover { transform: translateY(-3px); box-shadow: 0 12px 40px rgba(0,0,0,.3); }

        .stat-label {
            font-size: .63rem; font-weight: 700;
            letter-spacing: 1.2px; text-transform: uppercase;
            color: var(--c-txt-3); margin-bottom: 10px;
        }

        .stat-num {
            font-size: 2.4rem; font-weight: 800;
            letter-spacing: -2px; line-height: 1;
        }

        .stat-box.v-purple .stat-num { background: linear-gradient(135deg,var(--c-purple-l),#c4b5fd); -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text; }
        .stat-box.v-cyan .stat-num   { background: linear-gradient(135deg,var(--c-cyan-l),#a5f3fc); -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text; }
        .stat-box.v-green .stat-num  { background: linear-gradient(135deg,#34d399,#6ee7b7); -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text; }
        .stat-box.v-pink .stat-num   { background: linear-gradient(135deg,#f472b6,#fbcfe8); -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text; }

        .stat-icon { position: absolute; right: 18px; top: 50%; transform: translateY(-50%); font-size: 2.5rem; opacity: .07; }

        /* ══════════════════════════════════════
           REUSABLE: FORM
        ══════════════════════════════════════ */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .fg { display: flex; flex-direction: column; gap: 6px; }
        .fg.full { grid-column: 1 / -1; }

        .flabel {
            font-size: .73rem; font-weight: 600;
            color: var(--c-txt-2);
        }

        .flabel .req { color: var(--c-purple-l); }

        .finput, .ftextarea {
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: var(--r-sm);
            color: var(--c-txt); padding: 10px 14px;
            font-size: .855rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: border-color .2s, box-shadow .2s, background .2s;
            width: 100%;
        }

        .finput:focus, .ftextarea:focus {
            outline: none;
            border-color: var(--c-purple);
            background: rgba(139,92,246,.06);
            box-shadow: 0 0 0 3px rgba(139,92,246,.12), 0 0 20px rgba(139,92,246,.06);
        }

        .finput::placeholder, .ftextarea::placeholder { color: var(--c-txt-3); }
        .ftextarea { resize: vertical; min-height: 88px; }
        .fmono { font-family: 'JetBrains Mono', monospace !important; font-size: .78rem !important; line-height: 1.7; }

        /* ══════════════════════════════════════
           REUSABLE: UPLOAD / DROP ZONE
        ══════════════════════════════════════ */
        .drop-zone {
            border: 2px dashed rgba(255,255,255,.1);
            border-radius: var(--r-sm);
            padding: 26px 20px; text-align: center;
            cursor: pointer; background: rgba(255,255,255,.02);
            position: relative; transition: all .25s ease;
        }

        .drop-zone:hover, .drop-zone.drag-over {
            border-color: var(--c-purple);
            background: rgba(139,92,246,.06);
        }

        .drop-zone input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; }

        .drop-icon {
            font-size: 2rem; margin-bottom: 10px;
            background: linear-gradient(135deg, var(--c-purple-l), var(--c-cyan-l));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }

        .drop-text { font-size: .8rem; color: var(--c-txt-2); font-weight: 500; }
        .drop-sub  { font-size: .7rem; color: var(--c-txt-3); margin-top: 4px; }

        .img-preview {
            width: 100%; max-height: 140px; object-fit: cover;
            border-radius: var(--r-xs); margin-top: 12px;
            display: none; border: 1px solid var(--c-border);
        }

        /* ══════════════════════════════════════
           REUSABLE: SEARCH
        ══════════════════════════════════════ */
        .search-wrap { position: relative; }

        .search-wrap input {
            background: rgba(255,255,255,.04);
            border: 1px solid var(--c-border);
            border-radius: 30px; color: var(--c-txt);
            padding: 9px 16px 9px 38px;
            font-size: .83rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            width: 240px; transition: all .2s;
        }

        .search-wrap input:focus {
            outline: none; border-color: var(--c-purple);
            background: rgba(139,92,246,.06); width: 280px;
        }

        .search-wrap input::placeholder { color: var(--c-txt-3); }

        .search-ico {
            position: absolute; left: 13px; top: 50%;
            transform: translateY(-50%); color: var(--c-txt-3); font-size: .75rem;
        }

        /* ══════════════════════════════════════
           REUSABLE: TAGS
        ══════════════════════════════════════ */
        .tag {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 10px; border-radius: 20px;
            font-size: .67rem; font-weight: 700;
        }

        .tag-purple { background: rgba(139,92,246,.12); color: var(--c-purple-l); border: 1px solid rgba(139,92,246,.18); }
        .tag-cyan   { background: rgba(6,182,212,.12);  color: var(--c-cyan-l);   border: 1px solid rgba(6,182,212,.18); }

        /* ══════════════════════════════════════
           REUSABLE: EDIT SLIDE
        ══════════════════════════════════════ */
        .edit-slide {
            display: none; border-top: 1px solid var(--c-border);
            background: rgba(139,92,246,.03);
        }

        .edit-slide.open { display: block; }

        .edit-body { padding: 16px 18px; }

        .edit-grid { display: grid; grid-template-columns: 1fr; gap: 10px; }

        .einput, .etextarea {
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: var(--r-xs); color: var(--c-txt);
            padding: 8px 12px; font-size: .8rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            width: 100%; transition: border-color .2s;
        }

        .einput:focus, .etextarea:focus { outline: none; border-color: var(--c-purple); background: rgba(139,92,246,.05); }
        .einput::placeholder, .etextarea::placeholder { color: var(--c-txt-3); }

        .elabel { font-size: .68rem; font-weight: 600; color: var(--c-txt-3); margin-bottom: 4px; display: block; }

        .thumb-row { display: flex; align-items: center; gap: 10px; }

        .e-thumb {
            width: 50px; height: 50px; border-radius: var(--r-xs);
            object-fit: cover; border: 1px solid var(--c-border); flex-shrink: 0;
        }

        .upload-btn-fake {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 7px 12px; border-radius: var(--r-xs);
            font-size: .76rem; font-weight: 600; cursor: pointer;
            border: 1px dashed rgba(255,255,255,.14);
            background: transparent; color: var(--c-txt-2); transition: all .2s;
        }

        .upload-btn-fake:hover { border-color: var(--c-purple); color: var(--c-purple-l); background: rgba(139,92,246,.07); }

        /* ══════════════════════════════════════
           REUSABLE: MODAL
        ══════════════════════════════════════ */
        .overlay {
            position: fixed; inset: 0;
            background: rgba(0,0,0,.72);
            backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);
            z-index: 500; display: none;
            align-items: center; justify-content: center;
        }

        .overlay.open { display: flex; }

        .modal-box {
            background: rgba(13,13,24,.96);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 18px; padding: 32px;
            width: 90%; max-width: 420px;
            box-shadow: 0 32px 100px rgba(0,0,0,.7);
            animation: popIn .25s cubic-bezier(.34,1.56,.64,1) both;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-box-lg {
            max-width: 800px;
            padding: 36px;
        }

        @keyframes popIn {
            from { opacity: 0; transform: scale(.88) translateY(10px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }

        .modal-icon {
            width: 52px; height: 52px; border-radius: 14px;
            background: rgba(239,68,68,.12); border: 1px solid rgba(239,68,68,.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem; color: var(--c-red); margin-bottom: 18px;
        }

        .modal-title { font-size: 1.1rem; font-weight: 800; margin-bottom: 8px; }
        .modal-desc { font-size: .84rem; color: var(--c-txt-2); line-height: 1.7; margin-bottom: 26px; }
        .modal-actions { display: flex; justify-content: flex-end; gap: 10px; }

        /* ══════════════════════════════════════
           REUSABLE: TOAST
        ══════════════════════════════════════ */
        .toast-stack {
            position: fixed; top: 24px; right: 24px;
            z-index: 9999; display: flex; flex-direction: column; gap: 10px;
        }

        .toast {
            display: flex; align-items: center; gap: 12px;
            padding: 14px 18px; border-radius: var(--r-sm);
            font-size: .84rem; font-weight: 600;
            min-width: 290px; backdrop-filter: blur(20px);
            box-shadow: 0 12px 40px rgba(0,0,0,.5);
            animation: toastIn .35s cubic-bezier(.34,1.56,.64,1) both;
        }

        @keyframes toastIn {
            from { opacity: 0; transform: translateX(60px) scale(.9); }
            to   { opacity: 1; transform: translateX(0) scale(1); }
        }

        .toast-success { background: rgba(16,185,129,.12); border: 1px solid rgba(16,185,129,.25); color: #34d399; }
        .toast-error   { background: rgba(239,68,68,.12);  border: 1px solid rgba(239,68,68,.25);  color: #f87171; }

        .toast-ico {
            width: 32px; height: 32px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: .9rem; flex-shrink: 0;
        }

        .toast-success .toast-ico { background: rgba(16,185,129,.15); }
        .toast-error   .toast-ico { background: rgba(239,68,68,.15); }

        /* ══════════════════════════════════════
           MISC
        ══════════════════════════════════════ */
        .hr { height: 1px; background: var(--c-border); margin: 20px 0; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .anim { animation: fadeUp .5s ease both; }
        .anim-d1 { animation-delay: .06s; }
        .anim-d2 { animation-delay: .12s; }
        .anim-d3 { animation-delay: .18s; }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,.08); border-radius: 3px; }

        /* ══════════════════════════════════════
           MOBILE TOPBAR
        ══════════════════════════════════════ */
        .mob-topbar {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0;
            height: 56px;
            background: rgba(8,8,18,0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--c-border);
            z-index: 200;
            align-items: center;
            justify-content: space-between;
            padding: 0 16px;
        }

        .mob-brand {
            display: flex;
            align-items: center;
            gap: 9px;
            text-decoration: none;
            color: var(--c-txt);
        }

        .mob-brand-ico {
            width: 30px; height: 30px;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--c-purple), var(--c-cyan));
            display: flex; align-items: center; justify-content: center;
            font-size: .75rem; color: #fff;
            box-shadow: 0 3px 10px rgba(139,92,246,.4);
        }

        .mob-brand-name {
            font-size: .9rem; font-weight: 800;
            background: linear-gradient(135deg, #fff 40%, var(--c-purple-l));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .mob-ham {
            width: 38px; height: 38px;
            border-radius: var(--r-xs);
            background: rgba(255,255,255,.06);
            border: 1px solid var(--c-border);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; color: var(--c-txt-2);
            font-size: .9rem;
            transition: all .2s;
        }

        .mob-ham:hover {
            background: rgba(139,92,246,.15);
            border-color: rgba(139,92,246,.3);
            color: var(--c-purple-l);
        }

        /* Sidebar overlay backdrop */
        .sb-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,.6);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 99;
        }

        .sb-overlay.open { display: block; }

        /* ══════════════════════════════════════
           RESPONSIVE — LARGE TABLET (≤1024px)
        ══════════════════════════════════════ */
        @media (max-width: 1024px) {
            :root { --sidebar: 220px; }
        }

        /* ══════════════════════════════════════
           RESPONSIVE — TABLET (≤768px)
        ══════════════════════════════════════ */
        @media (max-width: 768px) {
            /* Show mobile topbar */
            .mob-topbar { display: flex; }

            /* Sidebar becomes a drawer */
            .sidebar {
                transform: translateX(-100%);
                transition: transform .3s cubic-bezier(.4,0,.2,1);
                z-index: 150;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            /* Main shifts down for topbar */
            .main {
                margin-left: 0;
                padding: 72px 16px 80px;
                max-width: 100vw;
            }

            /* Forms: single column */
            .form-grid { grid-template-columns: 1fr; }

            /* Search bar: full width */
            .search-wrap input { width: 100% !important; }
            .search-wrap { width: 100%; }

            /* card-head stacks on small */
            .card-head {
                flex-wrap: wrap;
                gap: 10px;
            }

            /* Buttons smaller */
            .btn { font-size: .78rem; padding: 8px 16px; }
            .btn-sm { font-size: .72rem; padding: 5px 11px; }

            /* Toast: smaller, full-width-ish */
            .toast { min-width: 240px; }
            .toast-stack { right: 12px; top: 68px; }

            /* Modal full-width on mobile */
            .modal-box { padding: 24px 20px; }
        }

        /* ══════════════════════════════════════
           RESPONSIVE — MOBILE (≤480px)
        ══════════════════════════════════════ */
        @media (max-width: 480px) {
            .main { padding: 68px 12px 80px; }

            /* Stat boxes: single column */
            .stats-1col { grid-template-columns: 1fr !important; }

            /* Hide stat icons on very small */
            .stat-icon { display: none; }

            /* Card body padding */
            .card-body { padding: 16px; }
            .card-head { padding: 14px 16px; }

            /* Bigger tap targets */
            .btn-ico { width: 38px; height: 38px; }

            /* Slug truncate more aggressively */
            .card-slug { max-width: 110px; }

            /* Toast compact */
            .toast { min-width: 0; width: calc(100vw - 24px); }
            .toast-stack { left: 12px; right: 12px; }
        }

        /* ══════════════════════════════════════
           PAGE-SPECIFIC (yielded)
        ══════════════════════════════════════ */
        @yield('styles')
    </style>
</head>
<body>

<!-- ═══════════ MOBILE TOPBAR ═══════════ -->
<div class="mob-topbar">
    <a href="/" class="mob-brand">
        <div class="mob-brand-ico"><i class="fas fa-layer-group"></i></div>
        <span class="mob-brand-name">Admin Panel</span>
    </a>
    <button class="mob-ham" id="mobHam" onclick="toggleSidebar()" aria-label="Toggle menu">
        <i class="fas fa-bars" id="hamIco"></i>
    </button>
</div>

<!-- ═══════════ SIDEBAR OVERLAY ═══════════ -->
<div class="sb-overlay" id="sbOverlay" onclick="closeSidebar()"></div>

<!-- ═══════════ SIDEBAR ═══════════ -->
<aside class="sidebar" id="sidebar">
    <div class="sb-brand">
        <a href="/" class="sb-logo" onclick="closeSidebar()">
            <div class="sb-logo-icon"><i class="fas fa-layer-group"></i></div>
            <span class="sb-logo-name">Admin Panel</span>
        </a>
        <div class="sb-sub">Personal Website CMS</div>
    </div>

    <nav class="sb-nav">
        <div class="sb-section">Navigasi</div>

        <a href="/" class="sb-link {{ request()->is('/') ? 'active' : '' }}">
            <span class="sb-ico"><i class="fas fa-house"></i></span>
            Dashboard
        </a>

        <div class="sb-section">Content</div>

        <a href="{{ route('projects.index') }}" class="sb-link {{ request()->is('projects') ? 'active' : '' }}">
            <span class="sb-ico"><i class="fas fa-folder-open"></i></span>
            Projects
            @php $projCount = \App\Models\Project::count(); @endphp
            @if ($projCount > 0)
                <span class="sb-badge">{{ $projCount }}</span>
            @endif
        </a>

        <a href="{{ route('blogs.index') }}" class="sb-link {{ request()->is('blogs') ? 'active' : '' }}">
            <span class="sb-ico"><i class="fas fa-pen-nib"></i></span>
            Blog Posts
            @php $blogCount = \App\Models\Blog::count(); @endphp
            @if ($blogCount > 0)
                <span class="sb-badge">{{ $blogCount }}</span>
            @endif
        </a>

        <div class="sb-section">REST API</div>

        <a href="/api/projects" target="_blank" class="sb-link">
            <span class="sb-ico"><i class="fas fa-code"></i></span>
            <span><span class="sb-get">GET</span>/api/projects</span>
        </a>

        <a href="/api/blogs" target="_blank" class="sb-link">
            <span class="sb-ico"><i class="fas fa-code"></i></span>
            <span><span class="sb-get">GET</span>/api/blogs</span>
        </a>
    </nav>

    <div class="sb-footer">
        <div class="sb-status">
            <span class="sb-dot"></span>
            API Server Online
        </div>
    </div>
</aside>

<!-- close sidebar on nav link click (mobile) -->
<script>
    document.querySelectorAll('.sb-link').forEach(l => {
        l.addEventListener('click', () => { if (window.innerWidth <= 768) closeSidebar(); });
    });
</script>

<!-- ═══════════ MAIN CONTENT ═══════════ -->
<main class="main">
    @yield('content')
</main>

<!-- ═══════════ GLOBAL MODAL (Delete) ═══════════ -->
@yield('modal')

<!-- ═══════════ TOAST ═══════════ -->
<div class="toast-stack" id="toasts"></div>

<!-- ═══════════ GLOBAL JS ═══════════ -->
<script>
    /* ── Toast ── */
    function toast(msg, type = 'success') {
        const stack = document.getElementById('toasts');
        const t = document.createElement('div');
        t.className = `toast toast-${type}`;
        t.innerHTML = `<div class="toast-ico"><i class="fas ${type==='success'?'fa-check':'fa-circle-exclamation'}"></i></div><span>${msg}</span>`;
        stack.appendChild(t);
        setTimeout(() => {
            t.style.transition = 'all .4s ease';
            t.style.opacity = '0';
            t.style.transform = 'translateX(60px)';
            setTimeout(() => t.remove(), 400);
        }, 3500);
    }

    /* ── Image Preview ── */
    function previewImg(input, prevId) {
        const prev = document.getElementById(prevId);
        if (input.files && input.files[0] && prev) {
            const r = new FileReader();
            r.onload = e => { prev.src = e.target.result; prev.style.display = 'block'; };
            r.readAsDataURL(input.files[0]);
        }
    }

    function updateThumb(input, thumbId) {
        const el = document.getElementById(thumbId);
        if (input.files && input.files[0] && el && el.tagName === 'IMG') {
            const r = new FileReader();
            r.onload = e => { el.src = e.target.result; };
            r.readAsDataURL(input.files[0]);
        }
    }

    /* ── Toggle Edit Slide ── */
    function toggleEdit(slideId, cardId, accentColor) {
        const slide = document.getElementById(slideId);
        const card  = document.getElementById(cardId);
        slide.classList.toggle('open');
        const color = accentColor || 'rgba(139,92,246,0.4)';
        const shadow = accentColor
            ? `0 0 0 1px ${accentColor.replace('.4','0.15')}`
            : '0 0 0 1px rgba(139,92,246,0.15)';
        if (slide.classList.contains('open')) {
            card.style.borderColor = color;
            card.style.boxShadow   = shadow;
            setTimeout(() => slide.scrollIntoView({ behavior: 'smooth', block: 'nearest' }), 60);
        } else {
            card.style.borderColor = '';
            card.style.boxShadow   = '';
        }
    }

    /* ── Search Filter ── */
    function filterCards(query, cls) {
        const q = query.toLowerCase().trim();
        document.querySelectorAll('.' + cls).forEach(c => {
            c.style.display = (c.dataset.search || '').includes(q) ? '' : 'none';
        });
    }

    /* ── Toggle Create Form ── */
    function toggleCreate(bodyId, chevId) {
        const body = document.getElementById(bodyId);
        const chev = document.getElementById(chevId);
        const open = body.style.display === 'none';
        body.style.display = open ? '' : 'none';
        chev.className = open ? 'fas fa-chevron-up' : 'fas fa-chevron-down';
    }

    /* ── Delete Modal ── */
    function openDel(id, name, route) {
        document.getElementById('delDesc').innerHTML =
            `Kamu yakin ingin menghapus <strong>"${name}"</strong>? Tindakan ini tidak bisa dibatalkan.`;
        document.getElementById('delForm').action = `/${route}/${id}`;
        document.getElementById('delOverlay').classList.add('open');
    }

    function closeDel() { document.getElementById('delOverlay').classList.remove('open'); }

    /* ── Mobile Sidebar Toggle ── */
    function toggleSidebar() {
        const sb  = document.getElementById('sidebar');
        const ov  = document.getElementById('sbOverlay');
        const ico = document.getElementById('hamIco');
        const open = sb.classList.toggle('open');
        ov.classList.toggle('open', open);
        ico.className = open ? 'fas fa-xmark' : 'fas fa-bars';
        document.body.style.overflow = open ? 'hidden' : '';
    }

    function closeSidebar() {
        const sb  = document.getElementById('sidebar');
        const ov  = document.getElementById('sbOverlay');
        const ico = document.getElementById('hamIco');
        sb.classList.remove('open');
        ov.classList.remove('open');
        ico.className = 'fas fa-bars';
        document.body.style.overflow = '';
    }

    /* Close sidebar on resize to desktop */
    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) closeSidebar();
    });

    document.addEventListener('DOMContentLoaded', () => {
        const overlay = document.getElementById('delOverlay');
        if (overlay) overlay.addEventListener('click', e => { if (e.target === overlay) closeDel(); });
    });

    /* ── Flash sessions ── */
    @if (session('success'))
        toast("{{ addslashes(session('success')) }}", 'success');
    @endif
    @if (session('error'))
        toast("{{ addslashes(session('error')) }}", 'error');
    @endif
    @if ($errors->any())
        toast("{{ addslashes($errors->first()) }}", 'error');
    @endif
</script>

@yield('scripts')

</body>
</html>
