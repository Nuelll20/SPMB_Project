<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAKTI Portal – Formulir Peserta Didik</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap"
        rel="stylesheet">
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

        /* ===================== TOPBAR / NAVBAR ===================== */
        .topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 0 32px;
            height: 64px;
            display: flex;
            align-items: center;
            gap: 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 16px rgba(26, 42, 108, 0.07);
        }

        /* Brand */
        .topbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-right: 40px;
        }

        .brand-logo {
            width: 40px;
            height: 40px;
            background: var(--navy);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }

        .brand-name {
            font-size: 15px;
            font-weight: 800;
            color: var(--navy);
            letter-spacing: 0.3px;
        }

        .brand-meta {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .brand-role {
            font-size: 10px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .brand-uid {
            font-family: 'DM Mono', monospace;
            font-size: 9px;
            color: var(--muted);
            letter-spacing: 0.3px;
        }

        /* Nav links */
        .topbar-nav {
            display: flex;
            align-items: center;
            gap: 4px;
            flex: 1;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border-radius: 99px;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--muted);
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
            background: none;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .nav-link:hover {
            background: #f0f4ff;
            color: var(--navy);
        }

        .nav-link.active {
            color: var(--navy);
            font-weight: 800;
            background: #f0f4ff;
            box-shadow: 0 2px 8px rgba(26, 42, 108, 0.15);
        }

        .nav-icon {
            font-size: 15px;
            opacity: 0.8;
        }

        .nav-dot {
            width: 8px;
            height: 8px;
            background: var(--gold);
            border-radius: 50%;
            flex-shrink: 0;
            order: -1;
        }

        /* Topbar right */
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .topbar-username {
            text-align: right;
            line-height: 1.2;
        }

        .topbar-uname {
            font-size: 14px;
            font-weight: 700;
            color: var(--text);
        }

        .topbar-urole {
            font-size: 10px;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .topbar-logout {
            width: 36px;
            height: 36px;
            background: rgba(220, 38, 38, 0.07);
            border: 1.5px solid rgba(220, 38, 38, 0.15);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .topbar-logout:hover {
            background: rgba(220, 38, 38, 0.12);
            border-color: rgba(220, 38, 38, 0.3);
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
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            opacity: 0;
            animation: fadeUp 0.5s ease 0.05s forwards;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(14px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        /* Buttons */
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
            letter-spacing: 0.2px;
            white-space: nowrap;
        }

        .btn .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: scale(0);
            animation: rippleAnim 0.55s linear;
            pointer-events: none;
        }

        @keyframes rippleAnim {
            to {
                transform: scale(4);
                opacity: 0;
            }
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

        .btn-gold {
            background: var(--gold);
            color: var(--navy);
            box-shadow: 0 4px 14px rgba(245, 196, 0, 0.35);
        }

        .btn-gold:hover {
            background: var(--gold-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(245, 196, 0, 0.4);
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

        /* Data Anak badge */
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

        /* 2-col grid */
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

        /* Section header */
        .col-header {
            display: flex;
            align-items: center;
            gap: 8px;
            padding-bottom: 12px;
            border-bottom: 1.5px solid var(--border);
        }

        .col-header-icon {
            font-size: 15px;
        }

        .col-header-title {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.4px;
            text-transform: uppercase;
            color: var(--muted);
        }

        /* Field */
        .field-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
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

        .field-input:focus {
            outline: none;
            border-color: var(--blue);
            background: #f5f8ff;
            box-shadow: 0 0 0 3px rgba(0, 74, 173, 0.09);
        }

        .field-input.is-valid {
            border-color: var(--green);
            background: #f0fdf4;
        }

        .field-input.is-invalid {
            border-color: var(--red);
            background: #fff5f5;
            animation: shake 0.35s ease;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
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

        .field-select:focus {
            outline: none;
            border-color: var(--blue);
            background-color: #f5f8ff;
            box-shadow: 0 0 0 3px rgba(0, 74, 173, 0.09);
        }

        .field-select.empty {
            color: #b0b7d0;
            font-weight: 400;
        }

        .field-input[type="date"] {
            color: var(--text);
        }

        .field-input[type="date"]:not([value]):not(:focus) {
            color: #b0b7d0;
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

        .field-textarea::placeholder {
            color: #b0b7d0;
            font-weight: 400;
        }

        .field-textarea:focus {
            outline: none;
            border-color: var(--blue);
            background: #f5f8ff;
            box-shadow: 0 0 0 3px rgba(0, 74, 173, 0.09);
        }

        /* Alamat header row */
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

        .samakan-btn:hover {
            background: rgba(0, 74, 173, 0.07);
        }

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

        .upload-item:hover {
            border-color: var(--blue);
            background: #f5f8ff;
        }

        .upload-item.uploaded {
            border-color: rgba(22, 163, 74, 0.35);
            background: #f6fff9;
        }

        .upload-left {
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 0;
        }

        .upload-doc-icon {
            color: var(--muted);
            font-size: 15px;
            flex-shrink: 0;
        }

        .upload-item.uploaded .upload-doc-icon {
            color: var(--green);
        }

        .upload-name {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .upload-wajib {
            font-size: 10px;
            font-weight: 700;
            color: var(--red);
            background: rgba(220, 38, 38, 0.08);
            border-radius: 4px;
            padding: 1px 5px;
            flex-shrink: 0;
        }

        .upload-actions {
            display: flex;
            align-items: center;
            gap: 4px;
            flex-shrink: 0;
        }

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

        .upload-file-input {
            display: none;
        }

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

        .back-link:hover {
            color: var(--blue);
        }

        .bottom-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

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
            position: relative;
            overflow: hidden;
        }

        .btn-draft:hover {
            border-color: var(--blue);
            color: var(--blue);
            background: rgba(0, 74, 173, 0.04);
        }

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

        .btn-submit .arrow {
            transition: transform 0.25s;
            font-size: 18px;
        }

        .btn-submit:hover .arrow {
            transform: translateX(5px);
        }

        /* ===================== FOOTER ===================== */
        .page-footer {
            text-align: center;
            padding: 20px;
            font-size: 11px;
            font-weight: 600;
            color: var(--muted);
            letter-spacing: 1.2px;
            text-transform: uppercase;
            opacity: 0;
            animation: fadeUp 0.5s ease 0.35s forwards;
        }

        /* ===================== TOAST ===================== */
        #toast {
            position: fixed;
            bottom: 28px;
            left: 50%;
            transform: translateX(-50%) translateY(70px);
            background: var(--navy);
            color: white;
            padding: 12px 26px;
            border-radius: 40px;
            font-size: 13.5px;
            font-weight: 600;
            opacity: 0;
            pointer-events: none;
            transition: transform 0.4s cubic-bezier(0.22, 1, 0.36, 1), opacity 0.4s;
            z-index: 9999;
            white-space: nowrap;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.18);
        }

        #toast.show {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        /* ===================== RESPONSIVE ===================== */
        @media (max-width: 900px) {
            .form-grid {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .page-body {
                padding: 24px 20px;
            }

            .topbar {
                padding: 0 20px;
            }

            .brand-uid {
                display: none;
            }
        }

        .topbar-nav {
            display: flex;
            align-items: center;
            gap: 4px;
            flex: 1;
            justify-content: center;
            /* ← pindah ke sini */
        }

        @media (max-width: 640px) {
            .topbar-nav {
                display: none;
            }

            .page-title {
                font-size: 21px;
            }

            .upload-grid {
                grid-template-columns: 1fr;
            }

            .field-row {
                grid-template-columns: 1fr;
            }

            .btn {
                font-size: 12.5px;
                padding: 9px 16px;
            }

            .bottom-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .bottom-actions {
                flex-direction: column;
            }

            .btn-draft,
            .btn-submit {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body>

    <!-- ===================== TOPBAR ===================== -->
    <header class="topbar">

        <div class="topbar-brand">
            <img src="{{ asset('img/E-Kanisius 1.png') }}" alt="E-Kanisius Logo"
                style="width:85px; height:auto; object-fit:contain; flex-shrink:0;"
                onerror="this.style.display='none'; document.getElementById('fallback-logo').style.display='flex';">

            <div id="fallback-logo" class="brand-logo" style="display:none;">⛵</div>

            <div class="brand-text">
                <div class="brand-name">PORTAL SAKTI</div>
                <div class="brand-meta">
                    <span class="brand-role">Parent</span>
                    <span class="brand-uid">UID-Jzp4Z3bwwoNY7IhFuiPNdTsN9w63</span>
                </div>
            </div>
        </div>

        <nav class="topbar-nav">
            <a class="nav-link active" href="#">
                <!-- <i class="fa-solid fa-table-cells-large nav-icon"></i> -->
                Dashboard <span class="nav-dot"></span>
            </a>
            <a class="nav-link" href="#" onclick="showToast('🕐 Membuka Riwayat...')">
                <!-- <i class="fa-solid fa-clock-rotate-left nav-icon"></i> Riwayat -->
                Riwayat
            </a>
            <a class="nav-link" href="#" onclick="showToast('💬 Membuka Pusat Bantuan...')">
                <!-- <i class="fa-solid fa-circle-info nav-icon"></i>  -->
                Pusat Bantuan
            </a>
        </nav>

        <div class="topbar-right">
            <div class="topbar-username">
                <div class="topbar-uname">Ignatius Arya</div>
                <div class="topbar-urole">Cabang Global</div>
            </div>

            <button class="topbar-logout" title="Keluar" onclick="showToast('🚪 Sedang keluar...')">
                <i class="fa-solid fa-arrow-right-from-bracket" style="color: #FF4D4D;"></i>
            </button>
        </div>
    </header>

    <!-- ===================== PAGE BODY ===================== -->
    <main class="page-body">

        <!-- PAGE HEADER -->
        <div class="page-header">
            <div>
                <h1 class="page-title">Formulir Peserta Didik</h1>
                <p class="page-subtitle">Unit Tujuan: <strong>• 1 Calon Murid</strong></p>
            </div>
            <div class="header-actions">
                <button class="btn btn-outline" id="btnTambahAnak" onclick="tambahAnak(this, event)">
                    ＋ TAMBAH ANAK
                </button>
                <!-- <button class="btn btn-gold" id="btnOCR" onclick="fillOCR(this, event)">
                    ✨ FILL WITH AI (OCR)
                </button> -->
            </div>
        </div>

        <!-- FORM CARD -->
        <div class="form-card">
            <div class="data-anak-badge" id="anakBadge">DATA ANAK 1</div>

            <div class="form-grid">

                <!-- ===== LEFT: IDENTITAS DASAR ===== -->
                <div class="form-col">
                    <div class="col-header">
                        <span class="col-header-icon">👤</span>
                        <span class="col-header-title">Identitas Dasar</span>
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="field-group">
                        <label class="field-label" for="namaLengkap">Nama Lengkap</label>
                        <input type="text" id="namaLengkap" name="nama_lengkap" class="field-input"
                            placeholder="Nama Lengkap" autocomplete="off"
                            oninput="validateField(this, v => v.trim().length >= 3)">
                    </div>

                    <!-- NIK -->
                    <div class="field-group">
                        <label class="field-label" for="nik">NIK (Nomor Induk Kependudukan)</label>
                        <input type="text" id="nik" name="nik" class="field-input" placeholder="16 Digit NIK"
                            maxlength="16" autocomplete="off"
                            oninput="onlyDigits(this); validateField(this, v => /^\d{16}$/.test(v))">
                    </div>

                    <!-- Tanggal Lahir + Gol Darah -->
                    <div class="field-row">
                        <div class="field-group">
                            <label class="field-label" for="tanggalLahir">Tanggal Lahir</label>
                            <input type="date" id="tanggalLahir" name="tanggal_lahir" class="field-input"
                                onchange="validateField(this, v => v !== '')">
                        </div>
                        <div class="field-group">
                            <label class="field-label" for="golDarah">Gol. Darah</label>
                            <select id="golDarah" name="gol_darah" class="field-select empty"
                                onchange="onSelectChange(this); validateField(this, v => v !== '')">
                                <option value="">O</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- ===== RIGHT: INFORMASI LANJUTAN ===== -->
                <div class="form-col">
                    <div class="col-header">
                        <span class="col-header-icon">📋</span>
                        <span class="col-header-title">Informasi Lanjutan</span>
                    </div>

                    <!-- Agama -->
                    <div class="field-group">
                        <label class="field-label" for="agama">Agama</label>
                        <select id="agama" name="agama" class="field-select"
                            onchange="onSelectChange(this); validateField(this, v => v !== ''); toggleSuratBaptis(this.value)">
                            <option value="" selected>Katolik</option>
                            <option value="kristen">Kristen</option>
                            <option value="katolik">Katolik</option>
                            <option value="islam">Islam</option>
                            <option value="buddha">Buddha</option>
                            <option value="hindu">Hindu</option>
                            <option value="konghucu">Konghucu</option>
                        </select>
                    </div>

                    <!-- Alamat -->
                    <div class="field-group">
                        <div class="alamat-header">
                            <label class="field-label" for="alamat">Alamat Domisili Anak</label>
                            <button type="button" class="samakan-btn" onclick="samakanAlamat()">
                                Samakan dengan Alamat Ortu
                            </button>
                        </div>
                        <textarea id="alamat" name="alamat" class="field-textarea"
                            placeholder="Masukkan alamat lengkap tempat tinggal anak..."></textarea>
                    </div>

                    <!-- Upload Berkas -->
                    <div class="field-group">
                        <span class="upload-label">Upload Berkas Fisik</span>
                        <div class="upload-grid">

                            <!-- Kartu Keluarga -->
                            <div class="upload-item" id="item-kk" onclick="triggerUpload('file-kk')">
                                <div class="upload-left">
                                    <span class="upload-doc-icon">📄</span>
                                    <span class="upload-name">Kartu Keluarga</span>
                                </div>
                                <div class="upload-actions">
                                    <button type="button" class="upload-action-btn" title="Preview"
                                        onclick="previewDoc(event,'Kartu Keluarga')">👁</button>
                                    <button type="button" class="upload-action-btn" title="Upload"
                                        onclick="triggerUpload('file-kk', event)">↑</button>
                                </div>
                                <input type="file" id="file-kk" class="upload-file-input" accept="image/*,.pdf"
                                    onchange="onUpload(this,'item-kk')">
                            </div>

                            <!-- Akte Kelahiran -->
                            <div class="upload-item" id="item-akte" onclick="triggerUpload('file-akte')">
                                <div class="upload-left">
                                    <span class="upload-doc-icon">📄</span>
                                    <span class="upload-name">Akte Kelahiran</span>
                                </div>
                                <div class="upload-actions">
                                    <button type="button" class="upload-action-btn" title="Preview"
                                        onclick="previewDoc(event,'Akte Kelahiran')">👁</button>
                                    <button type="button" class="upload-action-btn" title="Upload"
                                        onclick="triggerUpload('file-akte', event)">↑</button>
                                </div>
                                <input type="file" id="file-akte" class="upload-file-input" accept="image/*,.pdf"
                                    onchange="onUpload(this,'item-akte')">
                            </div>

                            <!-- E-KTP Orang Tua -->
                            <div class="upload-item" id="item-ktp" onclick="triggerUpload('file-ktp')">
                                <div class="upload-left">
                                    <span class="upload-doc-icon">📄</span>
                                    <span class="upload-name">E-KTP Orang Tua</span>
                                </div>
                                <div class="upload-actions">
                                    <button type="button" class="upload-action-btn" title="Preview"
                                        onclick="previewDoc(event,'E-KTP Orang Tua')">👁</button>
                                    <button type="button" class="upload-action-btn" title="Upload"
                                        onclick="triggerUpload('file-ktp', event)">↑</button>
                                </div>
                                <input type="file" id="file-ktp" class="upload-file-input" accept="image/*,.pdf"
                                    onchange="onUpload(this,'item-ktp')">
                            </div>

                            <!-- Pas Foto -->
                            <div class="upload-item" id="item-foto" onclick="triggerUpload('file-foto')">
                                <div class="upload-left">
                                    <span class="upload-doc-icon">📄</span>
                                    <span class="upload-name">Pas Foto (3x4)</span>
                                </div>
                                <div class="upload-actions">
                                    <button type="button" class="upload-action-btn" title="Preview"
                                        onclick="previewDoc(event,'Pas Foto 3x4')">👁</button>
                                    <button type="button" class="upload-action-btn" title="Upload"
                                        onclick="triggerUpload('file-foto', event)">↑</button>
                                </div>
                                <input type="file" id="file-foto" class="upload-file-input" accept="image/*"
                                    onchange="onUpload(this,'item-foto')">
                            </div>

                            <!-- Surat Baptis (Wajib) — hanya muncul jika agama Katolik -->
                            <div class="upload-item" id="item-baptis"
                                style="grid-column: span 2; display: none; transition: all 0.3s ease;"
                                onclick="triggerUpload('file-baptis')">
                                <div class="upload-left">
                                    <span class="upload-doc-icon">📄</span>
                                    <span class="upload-name">Surat Baptis</span>
                                    <span class="upload-wajib">Wajib</span>
                                </div>
                                <div class="upload-actions">
                                    <button type="button" class="upload-action-btn" title="Preview"
                                        onclick="previewDoc(event,'Surat Baptis')">👁</button>
                                    <button type="button" class="upload-action-btn" title="Upload"
                                        onclick="triggerUpload('file-baptis', event)">↑</button>
                                </div>
                                <input type="file" id="file-baptis" class="upload-file-input" accept="image/*,.pdf"
                                    onchange="onUpload(this,'item-baptis')">
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- BOTTOM BAR -->
        <div class="bottom-bar">
            <a href="#" class="back-link" onclick="showToast('↩ Kembali ke Profil Ortu'); return false;">
                ← Kembali ke Profil Ortu
            </a>
            <div class="bottom-actions">
                <button class="btn-draft" id="btnDraft" onclick="saveDraft(this, event)">
                    💾 SIMPAN DRAFT
                </button>
                <button class="btn-submit" id="btnSubmit" onclick="submitForm(this, event)">
                    SUBMIT SEKARANG <span class="arrow">›</span>
                </button>
            </div>
        </div>

    </main>

    <!-- FOOTER -->
    <footer class="page-footer">
        Yayasan Kanisius © 2026 – Admisi Terintegrasi
    </footer>

    <!-- Toast -->
    <div id="toast"></div>

    <script>
        /* ============================================================
           TOAST
        ============================================================ */
        function showToast(msg, dur = 3000) {
            const t = document.getElementById('toast');
            t.textContent = msg;
            t.classList.add('show');
            clearTimeout(t._timer);
            t._timer = setTimeout(() => t.classList.remove('show'), dur);
        }

        /* ============================================================
           RIPPLE
        ============================================================ */
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
           FIELD VALIDATION
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

        function onlyDigits(el) {
            el.value = el.value.replace(/\D/g, '').slice(0, 16);
        }

        function onSelectChange(el) {
            el.classList.remove('empty');
        }

        /* ============================================================
           TOGGLE SURAT BAPTIS — hanya tampil jika agama = Katolik
        ============================================================ */
        function toggleSuratBaptis(val) {
            const item = document.getElementById('item-baptis');
            if (val === 'katolik') {
                item.style.display = 'flex';
                // Animasi muncul
                item.style.opacity = '0';
                item.style.transform = 'translateY(-6px)';
                requestAnimationFrame(() => {
                    item.style.transition = 'opacity 0.35s ease, transform 0.35s ease';
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                });
                showToast('⛪ Surat Baptis wajib dilampirkan untuk agama Katolik');
            } else {
                // Animasi hilang
                item.style.transition = 'opacity 0.25s ease, transform 0.25s ease';
                item.style.opacity = '0';
                item.style.transform = 'translateY(-6px)';
                setTimeout(() => {
                    item.style.display = 'none';
                    // Reset file jika sudah diupload
                    const fileInput = document.getElementById('file-baptis');
                    if (fileInput) fileInput.value = '';
                    item.classList.remove('uploaded');
                    item.querySelector('.upload-doc-icon').textContent = '📄';
                }, 260);
            }
        }

        /* ============================================================
           NAV ACTIVE
        ============================================================ */
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function () {
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                document.querySelectorAll('.nav-dot').forEach(d => d.remove());
                this.classList.add('active');
                const dot = document.createElement('span');
                dot.className = 'nav-dot';
                this.appendChild(dot);
            });
        });

        /* ============================================================
           SAMAKAN ALAMAT
        ============================================================ */
        function samakanAlamat() {
            const ta = document.getElementById('alamat');
            ta.style.transition = 'background 0.3s, border-color 0.3s';
            ta.style.background = '#fffbe6';
            ta.style.borderColor = 'var(--gold)';
            // Di produksi: ambil dari data ortu yang sudah tersimpan
            ta.value = 'Jl. Purbayan No. 1, Surakarta';
            setTimeout(() => {
                ta.style.background = '';
                ta.style.borderColor = '';
            }, 700);
            showToast('✅ Alamat disalin dari data orang tua');
        }

        /* ============================================================
           TAMBAH ANAK
        ============================================================ */
        let anakCount = 1;

        function tambahAnak(btn, e) {
            addRipple(btn, e);
            anakCount++;
            document.getElementById('anakBadge').textContent = `DATA ANAK ${anakCount}`;
            document.querySelector('.page-subtitle strong').textContent = `• ${anakCount} Calon Murid`;
            // Reset form fields
            ['namaLengkap', 'nik', 'tanggalLahir', 'alamat'].forEach(id => {
                const el = document.getElementById(id);
                if (el) { el.value = ''; el.classList.remove('is-valid', 'is-invalid'); }
            });
            document.getElementById('golDarah').value = '';
            document.getElementById('agama').value = '';
            // Sembunyikan surat baptis saat reset
            toggleSuratBaptis('');
            // Reset uploads
            ['item-kk', 'item-akte', 'item-ktp', 'item-foto', 'item-baptis'].forEach(id => {
                const item = document.getElementById(id);
                item.classList.remove('uploaded');
                item.querySelector('.upload-doc-icon').textContent = '📄';
            });
            showToast(`➕ Data Anak ${anakCount} siap diisi`);

            // Animate card
            const card = document.querySelector('.form-card');
            card.style.transition = 'opacity 0.2s, transform 0.2s';
            card.style.opacity = '0';
            card.style.transform = 'translateY(8px)';
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 220);
        }

        /* ============================================================
           FILL WITH AI / OCR
        ============================================================ */
        function fillOCR(btn, e) {
            addRipple(btn, e);
            btn.disabled = true;
            btn.textContent = '⏳ Memproses...';
            showToast('🤖 AI sedang membaca dokumen...');

            // Simulasi AI mengisi satu per satu
            const fills = [
                { id: 'namaLengkap', val: 'Benedictus Kanisius' },
                { id: 'nik', val: '3374012305180001' },
                { id: 'tanggalLahir', val: '2018-05-12' },
                { id: 'alamat', val: 'Jl. Purbayan No. 1, Surakarta' },
            ];

            fills.forEach((f, i) => {
                setTimeout(() => {
                    const el = document.getElementById(f.id);
                    el.style.transition = 'background 0.3s, border-color 0.3s';
                    el.style.background = '#fffbe6';
                    el.style.borderColor = 'var(--gold-dark)';
                    el.value = f.val;
                    setTimeout(() => {
                        el.style.background = '';
                        el.style.borderColor = '';
                        el.classList.add('is-valid');
                    }, 500);
                }, i * 350);
            });

            setTimeout(() => {
                btn.disabled = false;
                btn.innerHTML = '✨ FILL WITH AI (OCR)';
                showToast('✅ Data berhasil diisi oleh AI OCR!', 3500);
            }, fills.length * 350 + 700);
        }

        /* ============================================================
           UPLOAD FILE
        ============================================================ */
        function triggerUpload(inputId, e) {
            if (e) e.stopPropagation();
            document.getElementById(inputId).click();
        }

        function onUpload(input, itemId) {
            if (!input.files || !input.files[0]) return;
            const item = document.getElementById(itemId);
            const name = input.files[0].name;
            item.classList.add('uploaded');
            item.querySelector('.upload-doc-icon').textContent = '✅';
            showToast(`📎 "${name.slice(0, 24)}${name.length > 24 ? '…' : ''}" berhasil diupload`);
        }

        function previewDoc(e, name) {
            e.stopPropagation();
            showToast(`👁 Membuka preview: ${name}`);
        }

        /* ============================================================
           SAVE DRAFT
        ============================================================ */
        function saveDraft(btn, e) {
            addRipple(btn, e);
            btn.disabled = true;
            btn.textContent = '⏳ Menyimpan...';

            setTimeout(() => {
                btn.innerHTML = '✅ Draft Tersimpan';
                showToast('💾 Draft berhasil disimpan!');
                setTimeout(() => {
                    btn.innerHTML = '💾 SIMPAN DRAFT';
                    btn.disabled = false;
                }, 2200);
            }, 1200);
        }

        /* ============================================================
           SUBMIT FORM
        ============================================================ */
        function submitForm(btn, e) {
            addRipple(btn, e);
            const required = [
                { id: 'namaLengkap', rule: v => v.trim().length >= 3 },
                { id: 'nik', rule: v => /^\d{16}$/.test(v) },
                { id: 'tanggalLahir', rule: v => v !== '' },
            ];
            let hasErr = false;

            required.forEach(({ id, rule }) => {
                const el = document.getElementById(id);
                if (!rule(el.value)) {
                    el.classList.add('is-invalid');
                    el.style.animation = 'none';
                    requestAnimationFrame(() => el.style.animation = '');
                    hasErr = true;
                }
            });

            if (hasErr) {
                showToast('⚠️ Lengkapi semua field yang wajib diisi.');
                return;
            }

            btn.innerHTML = '⏳ Memproses... <span class="arrow">›</span>';
            btn.disabled = true;

            setTimeout(() => {
                btn.innerHTML = '✅ Berhasil Disubmit <span class="arrow">›</span>';
                showToast('🎉 Formulir berhasil disubmit! Menunggu verifikasi.', 4500);
            }, 1800);
        }

        /* ============================================================
           Ctrl+S → Save Draft
        ============================================================ */
        document.addEventListener('keydown', e => {
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                const btn = document.getElementById('btnDraft');
                saveDraft(btn, null);
            }
        });
    </script>

</body>

</html>