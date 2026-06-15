<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAKTI Portal – Formulir Peserta Didik</title>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --navy: #1a2a6c;
            --blue: #004AAD;
            --gold: #f5c400;
            --gold-dark: #c9a200;
            --bg: #f0f2f8;
            --surface: #ffffff;
            --surface2: #f4f6fb;
            --border: #e0e4ef;
            --text: #1a1f36;
            --muted: #7b82a0;
            --green: #16a34a;
            --red: #dc2626;
            --radius: 14px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            max-width: 1152px;
            width: 100%;
            margin: 24px auto 0 auto;
            padding: 0 16px;
        }

        /* ===================== TOPBAR / NAVBAR ===================== */
        .topbar-wrapper {
            width: 100%;
            background: var(--bg);
            padding-top: 16px; /* Jarak dari paling atas layar dikurangi agar lebih presisi */
            animation: fadeIn 0.6s ease forwards;
        }

        .topbar {
            background: var(--surface);
            border-radius: 16px; /* DIUBAH LANGSUNG KE ANGKA: Biar langsung rounded sempurna tanpa variabel gaib */
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 20px rgba(0, 43, 91, 0.04);
            border: 1px solid var(--border); /* Ditambahkan border tipis agar senada dengan main-card */
        }

        .topbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-logo-box {
            width: 44px;
            height: 44px;
            background: var(--navy);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease;
        }

        .topbar-brand:hover .brand-logo-box {
            transform: rotate(-5deg) scale(1.05);
        }

        .brand-logo-box i {
            color: #ffffff;
            font-size: 20px;
        }

        .brand-title {
            font-size: 16px;
            font-weight: 900;
            color: var(--text-dark);
            letter-spacing: 0.5px;
            line-height: 1.2;
        }

        .brand-meta {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 2px;
        }

        .badge-parent {
            background: var(--gold-light);
            color: var(--gold);
            border: 1px solid var(--gold-border);
            font-size: 9px;
            font-weight: 800;
            padding: 1px 6px;
            border-radius: 99px;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            gap: 3px;
        }

        .uid-text {
            font-family: 'DM Mono', monospace;
            font-size: 9px;
            color: #94a3b8;
        }

        /* Nav Links */
        .topbar-nav {
            display: flex;
            align-items: center;
            gap: 28px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            color: var(--text-gray);
            font-size: 13.5px;
            font-weight: 700;
            transition: color 0.3s ease;
            position: relative;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--navy);
        }

        /* Indikator Titik Emas Aktif */
        .nav-link.active .nav-dot {
            width: 5px;
            height: 5px;
            background: var(--gold);
            border-radius: 50%;
            display: inline-block;
            margin-left: 2px;
            animation: fadeIn 0.3s ease;
        }

        /* Topbar Right */
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-info {
            text-align: right;
            line-height: 1.3;
        }

        .user-name {
            font-size: 13.5px;
            font-weight: 800;
            color: var(--text-dark);
        }

        .user-branch {
            font-size: 9.5px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-logout {
            width: 38px;
            height: 38px;
            background: #FFF0F0;
            border: none;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-logout:hover {
            background: #FFE0E0;
            transform: scale(1.05);
        }

        .btn-logout i {
            color: #FF4D4D;
            font-size: 14px;
        }


        /* ===================== PAGE BODY ===================== */
        .page-body {
            flex: 1;
            padding: 36px 32px;
            max-width: 940px;
            width: 100%;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        /* ===================== PAGE HEADER ===================== */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            opacity: 0;
            animation: fadeUp 0.5s ease 0.05s forwards;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .page-title {
            font-size: 26px;
            font-weight: 800;
            color: var(--navy);
            letter-spacing: -0.3px;
        }

        .page-subtitle {
            color: var(--muted);
            font-size: 13.5px;
            margin-top: 3px;
        }

        .header-actions {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 22px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
            white-space: nowrap;
        }

        .btn-outline {
            background: var(--surface);
            border: 1.5px solid var(--border);
            color: var(--text);
        }

        .btn-outline:hover {
            border-color: var(--blue);
            color: var(--blue);
            background: rgba(0, 74, 173, 0.04);
        }

        /* ===================== FORM CARD ===================== */
        .form-card {
            background: var(--surface);
            border-radius: 18px;
            border: 1px solid var(--border);
            padding: 32px;
            box-shadow: 0 4px 32px rgba(26, 42, 108, 0.06);
            position: relative;
            opacity: 0;
            animation: fadeUp 0.5s ease 0.15s forwards;
        }

        .data-anak-badge {
            position: absolute;
            top: -1px;
            right: 28px;
            background: var(--gold);
            color: var(--navy);
            font-size: 12px;
            font-weight: 800;
            padding: 8px 20px;
            border-radius: 0 0 12px 12px;
            letter-spacing: 0.4px;
            box-shadow: 0 4px 14px rgba(245, 196, 0, 0.3);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
        }

        .form-col {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .col-header {
            display: flex;
            align-items: center;
            gap: 8px;
            padding-bottom: 12px;
            border-bottom: 1.5px solid var(--border);
        }

        .col-header-title {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.4px;
            text-transform: uppercase;
            color: var(--muted);
        }

        .field-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .field-group.required .field-label::after,
        .field-row.required .field-label::after,
        .upload-item.required .upload-name::after {
            content: " *";
            color: var(--red);
        }

        .field-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .field-label {
            font-size: 10.5px;
            font-weight: 800;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            color: var(--muted);
        }

        .field-input {
            height: 46px;
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 9px;
            padding: 0 14px;
            font-size: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text);
            font-weight: 500;
            transition: all 0.2s;
            width: 100%;
        }

        .field-input::placeholder {
            color: #b0b7d0;
            font-weight: 400;
        }

        .field-input:focus,
        .field-select:focus,
        .field-textarea:focus {
            outline: none;
            border-color: var(--blue);
            background: #f5f8ff;
            box-shadow: 0 0 0 3px rgba(0, 74, 173, 0.09);
        }

        .field-input.is-invalid,
        .field-select.is-invalid,
        .field-textarea.is-invalid,
        .upload-item.is-invalid {
            border-color: var(--red) !important;
            background: #fff5f5 !important;
            animation: shake 0.35s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .field-select {
            height: 46px;
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 9px;
            padding: 0 40px 0 14px;
            font-size: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text);
            font-weight: 500;
            transition: all 0.2s;
            width: 100%;
            appearance: none;
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%237b82a0' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
        }

        .field-textarea {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 9px;
            padding: 12px 14px;
            font-size: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text);
            font-weight: 500;
            transition: all 0.2s;
            width: 100%;
            resize: none;
            height: 96px;
        }

        .alamat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .samakan-btn {
            font-size: 10px;
            font-weight: 800;
            color: var(--blue);
            background: none;
            border: none;
            cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif;
            padding: 3px 8px;
            border-radius: 6px;
            transition: background 0.2s;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .samakan-btn:hover { background: rgba(0, 74, 173, 0.07); }

        /* ===== UPLOAD BERKAS ===== */
        .upload-label {
            font-size: 10.5px;
            font-weight: 800;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 10px;
            display: block;
        }

        .upload-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .upload-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 9px;
            padding: 10px 12px;
            transition: all 0.2s;
            cursor: pointer;
            gap: 6px;
        }

        .upload-item:hover { border-color: var(--blue); background: #f5f8ff; }
        .upload-item.uploaded { border-color: rgba(22, 163, 74, 0.35); background: #f6fff9; }

        .upload-left { display: flex; align-items: center; gap: 8px; min-width: 0; }
        .upload-doc-icon { color: var(--muted); font-size: 15px; flex-shrink: 0; }
        .upload-item.uploaded .upload-doc-icon { color: var(--green); }
        .upload-name { font-size: 12.5px; font-weight: 600; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .upload-wajib { font-size: 10px; font-weight: 700; color: var(--red); background: rgba(220, 38, 38, 0.08); border-radius: 4px; padding: 1px 5px; flex-shrink: 0; }
        .upload-actions { display: flex; align-items: center; gap: 4px; flex-shrink: 0; }

        .upload-action-btn {
            width: 28px;
            height: 28px;
            border-radius: 7px;
            border: 1.5px solid var(--border);
            background: var(--surface2);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            transition: all 0.18s;
            color: var(--muted);
        }

        .upload-action-btn:hover {
            border-color: var(--blue);
            color: var(--blue);
            background: rgba(0, 74, 173, 0.06);
        }

        .btn-preview-disabled { opacity: 0.3; cursor: not-allowed; pointer-events: none; }
        .upload-file-input { display: none; }

        /* ===================== BOTTOM BAR ===================== */
        .bottom-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            opacity: 0;
            animation: fadeUp 0.5s ease 0.25s forwards;
            padding-bottom: 12px;
        }

        .back-link {
            color: var(--muted);
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s;
        }

        .back-link:hover { color: var(--blue); }
        .bottom-actions { display: flex; gap: 10px; align-items: center; }

        .btn-draft {
            background: var(--surface);
            border: 1.5px solid var(--border);
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: all 0.2s;
        }

        .btn-draft:hover { border-color: var(--blue); color: var(--blue); background: rgba(0, 74, 173, 0.04); }

        .btn-submit {
            background: var(--navy);
            color: #fff;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 13px 32px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif;
            border: none;
            letter-spacing: 0.6px;
            transition: all 0.2s;
            position: relative;
            overflow: hidden;
        }

        .btn-submit:hover {
            background: #111c50;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(26, 42, 108, 0.32);
        }

        .btn-submit .arrow { transition: transform 0.25s; font-size: 18px; }
        .btn-submit:hover .arrow { transform: translateX(5px); }

        /* ===================== MODAL WINDOW POP-UP SYSTEM ===================== */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(26, 42, 108, 0.4);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .modal-overlay.show {
            opacity: 1;
            pointer-events: auto;
        }

        .modal-box {
            background: var(--surface);
            padding: 32px;
            border-radius: 24px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }

        .modal-box-large {
            max-width: 700px;
            width: 95%;
            height: 80vh;
            display: flex;
            flex-direction: column;
            padding: 24px;
        }

        .modal-overlay.show .modal-box { transform: scale(1); }

        .modal-icon {
            width: 56px;
            height: 56px;
            background: #fff5f5;
            color: var(--red);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin: 0 auto 16px auto;
        }

        .modal-icon-warn {
            background: #fffbeb;
            color: var(--gold-dark);
        }

        .modal-title { font-size: 18px; font-weight: 800; color: var(--navy); margin-bottom: 8px; }
        .modal-desc { font-size: 14px; color: var(--muted); line-height: 1.5; margin-bottom: 24px; }

        .preview-viewport-content {
            flex: 1;
            width: 100%;
            background: var(--surface2);
            border-radius: 12px;
            margin-bottom: 16px;
            overflow: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px dashed var(--border);
        }

        .preview-viewport-content img { max-width: 100%; max-height: 100%; object-fit: contain; }
        .preview-viewport-content iframe { width: 100%; height: 100%; border: none; }

        .modal-btn-close {
            background: var(--navy);
            color: var(--surface);
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            width: 100%;
        }

        .modal-btn-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .modal-btn-cancel {
            background: var(--surface2);
            color: var(--text);
            border: 1px solid var(--border);
        }
        .modal-btn-cancel:hover { background: #e2e8f0; }

        .page-footer { text-align: center; padding: 20px; font-size: 11px; font-weight: 600; color: var(--muted); letter-spacing: 1.2px; text-transform: uppercase; }
        
        /* ==================== CORE FIX: RE-POSITIONING TOAST MECHANISM ==================== */
        #toast { 
            position: fixed; 
            bottom: 30px; 
            right: 30px; 
            background: var(--navy); 
            color: white; 
            padding: 14px 28px; 
            border-radius: 12px; 
            font-size: 13.5px; 
            font-weight: 600; 
            opacity: 0; 
            pointer-events: none; 
            transform: translateX(30px); 
            transition: transform 0.4s cubic-bezier(0.22, 1, 0.36, 1), opacity 0.4s; 
            z-index: 9999; 
            box-shadow: 0 10px 25px -5px rgba(26, 42, 108, 0.3); 
            display: flex;
            align-items: center;
            gap: 10px;
        }
        #toast.show { opacity: 1; transform: translateX(0); }

        /* ===================== PERBAIKAN: MASTER GRID RESPONSIVE UI ===================== */
        @media (max-width: 900px) { 
            .form-grid { grid-template-columns: 1fr; gap: 24px; } 
            .page-body { padding: 24px 16px; } 
            .form-card { padding: 24px; }
        }

        @media (max-width: 768px) {
            .topbar { padding: 12px 20px; }
            .topbar-nav { gap: 16px; }
            .page-title { font-size: 22px; }
        }

        @media (max-width: 640px) { 
            .topbar { flex-direction: column; gap: 14px; padding: 16px; text-align: center; }
            .topbar-brand { flex-direction: column; gap: 4px; }
            .topbar-nav { width: 100%; justify-content: center; gap: 16px; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); padding: 8px 0; }
            .topbar-right { width: 100%; justify-content: space-between; }
            .user-info { text-align: left; }
            .page-header { flex-direction: column; align-items: stretch; text-align: center; }
            .btn-outline { width: 100%; justify-content: center; }
            .field-row { grid-template-columns: 1fr; gap: 20px; }
            .upload-grid { grid-template-columns: 1fr; }
            .upload-item { style="grid-column: span 1 !important;" }
            .bottom-bar { flex-direction: column; align-items: stretch; gap: 20px; } 
            .bottom-actions { flex-direction: column; width: 100%; } 
            .btn-draft, .btn-submit { width: 100%; justify-content: center; } 
            #toast { left: 20px; right: 20px; bottom: 20px; transform: translateY(30px); text-align: center; justify-content: center; }
            #toast.show { transform: translateY(0); }
        }
    </style>
</head>

<body>

   <div class="topbar-wrapper">
        <div class="container">
            <header class="topbar">
                
                <div class="topbar-brand">
                    <img src="{{ asset('img/E-Kanisius 1.png') }}" alt="E-Kanisius Logo" 
                         style="width:85px; height:auto; object-fit:contain; flex-shrink:0;" 
                         onerror="this.style.display='none'; document.getElementById('fallback-logo').style.display='flex';">
                    
                    <div id="fallback-logo" class="brand-logo-box" style="display:none;">
                        <i class="fa-solid fa-building-columns"></i>
                    </div>
                    
                    <div class="brand-text">
                        <div class="brand-title">SAKTI PORTAL</div>
                        <div class="brand-meta">
                            <span class="badge-parent"><i class="fa-solid fa-shield-halved"></i> Parent</span>
                            <span class="uid-text">UID-MOCK-parent-001</span>
                        </div>
                    </div>
                </div>

                <nav class="topbar-nav">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                    <a class="nav-link" href="{{ route('riwayat') }}">
                        Riwayat 
                    </a>
                    <a class="nav-link" href="{{ route('pusat_bantuan') }}">
                        Pusat Bantuan
                    </a>
                </nav>

                <div class="topbar-right">
                    <div class="user-info">
                        <div class="user-name">Ortu Demo</div>
                        <div class="user-branch">Cabang Global</div>
                    </div>
                    
                    <!-- FIX LOGOUT: Diubah menggunakan Button pemicu JavaScript POST terstruktur -->
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <!-- Memanggil modal khusus logout saat di-klik -->
                    <button type="button" class="btn-logout" title="Keluar" onclick="openLogoutModal()">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </button>
                </div>
            </header>
        </div>
    </div>

        <form id="formPesertaDidik" action="{{ route('form.daftar.store') }}" method="POST" class="page-body" novalidate>
            @csrf
            <div class="page-header">
                <div>
                    <h1 class="page-title">Formulir Peserta Didik</h1>
                    <p class="page-subtitle">Unit Tujuan: <strong>• 1 Calon Murid</strong></p>
                </div>
                <div class="header-actions">
                    <button type="button" class="btn btn-outline" id="btnTambahAnak" onclick="tambahAnak(this, event)">
                        ＋ TAMBAH ANAK
                    </button>
                </div>
            </div>

            <div class="form-card">
                <div class="data-anak-badge" id="anakBadge">DATA ANAK 1</div>

                <div class="form-grid">
                    <div class="form-col">
                        <div class="col-header">
                            <span class="col-header-title">Identitas Dasar</span>
                        </div>

                        <div class="field-group required">
                            <label class="field-label" for="namaLengkap">Nama Lengkap</label>
                            <input type="text" id="namaLengkap" name="nama_lengkap" class="field-input" placeholder="Nama Lengkap" autocomplete="off" oninput="validateField(this, v => v.trim().length >= 3)">
                        </div>

                        <div class="field-group required">
                            <label class="field-label" for="nik">NIK (Nomor Induk Kependudukan)</label>
                            <input type="text" id="nik" name="nik" class="field-input" placeholder="16 Digit NIK" maxlength="16" autocomplete="off" oninput="onlyDigits(this); validateField(this, v => /^\d{16}$/.test(v))">
                        </div>

                        <div class="field-row required">
                            <div class="field-group">
                                <label class="field-label" for="tanggalLahir">Tanggal Lahir</label>
                                <input type="date" id="tanggalLahir" name="tanggal_lahir" class="field-input" onchange="validateField(this, v => v !== '')">
                            </div>
                            <div class="field-group">
                                <label class="field-label" for="golDarah">Gol. Darah</label>
                                <select id="golDarah" name="gol_darah" class="field-select" onchange="onSelectChange(this)">
                                    <option value="O" selected>O</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-col">
                        <div class="col-header">
                            <span class="col-header-title">Informasi Lanjutan</span>
                        </div>

                        <div class="field-group required">
                            <label class="field-label" for="agama">Agama</label>
                            <select id="agama" name="agama" class="field-select" onchange="onSelectChange(this); toggleSuratBaptis(this.value)">
                                <option value="" selected disabled>Pilih Agama</option>
                                <option value="kristen">Kristen</option>
                                <option value="katolik">Katolik</option>
                                <option value="islam">Islam</option>
                                <option value="buddha">Buddha</option>
                                <option value="hindu">Hindu</option>
                                <option value="konghucu">Konghucu</option>
                            </select>
                        </div>

                        <div class="field-group required">
                            <div class="alamat-header">
                                <label class="field-label" for="alamat">Alamat Domisili Anak</label>
                                <button type="button" class="samakan-btn" onclick="samakanAlamat()">
                                    Samakan dengan Alamat Ortu
                                </button>
                            </div>
                            <textarea id="alamat" name="alamat" class="field-textarea" placeholder="Masukkan alamat lengkap tempat tinggal anak..." oninput="validateField(this, v => v.trim().length >= 5)"></textarea>
                        </div>

                        <div class="field-group required">
                            <label class="field-label" for="tempat-lahir">Tempat Lahir Anak</label>
                            <input type="text" id="tempat-lahir" name="tempat_lahir" class="field-input" placeholder="Masukkan kota tempat lahir anak..." oninput="validateField(this, v => v.trim().length >= 3)">
                        </div>

                        <div class="field-group">
                            <span class="upload-label">Upload Berkas Fisik</span>
                            <div class="upload-grid">
                                <div class="upload-item required" id="item-kk" onclick="triggerUpload('file-kk')">
                                    <div class="upload-left"><span class="upload-name">Kartu Keluarga</span></div>
                                    <div class="upload-actions">
                                        <button type="button" id="btn-prev-file-kk" class="upload-action-btn btn-preview-disabled" title="Preview" onclick="previewDoc(event,'file-kk','Kartu Keluarga')">👁</button>
                                        <button type="button" class="upload-action-btn" title="Upload" onclick="triggerUpload('file-kk', event)">↑</button>
                                    </div>
                                    <input type="file" id="file-kk" class="upload-file-input" accept="image/*,.pdf" onchange="onUpload(this,'item-kk','btn-prev-file-kk')">
                                </div>

                                <div class="upload-item required" id="item-akte" onclick="triggerUpload('file-akte')">
                                    <div class="upload-left"><span class="upload-name">Akte Kelahiran</span></div>
                                    <div class="upload-actions">
                                        <button type="button" id="btn-prev-file-akte" class="upload-action-btn btn-preview-disabled" title="Preview" onclick="previewDoc(event,'file-akte','Akte Kelahiran')">👁</button>
                                        <button type="button" class="upload-action-btn" title="Upload" onclick="triggerUpload('file-akte', event)">↑</button>
                                    </div>
                                    <input type="file" id="file-akte" class="upload-file-input" accept="image/*,.pdf" onchange="onUpload(this,'item-akte','btn-prev-file-akte')">
                                </div>

                                <div class="upload-item required" id="item-ktp" onclick="triggerUpload('file-ktp')">
                                    <div class="upload-left"><span class="upload-name">E-KTP Orang Tua</span></div>
                                    <div class="upload-actions">
                                        <button type="button" id="btn-prev-file-ktp" class="upload-action-btn btn-preview-disabled" title="Preview" onclick="previewDoc(event,'file-ktp','E-KTP Orang Tua')">👁</button>
                                        <button type="button" class="upload-action-btn" title="Upload" onclick="triggerUpload('file-ktp', event)">↑</button>
                                    </div>
                                    <input type="file" id="file-ktp" class="upload-file-input" accept="image/*,.pdf" onchange="onUpload(this,'item-ktp','btn-prev-file-ktp')">
                                </div>

                                <div class="upload-item required" id="item-foto" onclick="triggerUpload('file-foto')">
                                    <div class="upload-left"><span class="upload-name">Pas Foto (3x4)</span></div>
                                    <div class="upload-actions">
                                        <button type="button" id="btn-prev-file-foto" class="upload-action-btn btn-preview-disabled" title="Preview" onclick="previewDoc(event,'file-foto','Pas Foto 3x4')">👁</button>
                                        <button type="button" class="upload-action-btn" title="Upload" onclick="triggerUpload('file-foto', event)">↑</button>
                                    </div>
                                    <input type="file" id="file-foto" class="upload-file-input" accept="image/*" onchange="onUpload(this,'item-foto','btn-prev-file-foto')">
                                </div>

                                <div class="upload-item" id="item-baptis" style="grid-column: span 2; display: none;" onclick="triggerUpload('file-baptis')">
                                    <div class="upload-left">
                                        <span class="upload-doc-icon">📄</span>
                                        <span class="upload-name">Surat Baptis</span>
                                        <span class="upload-wajib">Wajib</span>
                                    </div>
                                    <div class="upload-actions">
                                        <button type="button" id="btn-prev-file-baptis" class="upload-action-btn btn-preview-disabled" title="Preview" onclick="previewDoc(event,'file-baptis','Surat Baptis')">👁</button>
                                        <button type="button" class="upload-action-btn" title="Upload" onclick="triggerUpload('file-baptis', event)">↑</button>
                                    </div>
                                    <input type="file" id="file-baptis" class="upload-file-input" accept="image/*,.pdf" onchange="onUpload(this,'item-baptis','btn-prev-file-baptis')">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bottom-bar">
                <a href="{{ route('profil.ortu') }}" class="back-link" id="btnLinkKembali">← Kembali ke Profil Ortu</a>
                <div class="bottom-actions">
                    <button type="button" class="btn-draft" id="btnDraft" onclick="saveDraft(this, event)">
                        SIMPAN DRAFT
                    </button>
                    <button type="submit" class="btn-submit" id="btnSubmit">
                        SUBMIT SEKARANG <span class="arrow">›</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div id="errorModal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-icon"><i class="fa-solid fa-circle-exclamation"></i></div>
            <h3 class="modal-title">Data Belum Lengkap</h3>
            <p class="modal-desc">Mohon periksa kembali. Seluruh bidang data bertanda bintang (*) dan berkas wajib harus diisi sebelum melanjutkan.</p>
            <button type="button" id="closeModalBtn" class="modal-btn-close">Mengerti</button>
        </div>
    </div>

    <div id="previewModal" class="modal-overlay">
        <div class="modal-box modal-box-large">
            <h3 class="modal-title" id="previewModalTitle" style="margin-bottom: 12px; text-align: left;">Pratinjau Berkas</h3>
            <div class="preview-viewport-content" id="previewViewport"></div>
            <button type="button" id="closePreviewModalBtn" class="modal-btn-close">Tutup Pratinjau</button>
        </div>
    </div>

    <div id="confirmLeaveModal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-icon modal-icon-warn"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <h3 class="modal-title">Tinggalkan Halaman?</h3>
            <p class="modal-desc">Data pendaftaran calon murid belum disimpan ke sistem. Apakah Anda yakin ingin keluar dan membuang perubahan?</p>
            <div class="modal-btn-group">
                <button type="button" id="btnCancelLeave" class="modal-btn-close modal-btn-cancel">Batal</button>
                <button type="button" id="btnConfirmLeave" class="modal-btn-close" style="background: var(--red);">Ya, Keluar</button>
            </div>
        </div>
    </div>

    <!-- ADD MODAL: Struktur Pop-Up Khusus Konfirmasi Logout -->
    <div id="logoutModal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-icon" style="background: #fff5f5; color: var(--red);"><i class="fa-solid fa-arrow-right-from-bracket"></i></div>
            <h3 class="modal-title">Mengakhiri Sesi?</h3>
            <p class="modal-desc">Apakah Anda yakin ingin keluar dari SAKTI Portal?</p>
            <div class="modal-btn-group">
                <button type="button" onclick="closeLogoutModal()" class="modal-btn-close modal-btn-cancel">Batal</button>
                <button type="button" onclick="handleLogout()" class="modal-btn-close" style="background: var(--navy);">Ya, Keluar</button>
            </div>
        </div>
    </div>

    <div id="toast"></div>

    <script>
        /* ============================================================
            TOAST UTILITIES & FIX NAME BINDING
        ============================================================ */
        function showToast(msg, dur = 3000) {
            const t = document.getElementById('toast');
            if (!t) return;
            t.innerHTML = msg; // Menggunakan innerHTML agar tag ikon FontAwesome bisa dirender
            t.classList.add('show');
            clearTimeout(t._timer);
            t._timer = setTimeout(() => t.classList.remove('show'), dur);
        }

        function addRipple(btn, e) {
            if (!e) return;
            const rect = btn.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const r = document.createElement('span');
            r.className = 'ripple';
            r.style.cssText = `left:${x}px;top:${y}px;width:${rect.width}px;height:${rect.width}px;margin-left:-${rect.width / 2}px;margin-top:-${rect.width / 2}px;`;
            btn.appendChild(r);
            setTimeout(() => r.remove(), 600);
        }

        /* ============================================================
            LIVE FIELD VALIDATION
        ============================================================ */
        function validateField(el, rule) {
            if (el.value === '' || el.value === null) {
                el.classList.remove('is-valid', 'is-invalid');
                return;
            }
            const ok = rule(el.value);
            el.classList.toggle('is-valid', ok);
            el.classList.toggle('is-invalid', !ok);
        }

        function onlyDigits(el) { el.value = el.value.replace(/\D/g, '').slice(0, 16); }
        function onSelectChange(el) { el.classList.remove('is-invalid'); el.classList.add('is-valid'); }

        /* ============================================================
            TOGGLE SURAT BAPTIS STATE
        ============================================================ */
        let isKatolik = false;
        function toggleSuratBaptis(val) {
            const item = document.getElementById('item-baptis');
            if (val === 'katolik') {
                isKatolik = true;
                item.style.display = 'flex';
                item.style.opacity = '0';
                item.style.transform = 'translateY(-6px)';
                requestAnimationFrame(() => {
                    item.style.transition = 'opacity 0.35s ease, transform 0.35s ease';
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                });
                showToast('⛪ Surat Baptis wajib dilampirkan untuk calon murid Katolik');
            } else {
                isKatolik = false;
                item.style.transition = 'opacity 0.25s ease, transform 0.25s ease';
                item.style.opacity = '0';
                item.style.transform = 'translateY(-6px)';
                setTimeout(() => {
                    item.style.display = 'none';
                    const fileInput = document.getElementById('file-baptis');
                    if (fileInput) fileInput.value = '';
                    item.classList.remove('uploaded', 'is-invalid');
                    document.getElementById('btn-prev-file-baptis').classList.add('btn-preview-disabled');
                }, 260);
            }
        }

        /* ============================================================
            SAMAKAN ALAMAT
        ============================================================ */
        function samakanAlamat() {
            const ta = document.getElementById('alamat');
            ta.value = "Jl. Jend. Sudirman No. 45, Yogyakarta";
            ta.classList.remove('is-invalid');
            ta.classList.add('is-valid');
            showToast('🏠 Alamat disalin dari data orang tua');
        }

        /* ============================================================
            LOCAL FILE BINDING UPLOAD MECHANISM
        ============================================================ */
        function triggerUpload(inputId, e) {
            if (e) e.stopPropagation();
            document.getElementById(inputId).click();
        }

        /* ============================================================
            PERBAIKAN: FIX FUNCTION NAME FROM showToast
        ============================================================ */
        function onUpload(input, itemId, previewBtnId) {
            if (!input.files || !input.files[0]) return;
            const item = document.getElementById(itemId);
            const prevBtn = document.getElementById(previewBtnId);
            const name = input.files[0].name;

            item.classList.add('uploaded');
            item.classList.remove('is-invalid');
            prevBtn.classList.remove('btn-preview-disabled'); // Aktifkan tombol mata pratinjau berkas
            showToast(`📎 Berkas "${name.slice(0, 15)}..." berhasil dipilih`);
        }

        /* ============================================================
            PERBAIKAN: CORE LOGIC RENDERER PREVIEW DOKUMEN & GAMBAR LOKAL
        ============================================================ */
        const previewModal = document.getElementById('previewModal');
        const previewViewport = document.getElementById('previewViewport');
        const previewModalTitle = document.getElementById('previewModalTitle');

        function previewDoc(e, inputId, labelName) {
            e.stopPropagation(); // Matikan bubbling klik agar dialog upload tidak terbuka ganda
            
            const fileInput = document.getElementById(inputId);
            if (!fileInput.files || !fileInput.files[0]) return;

            const file = fileInput.files[0];
            const fileType = file.type;
            
            previewModalTitle.textContent = `Pratinjau Berkas: ${labelName}`;
            previewViewport.innerHTML = ''; // Reset DOM viewport render

            const reader = new FileReader();

            // Skenario 1: Jika berkas bertipe PDF, buat Blob URL lokal untuk Iframe render
            if (fileType === "application/pdf") {
                const blobURL = URL.createObjectURL(file);
                const iframe = document.createElement('iframe');
                iframe.src = blobURL;
                previewViewport.appendChild(iframe);
            } 
            // Skenario 2: Jika berkas berupa gambar/citra biner murni
            else if (fileType.startsWith("image/")) {
                reader.onload = function (event) {
                    const img = document.createElement('img');
                    img.src = event.target.result;
                    previewViewport.appendChild(img);
                };
                reader.readAsDataURL(file);
            } else {
                showToast('❌ Format berkas tidak didukung.');
                return;
            }

            previewModal.classList.add('show');
        }

        document.getElementById('closePreviewModalBtn').addEventListener('click', () => {
            previewModal.classList.remove('show');
            previewViewport.innerHTML = ''; // Flush DOM render object
        });

        /* ============================================================
            PERBAIKAN: LOGIKA VALIDASI ALASAN GAGAL SIMPAN DRAFT & RE-ROUTE showToast
        ============================================================ */
        function saveDraft(btn, e) {
            if (e) addRipple(btn, e);
            
            const namaField = document.getElementById('namaLengkap');

            // Proteksi alasan kegagalan: Berikan keterangan field minimal pendaftaran draf
            if (!namaField.value || namaField.value.trim().length < 3) {
                showToast('⚠️ Gagal menyimpan draf: Data tidak lengkap.');
                namaField.classList.add('is-invalid');
                return;
            }

            btn.disabled = true;
            btn.textContent = 'Menyimpan...';
            
            setTimeout(() => {
                btn.innerHTML = 'Draft Tersimpan';
                showToast('💾 data formulir anak berhasil disimpan dalam draft!');
                namaField.classList.remove('is-invalid');
                setTimeout(() => { btn.innerHTML = 'SIMPAN DRAFT'; btn.disabled = false; }, 2000);
            }, 1000);
        }

        /* ============================================================
            ADD LOGOUT MODAL TOGGLES: Fungsi buka tutup modal & trigger form POST
        ============================================================ */
        const logModal = document.getElementById('logoutModal');

        function openLogoutModal() {
            logModal.classList.add('show');
        }

        function closeLogoutModal() {
            logModal.classList.remove('show');
        }

        function handleLogout() {
            // Tutup modal konfirmasi logout terlebih dahulu
            closeLogoutModal();
            
            // Render animasi toast di pojok kanan bawah halaman
            showToast('<i class="fas fa-arrow-right-from-bracket"></i> Mengakhiri Sesi...');
            
            // Eksekusi pengakhiran session Laravel form POST setelah transisi toast selesai
            setTimeout(() => {
                const logoutForm = document.getElementById('logout-form');
                if (logoutForm) logoutForm.submit();
            }, 800); 
        }

        /* ============================================================
            PERBAIKAN: DETEKSI INTERSEPSI UNSAVED CHANGES GUARD (KEMBALI)
        ============================================================ */
        const leaveModal = document.getElementById('confirmLeaveModal');
        const btnLinkKembali = document.getElementById('btnLinkKembali');
        const btnCancelLeave = document.getElementById('btnCancelLeave');
        const btnConfirmLeave = document.getElementById('btnConfirmLeave');
        
        let targetLeaveUrl = "";

        function checkUnsavedChanges(e, targetUrl) {
            const namaLengkap = document.getElementById('namaLengkap').value;
            const nik = document.getElementById('nik').value;
            const alamat = document.getElementById('alamat').value;

            // Jika form sudah mulai diotak-atik isinya oleh pengguna, nyalakan popup filter pencegatan
            if (namaLengkap.trim() !== "" || nik.trim() !== "" || alamat.trim() !== "") {
                e.preventDefault();
                targetLeaveUrl = targetUrl;
                leaveModal.classList.add('show'); // Munculkan modal peringatan data belum di-save
            }
        }

        btnLinkKembali.addEventListener('click', function(e) {
            checkUnsavedChanges(e, this.getAttribute('href'));
        });

        // Pantau juga interaksi klik pada menu bar atas topbar
        document.querySelectorAll('.topbar-nav .nav-link, .btn-logout').forEach(link => {
            link.addEventListener('click', function(e) {
                if(this.classList.contains('btn-logout')) return; // Bypass form submit logout karena ditangani modal khusus
                checkUnsavedChanges(e, this.getAttribute('href') || '#');
            });
        });

        btnCancelLeave.addEventListener('click', () => leaveModal.classList.remove('show'));
        btnConfirmLeave.addEventListener('click', () => window.location.href = targetLeaveUrl);

        /* ============================================================
            GLOBAL FORM SUBMIT MECHANISM
        ============================================================ */
        const form = document.getElementById("formPesertaDidik");
        const modal = document.getElementById("errorModal");
        const closeModalBtn = document.getElementById("closeModalBtn");

        form.addEventListener("submit", function (event) {
            event.preventDefault(); 
            let isFormValid = true;

            const fieldsToValidate = [
                { id: 'namaLengkap', check: v => v.trim().length >= 3 },
                { id: 'nik', check: v => /^\d{16}$/.test(v) },
                { id: 'tanggalLahir', check: v => v !== '' },
                { id: 'agama', check: v => v !== '' },
                { id: 'alamat', check: v => v.trim().length >= 5 },
                { id: 'tempat-lahir', check: v => v.trim().length >= 3 }
            ];

            fieldsToValidate.forEach(({ id, check }) => {
                const el = document.getElementById(id);
                if (!check(el.value)) { isFormValid = false; el.classList.add('is-invalid'); } 
                else { el.classList.remove('is-invalid'); }
            });

            ['item-kk', 'item-akte', 'item-ktp', 'item-foto'].forEach(id => {
                const item = document.getElementById(id);
                if (!item.classList.contains('uploaded')) { isFormValid = false; item.classList.add('is-invalid'); } 
                else { item.classList.remove('is-invalid'); }
            });

            if (isKatolik) {
                const baptisItem = document.getElementById('item-baptis');
                if (!baptisItem.classList.contains('uploaded')) { isFormValid = false; baptisItem.classList.add('is-invalid'); } 
                else { baptisItem.classList.remove('is-invalid'); }
            }

            if (!isFormValid) {
                modal.classList.add("show");
                showToast('⚠️ Gagal mengirim formulir. Lengkapi berkas dan kolom bertanda merah.');
                return;
            }

            form.submit();
        });

        closeModalBtn.addEventListener("click", () => modal.classList.remove("show"));
        document.addEventListener('keydown', e => { if ((e.ctrlKey || e.metaKey) && e.key === 's') { e.preventDefault(); saveDraft(document.getElementById('btnDraft'), null); } });
    </script>
</body>

</html>