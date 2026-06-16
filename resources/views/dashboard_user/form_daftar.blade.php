<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAKTI Portal – Formulir Peserta Didik</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=DM+Mono:wght@400;500&display=swap"
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
            padding-top: 16px;
            /* Jarak dari paling atas layar dikurangi agar lebih presisi */
            animation: fadeIn 0.6s ease forwards;
        }

        .topbar {
            background: var(--surface);
            border-radius: 16px;
            /* DIUBAH LANGSUNG KE ANGKA: Biar langsung rounded sempurna tanpa variabel gaib */
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 20px rgba(0, 43, 91, 0.04);
            border: 1px solid var(--border);
            /* Ditambahkan border tipis agar senada dengan main-card */
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

        .nav-link:hover,
        .nav-link.active {
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

        /* ===================== HAPUS DATA ANAK BUTTON ===================== */
        .anak-form-card {
            margin-bottom: 24px;
            position: relative;
        }

        .btn-delete-anak {
            position: absolute;
            top: 18px;
            left: 28px;
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 8px 14px;
            font-size: 11px;
            font-weight: 800;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            letter-spacing: 0.4px;
            text-transform: uppercase;
            transition: all 0.2s ease;
            z-index: 5;
        }

        .btn-delete-anak:hover {
            background: #fecaca;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.15);
        }

        .btn-delete-anak:active {
            transform: translateY(0);
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

        .btn-preview-disabled {
            opacity: 0.3;
            cursor: not-allowed;
            pointer-events: none;
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

        .modal-overlay.show .modal-box {
            transform: scale(1);
        }

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

        .modal-title {
            font-size: 18px;
            font-weight: 800;
            color: var(--navy);
            margin-bottom: 8px;
        }

        .modal-desc {
            font-size: 14px;
            color: var(--muted);
            line-height: 1.5;
            margin-bottom: 24px;
        }

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

        .preview-viewport-content img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .preview-viewport-content iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

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

        .page-footer {
            text-align: center;
            padding: 20px;
            font-size: 11px;
            font-weight: 600;
            color: var(--muted);
            letter-spacing: 1.2px;
            text-transform: uppercase;
        }

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

        #toast.show {
            opacity: 1;
            transform: translateX(0);
        }

        /* ===================== PERBAIKAN: MASTER GRID RESPONSIVE UI ===================== */
        @media (max-width: 900px) {
            .form-grid {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .page-body {
                padding: 24px 16px;
            }

            .form-card {
                padding: 24px;
            }
        }

        @media (max-width: 768px) {
            .topbar {
                padding: 12px 20px;
            }

            .topbar-nav {
                gap: 16px;
            }

            .page-title {
                font-size: 22px;
            }
        }

        @media (max-width: 640px) {
            .topbar {
                flex-direction: column;
                gap: 14px;
                padding: 16px;
                text-align: center;
            }

            .topbar-brand {
                flex-direction: column;
                gap: 4px;
            }

            .topbar-nav {
                width: 100%;
                justify-content: center;
                gap: 16px;
                border-top: 1px solid var(--border);
                border-bottom: 1px solid var(--border);
                padding: 8px 0;
            }

            .topbar-right {
                width: 100%;
                justify-content: space-between;
            }

            .user-info {
                text-align: left;
            }

            .page-header {
                flex-direction: column;
                align-items: stretch;
                text-align: center;
            }

            .btn-outline {
                width: 100%;
                justify-content: center;
            }

            .field-row {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .upload-grid {
                grid-template-columns: 1fr;
            }

            .upload-item[data-field="surat_baptis"] {
                grid-column: span 1 !important;
            }

            .bottom-bar {
                flex-direction: column;
                align-items: stretch;
                gap: 20px;
            }

            .bottom-actions {
                flex-direction: column;
                width: 100%;
            }

            .btn-draft,
            .btn-submit {
                width: 100%;
                justify-content: center;
            }

            #toast {
                left: 20px;
                right: 20px;
                bottom: 20px;
                transform: translateY(30px);
                text-align: center;
                justify-content: center;
            }

            #toast.show {
                transform: translateY(0);
            }
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
                        <div class="user-name">{{ auth()->user()->name ?? 'Orang Tua' }}</div>
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

    <form id="formPesertaDidik" action="{{ route('form.daftar.store') }}" method="POST" enctype="multipart/form-data"
        class="page-body" novalidate>
        @csrf
        @if ($errors->any())
            <div style="background:#fee2e2;color:#991b1b;padding:12px 16px;border-radius:10px;margin-bottom:16px;">
                <strong>Form gagal dikirim:</strong>
                <ul style="margin-top:8px;padding-left:18px;">
                    @foreach ($errors->getMessages() as $field => $messages)
                        @foreach ($messages as $message)
                            <li><strong>{{ $field }}</strong>: {{ $message }}</li>
                        @endforeach
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div style="background:#dcfce7;color:#166534;padding:12px 16px;border-radius:10px;margin-bottom:16px;">
                {{ session('success') }}
            </div>
        @endif

        @if (session('warning'))
            <div style="background:#fef3c7;color:#92400e;padding:12px 16px;border-radius:10px;margin-bottom:16px;">
                {{ session('warning') }}
            </div>
        @endif
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

        <div id="anakFormsContainer">
            <div class="form-card anak-form-card" data-anak-index="0">
                <div class="data-anak-badge">DATA ANAK 1</div>

                <button type="button" class="btn-delete-anak" onclick="hapusAnak(this)" style="display:none;">
                    HAPUS DATA ANAK
                </button>

                <div class="form-grid">
                    <div class="form-col">
                        <div class="col-header">
                            <span class="col-header-title">Identitas Dasar</span>
                        </div>

                        <div class="field-group required">
                            <label class="field-label" for="namaLengkap">Nama Lengkap</label>
                            <input type="text" id="namaLengkap" name="nama_lengkap" class="field-input"
                                placeholder="Nama Lengkap" value="{{ old('nama_lengkap', $draft->nama ?? '') }}"
                                autocomplete="off" oninput="validateField(this, v => v.trim().length >= 3)">
                        </div>

                        <div class="field-group required">
                            <label class="field-label" for="nik">NIK (Nomor Induk Kependudukan)</label>
                            <input type="text" id="nik" name="nik" class="field-input" placeholder="16 Digit NIK"
                                maxlength="16" value="{{ old('nik', $draft->nik ?? '') }}" autocomplete="off"
                                oninput="onlyDigits(this); validateField(this, v => /^\d{16}$/.test(v))">
                        </div>

                        <div class="field-row required">
                            <div class="field-group">
                                <label class="field-label" for="tanggalLahir">Tanggal Lahir</label>
                                <input type="date" id="tanggalLahir" name="tanggal_lahir" class="field-input"
                                    value="{{ old('tanggal_lahir', $draft->tanggal_lahir ?? '') }}"
                                    onchange="validateField(this, v => v !== '')">
                            </div>
                            <div class="field-group">
                                <label class="field-label" for="golDarah">Gol. Darah</label>
                                <select id="golDarah" name="gol_darah" class="field-select"
                                    onchange="onSelectChange(this)">
                                    @php($golDarahValue = old('gol_darah', $draft->golongan_darah ?? 'O'))
                                    <option value="O" {{ $golDarahValue == 'O' ? 'selected' : '' }}>O</option>
                                    <option value="A" {{ $golDarahValue == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ $golDarahValue == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="AB" {{ $golDarahValue == 'AB' ? 'selected' : '' }}>AB</option>
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
                            <select id="agama" name="agama" class="field-select"
                                onchange="onSelectChange(this); toggleSuratBaptisDynamic(this)">
                                @php($agamaValue = old('agama', $draft->agama ?? ''))
                                <option value="" {{ $agamaValue == '' ? 'selected' : '' }} disabled>Pilih Agama</option>
                                <option value="kristen" {{ $agamaValue == 'kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="katolik" {{ $agamaValue == 'katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="islam" {{ $agamaValue == 'islam' ? 'selected' : '' }}>Islam</option>
                                <option value="buddha" {{ $agamaValue == 'buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="hindu" {{ $agamaValue == 'hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="konghucu" {{ $agamaValue == 'konghucu' ? 'selected' : '' }}>Konghucu
                                </option>
                            </select>
                        </div>

                        <div class="field-group required">
                            <div class="alamat-header">
                                <label class="field-label" for="alamat">Alamat Domisili Anak</label>
                                <button type="button" class="samakan-btn" onclick="samakanAlamat(this)">
                                    Samakan dengan Alamat Ortu
                                </button>
                            </div>
                            <textarea id="alamat" name="alamat" class="field-textarea"
                                placeholder="Masukkan alamat lengkap tempat tinggal anak..."
                                oninput="validateField(this, v => v.trim().length >= 5)">{{ old('alamat', $draft->alamat ?? '') }}</textarea>
                        </div>

                        <div class="field-group required">
                            <label class="field-label" for="tempat-lahir">Tempat Lahir Anak</label>
                            <input type="text" id="tempat-lahir" name="tempat_lahir" class="field-input"
                                placeholder="Masukkan kota tempat lahir anak..."
                                value="{{ old('tempat_lahir', $draft->tempat_lahir ?? '') }}"
                                oninput="validateField(this, v => v.trim().length >= 3)">
                        </div>

                        <div class="field-group">
                            <span class="upload-label">Upload Berkas Fisik</span>
                            <div class="upload-grid">
                                <div class="upload-item required" data-field="kartu_keluarga"
                                    onclick="triggerUploadFromItem(this)">
                                    <div class="upload-left">
                                        <span class="upload-name">Kartu Keluarga</span>
                                    </div>
                                    <div class="upload-actions">
                                        <button type="button" class="upload-action-btn btn-preview-disabled"
                                            title="Preview"
                                            onclick="previewDocDynamic(event, this, 'Kartu Keluarga')">👁</button>
                                        <button type="button" class="upload-action-btn" title="Upload"
                                            onclick="triggerUploadFromButton(this, event)">↑</button>
                                    </div>
                                    <input type="file" name="kartu_keluarga" class="upload-file-input"
                                        accept=".jpg,.jpeg,.png,.pdf" onchange="onUploadDynamic(this)">
                                </div>

                                <div class="upload-item required" data-field="akte_kelahiran"
                                    onclick="triggerUploadFromItem(this)">
                                    <div class="upload-left">
                                        <span class="upload-name">Akte Kelahiran</span>
                                    </div>
                                    <div class="upload-actions">
                                        <button type="button" class="upload-action-btn btn-preview-disabled"
                                            title="Preview"
                                            onclick="previewDocDynamic(event, this, 'Akte Kelahiran')">👁</button>
                                        <button type="button" class="upload-action-btn" title="Upload"
                                            onclick="triggerUploadFromButton(this, event)">↑</button>
                                    </div>
                                    <input type="file" name="akte_kelahiran" class="upload-file-input"
                                        accept=".jpg,.jpeg,.png,.pdf" onchange="onUploadDynamic(this)">
                                </div>

                                <div class="upload-item required" data-field="ktp_ortu"
                                    onclick="triggerUploadFromItem(this)">
                                    <div class="upload-left">
                                        <span class="upload-name">E-KTP Orang Tua</span>
                                    </div>
                                    <div class="upload-actions">
                                        <button type="button" class="upload-action-btn btn-preview-disabled"
                                            title="Preview"
                                            onclick="previewDocDynamic(event, this, 'E-KTP Orang Tua')">👁</button>
                                        <button type="button" class="upload-action-btn" title="Upload"
                                            onclick="triggerUploadFromButton(this, event)">↑</button>
                                    </div>
                                    <input type="file" name="ktp_ortu" class="upload-file-input"
                                        accept=".jpg,.jpeg,.png,.pdf" onchange="onUploadDynamic(this)">
                                </div>

                                <div class="upload-item required" data-field="pas_foto"
                                    onclick="triggerUploadFromItem(this)">
                                    <div class="upload-left">
                                        <span class="upload-name">Pas Foto (3x4)</span>
                                    </div>
                                    <div class="upload-actions">
                                        <button type="button" class="upload-action-btn btn-preview-disabled"
                                            title="Preview"
                                            onclick="previewDocDynamic(event, this, 'Pas Foto 3x4')">👁</button>
                                        <button type="button" class="upload-action-btn" title="Upload"
                                            onclick="triggerUploadFromButton(this, event)">↑</button>
                                    </div>
                                    <input type="file" name="pas_foto" class="upload-file-input"
                                        accept=".jpg,.jpeg,.png" onchange="onUploadDynamic(this)">
                                </div>

                                <div class="upload-item" data-field="surat_baptis"
                                    style="grid-column: span 2; display: none;" onclick="triggerUploadFromItem(this)">
                                    <div class="upload-left">
                                        <span class="upload-doc-icon">📄</span>
                                        <span class="upload-name">Surat Baptis</span>
                                        <span class="upload-wajib">Wajib</span>
                                    </div>
                                    <div class="upload-actions">
                                        <button type="button" class="upload-action-btn btn-preview-disabled"
                                            title="Preview"
                                            onclick="previewDocDynamic(event, this, 'Surat Baptis')">👁</button>
                                        <button type="button" class="upload-action-btn" title="Upload"
                                            onclick="triggerUploadFromButton(this, event)">↑</button>
                                    </div>
                                    <input type="file" name="surat_baptis" class="upload-file-input"
                                        accept=".jpg,.jpeg,.png,.pdf" onchange="onUploadDynamic(this)">
                                </div>
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

    <div id="errorModal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-icon"><i class="fa-solid fa-circle-exclamation"></i></div>
            <h3 class="modal-title">Data Belum Lengkap</h3>
            <p class="modal-desc">Mohon periksa kembali. Seluruh bidang data bertanda bintang (*) dan berkas wajib harus
                diisi sebelum melanjutkan.</p>
            <button type="button" id="closeModalBtn" class="modal-btn-close">Mengerti</button>
        </div>
    </div>

    <div id="previewModal" class="modal-overlay">
        <div class="modal-box modal-box-large">
            <h3 class="modal-title" id="previewModalTitle" style="margin-bottom: 12px; text-align: left;">Pratinjau
                Berkas</h3>
            <div class="preview-viewport-content" id="previewViewport"></div>
            <button type="button" id="closePreviewModalBtn" class="modal-btn-close">Tutup Pratinjau</button>
        </div>
    </div>

    <div id="confirmLeaveModal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-icon modal-icon-warn"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <h3 class="modal-title">Tinggalkan Halaman?</h3>
            <p class="modal-desc">Data pendaftaran calon murid belum disimpan ke sistem. Apakah Anda yakin ingin keluar
                dan membuang perubahan?</p>
            <div class="modal-btn-group">
                <button type="button" id="btnCancelLeave" class="modal-btn-close modal-btn-cancel">Batal</button>
                <button type="button" id="btnConfirmLeave" class="modal-btn-close" style="background: var(--red);">Ya,
                    Keluar</button>
            </div>
        </div>
    </div>

    <!-- ADD MODAL: Struktur Pop-Up Khusus Konfirmasi Logout -->
    <div id="logoutModal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-icon" style="background: #fff5f5; color: var(--red);"><i
                    class="fa-solid fa-arrow-right-from-bracket"></i></div>
            <h3 class="modal-title">Mengakhiri Sesi?</h3>
            <p class="modal-desc">Apakah Anda yakin ingin keluar dari SAKTI Portal?</p>
            <div class="modal-btn-group">
                <button type="button" onclick="closeLogoutModal()"
                    class="modal-btn-close modal-btn-cancel">Batal</button>
                <button type="button" onclick="handleLogout()" class="modal-btn-close"
                    style="background: var(--navy);">Ya, Keluar</button>
            </div>
        </div>
    </div>

    <div id="toast"></div>

    <script>
        /* ============================================================
            TOAST UTILITIES
        ============================================================ */
        function showToast(msg, dur = 3000) {
            const t = document.getElementById('toast');
            if (!t) return;
            t.innerHTML = msg;
            t.classList.add('show');
            clearTimeout(t._timer);
            t._timer = setTimeout(() => t.classList.remove('show'), dur);
        }

        function addRipple(btn, e) {
            if (!btn || !e) return;
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
            if (!el) return;

            if (el.value === '' || el.value === null) {
                el.classList.remove('is-valid', 'is-invalid');
                return;
            }

            const ok = rule(el.value);
            el.classList.toggle('is-valid', ok);
            el.classList.toggle('is-invalid', !ok);
        }

        function onlyDigits(el) {
            if (!el) return;
            el.value = el.value.replace(/\D/g, '').slice(0, 16);
        }

        function onSelectChange(el) {
            if (!el) return;
            el.classList.remove('is-invalid');
            el.classList.add('is-valid');
        }

        function getField(card, fieldName) {
            if (!card) return null;
            return card.querySelector(`[name="${fieldName}"], [name$="[${fieldName}]"]`);
        }

        function getUploadItem(card, fieldName) {
            if (!card) return null;
            return card.querySelector(`.upload-item[data-field="${fieldName}"]`);
        }

        /* ============================================================
            TOGGLE SURAT BAPTIS PER FORM ANAK
        ============================================================ */
        function toggleSuratBaptisDynamic(select) {
            const card = select.closest('.anak-form-card');
            const item = getUploadItem(card, 'surat_baptis');

            if (!item) return;

            if (select.value === 'katolik') {
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
                item.style.transition = 'opacity 0.25s ease, transform 0.25s ease';
                item.style.opacity = '0';
                item.style.transform = 'translateY(-6px)';

                setTimeout(() => {
                    item.style.display = 'none';
                    item.classList.remove('uploaded', 'is-invalid');

                    const fileInput = item.querySelector('input[type="file"]');
                    if (fileInput) fileInput.value = '';

                    const previewBtn = item.querySelector('.upload-action-btn[title="Preview"]');
                    if (previewBtn) previewBtn.classList.add('btn-preview-disabled');
                }, 260);
            }
        }

        /* ============================================================
            SAMAKAN ALAMAT
        ============================================================ */
        function samakanAlamat(button) {
            const alamatOrtu = @json($orangTua->alamat ?? '');

            if (!alamatOrtu) {
                showToast('⚠️ Alamat orang tua belum tersedia. Lengkapi profil orang tua terlebih dahulu.');
                return;
            }

            const card = button.closest('.anak-form-card');
            const textareaAlamat = getField(card, 'alamat');

            if (!textareaAlamat) {
                showToast('❌ Kolom alamat anak tidak ditemukan.');
                return;
            }

            textareaAlamat.value = alamatOrtu;
            textareaAlamat.classList.remove('is-invalid');
            textareaAlamat.classList.add('is-valid');

            showToast('🏠 Alamat berhasil disamakan dengan alamat orang tua.');
        }

        /* ============================================================
            UPLOAD & PREVIEW BERKAS DINAMIS
        ============================================================ */
        const previewModal = document.getElementById('previewModal');
        const previewViewport = document.getElementById('previewViewport');
        const previewModalTitle = document.getElementById('previewModalTitle');

        function triggerUploadFromItem(item) {
            const input = item.querySelector('input[type="file"]');
            if (input) input.click();
        }

        function triggerUploadFromButton(button, event) {
            if (event) event.stopPropagation();

            const item = button.closest('.upload-item');
            const input = item ? item.querySelector('input[type="file"]') : null;

            if (input) input.click();
        }

        function onUploadDynamic(input) {
            const item = input.closest('.upload-item');

            if (!item || !input.files || !input.files[0]) return;

            const file = input.files[0];
            const previewBtn = item.querySelector('.upload-action-btn[title="Preview"]');

            item.classList.add('uploaded');
            item.classList.remove('is-invalid');

            if (previewBtn) previewBtn.classList.remove('btn-preview-disabled');

            showToast(`📎 Berkas "${file.name.slice(0, 18)}..." berhasil dipilih`);
        }

        function previewDocDynamic(event, button, labelName) {
            if (event) event.stopPropagation();

            const item = button.closest('.upload-item');
            const fileInput = item ? item.querySelector('input[type="file"]') : null;

            if (!fileInput || !fileInput.files || !fileInput.files[0]) {
                showToast('⚠️ Pilih berkas terlebih dahulu.');
                return;
            }

            const file = fileInput.files[0];
            const fileType = file.type;

            previewModalTitle.textContent = `Pratinjau Berkas: ${labelName}`;
            previewViewport.innerHTML = '';

            if (fileType === 'application/pdf') {
                const blobURL = URL.createObjectURL(file);
                const iframe = document.createElement('iframe');
                iframe.src = blobURL;
                previewViewport.appendChild(iframe);
            } else if (fileType.startsWith('image/')) {
                const reader = new FileReader();

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

        const closePreviewModalBtn = document.getElementById('closePreviewModalBtn');
        if (closePreviewModalBtn) {
            closePreviewModalBtn.addEventListener('click', () => {
                previewModal.classList.remove('show');
                previewViewport.innerHTML = '';
            });
        }

        function prepareUploadFields(card, index) {
            card.querySelectorAll('.upload-item').forEach(item => {
                const field = item.dataset.field;
                const input = item.querySelector('input[type="file"]');
                const previewBtn = item.querySelector('.upload-action-btn[title="Preview"]');

                item.classList.remove('uploaded', 'is-invalid');

                if (input && field) {
                    input.value = '';
                    input.name = index === 0 ? field : `anak[${index}][${field}]`;
                }

                if (previewBtn) previewBtn.classList.add('btn-preview-disabled');
            });
        }

        /* ============================================================
            SIMPAN DRAFT - HANYA DATA ANAK PERTAMA
        ============================================================ */
        function saveDraft(btn, e) {
            if (e) addRipple(btn, e);

            const form = document.getElementById('formPesertaDidik');
            const firstCard = document.querySelector('.anak-form-card');

            const namaField = getField(firstCard, 'nama_lengkap');
            const nikField = getField(firstCard, 'nik');
            const tanggalField = getField(firstCard, 'tanggal_lahir');
            const agamaField = getField(firstCard, 'agama');
            const alamatField = getField(firstCard, 'alamat');
            const tempatField = getField(firstCard, 'tempat_lahir');

            if (!namaField || namaField.value.trim().length < 3) {
                showToast('⚠️ Gagal menyimpan draf: Nama Lengkap wajib diisi minimal 3 karakter.');
                if (namaField) namaField.classList.add('is-invalid');
                return;
            }

            if (!nikField || !/^\d{16}$/.test(nikField.value) || !tanggalField.value || !agamaField.value || alamatField.value.trim().length < 5 || tempatField.value.trim().length < 3) {
                showToast('⚠️ Draft butuh data identitas dasar lengkap, tetapi berkas belum wajib.');
                return;
            }

            btn.disabled = true;
            btn.textContent = 'Menyimpan...';

            fetch("{{ route('form.daftar.draft') }}", {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: new FormData(form)
            })
                .then(async response => {
                    const data = await response.json().catch(() => ({}));

                    if (!response.ok || !data.success) {
                        let message = data.message || 'Draft gagal disimpan. Periksa kembali data yang wajib diisi.';

                        if (data.errors) {
                            const firstKey = Object.keys(data.errors)[0];
                            if (firstKey && data.errors[firstKey] && data.errors[firstKey][0]) {
                                message = data.errors[firstKey][0];
                            }
                        }

                        throw new Error(message);
                    }

                    btn.innerHTML = 'Draft Tersimpan';
                    showToast('💾 Draft data formulir anak berhasil disimpan ke database!');
                    namaField.classList.remove('is-invalid');

                    setTimeout(() => {
                        btn.innerHTML = 'SIMPAN DRAFT';
                        btn.disabled = false;
                    }, 1800);
                })
                .catch(error => {
                    btn.innerHTML = 'SIMPAN DRAFT';
                    btn.disabled = false;
                    showToast('❌ ' + error.message);
                });
        }

        /* ============================================================
            TAMBAH / HAPUS ANAK
        ============================================================ */
        let jumlahFormAnak = document.querySelectorAll('.anak-form-card').length || 1;
        const maksimalFormAnak = 5;

        function tambahAnak(btn, event) {
            if (event) event.preventDefault();

            const container = document.getElementById('anakFormsContainer');
            const formPertama = container ? container.querySelector('.anak-form-card') : null;

            if (!container || !formPertama) {
                showToast('❌ Container form anak belum ditemukan.');
                return;
            }

            jumlahFormAnak = document.querySelectorAll('.anak-form-card').length;

            if (jumlahFormAnak >= maksimalFormAnak) {
                showToast('⚠️ Maksimal 5 anak dalam satu form pendaftaran.');
                return;
            }

            const indexBaru = jumlahFormAnak;
            const formBaru = formPertama.cloneNode(true);

            resetFormAnak(formBaru);
            updateFormAnak(formBaru, indexBaru);
            prepareUploadFields(formBaru, indexBaru);

            container.appendChild(formBaru);

            refreshNomorFormAnak();
            showToast(`✅ Form Data Anak ${indexBaru + 1} berhasil ditambahkan.`);

            formBaru.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        function hapusAnak(button) {
            const card = button.closest('.anak-form-card');
            if (!card) return;

            const semuaForm = document.querySelectorAll('.anak-form-card');
            if (semuaForm.length <= 1) {
                showToast('⚠️ Minimal harus ada 1 data anak.');
                return;
            }

            card.remove();
            refreshNomorFormAnak();
            showToast('🗑️ Form data anak berhasil dihapus.');
        }

        function resetFormAnak(card) {
            card.querySelectorAll('input, textarea, select').forEach(el => {
                if (el.type === 'file') {
                    el.value = '';
                } else if (el.tagName === 'SELECT') {
                    el.selectedIndex = 0;
                } else {
                    el.value = '';
                }

                el.classList.remove('is-valid', 'is-invalid', 'input-error');
            });

            card.querySelectorAll('.upload-item').forEach(item => {
                item.classList.remove('uploaded', 'is-invalid');
            });

            card.querySelectorAll('.upload-action-btn[title="Preview"]').forEach(btn => {
                btn.classList.add('btn-preview-disabled');
            });

            const baptisItem = getUploadItem(card, 'surat_baptis');
            if (baptisItem) {
                baptisItem.style.display = 'none';
                baptisItem.style.opacity = '';
                baptisItem.style.transform = '';
            }
        }

        function updateFormAnak(card, index) {
            card.setAttribute('data-anak-index', index);

            const badge = card.querySelector('.data-anak-badge');
            if (badge) badge.textContent = `DATA ANAK ${index + 1}`;

            const deleteBtn = card.querySelector('.btn-delete-anak');
            if (deleteBtn) deleteBtn.style.display = index === 0 ? 'none' : 'block';

            const fields = [
                { field: 'nama_lengkap', baseId: 'namaLengkap' },
                { field: 'nik', baseId: 'nik' },
                { field: 'tanggal_lahir', baseId: 'tanggalLahir' },
                { field: 'gol_darah', baseId: 'golDarah' },
                { field: 'agama', baseId: 'agama' },
                { field: 'alamat', baseId: 'alamat' },
                { field: 'tempat_lahir', baseId: 'tempat-lahir' },
            ];

            fields.forEach(({ field, baseId }) => {
                const el = getField(card, field) || card.querySelector(`#${baseId}`) || card.querySelector(`#${baseId}-${index}`);
                if (!el) return;

                el.id = index === 0 ? baseId : `${baseId}-${index}`;
                el.name = index === 0 ? field : `anak[${index}][${field}]`;

                const label = el.closest('.field-group')?.querySelector('label');
                if (label) label.setAttribute('for', el.id);
            });

            const agamaSelect = getField(card, 'agama');
            if (agamaSelect) {
                agamaSelect.setAttribute('onchange', 'onSelectChange(this); toggleSuratBaptisDynamic(this)');
            }

            const samakanBtn = card.querySelector('.samakan-btn');
            if (samakanBtn) samakanBtn.setAttribute('onclick', 'samakanAlamat(this)');

            prepareUploadFields(card, index);
        }

        function refreshNomorFormAnak() {
            const semuaForm = document.querySelectorAll('.anak-form-card');

            semuaForm.forEach((card, index) => {
                updateFormAnak(card, index);
            });

            jumlahFormAnak = semuaForm.length;

            const subtitle = document.querySelector('.page-subtitle strong');
            if (subtitle) subtitle.textContent = `• ${semuaForm.length} Calon Murid`;
        }

        /* ============================================================
            LOGOUT MODAL
        ============================================================ */
        const logModal = document.getElementById('logoutModal');

        function openLogoutModal() {
            if (logModal) logModal.classList.add('show');
        }

        function closeLogoutModal() {
            if (logModal) logModal.classList.remove('show');
        }

        function handleLogout() {
            closeLogoutModal();
            showToast('<i class="fas fa-arrow-right-from-bracket"></i> Mengakhiri Sesi...');

            setTimeout(() => {
                const logoutForm = document.getElementById('logout-form');
                if (logoutForm) logoutForm.submit();
            }, 800);
        }

        /* ============================================================
            UNSAVED CHANGES GUARD
        ============================================================ */
        const leaveModal = document.getElementById('confirmLeaveModal');
        const btnLinkKembali = document.getElementById('btnLinkKembali');
        const btnCancelLeave = document.getElementById('btnCancelLeave');
        const btnConfirmLeave = document.getElementById('btnConfirmLeave');

        let targetLeaveUrl = '';

        function checkUnsavedChanges(e, targetUrl) {
            const firstCard = document.querySelector('.anak-form-card');
            const namaLengkap = getField(firstCard, 'nama_lengkap')?.value || '';
            const nik = getField(firstCard, 'nik')?.value || '';
            const alamat = getField(firstCard, 'alamat')?.value || '';

            if (namaLengkap.trim() !== '' || nik.trim() !== '' || alamat.trim() !== '') {
                e.preventDefault();
                targetLeaveUrl = targetUrl;
                if (leaveModal) leaveModal.classList.add('show');
            }
        }

        if (btnLinkKembali) {
            btnLinkKembali.addEventListener('click', function (e) {
                checkUnsavedChanges(e, this.getAttribute('href'));
            });
        }

        document.querySelectorAll('.topbar-nav .nav-link').forEach(link => {
            link.addEventListener('click', function (e) {
                checkUnsavedChanges(e, this.getAttribute('href') || '#');
            });
        });

        if (btnCancelLeave) btnCancelLeave.addEventListener('click', () => leaveModal.classList.remove('show'));
        if (btnConfirmLeave) btnConfirmLeave.addEventListener('click', () => window.location.href = targetLeaveUrl);

        /* ============================================================
            GLOBAL FORM SUBMIT MECHANISM - VALIDASI SEMUA FORM ANAK
        ============================================================ */
        const form = document.getElementById('formPesertaDidik');
        const modal = document.getElementById('errorModal');
        const closeModalBtn = document.getElementById('closeModalBtn');

        function validateSingleCard(card) {
            let valid = true;

            const rules = [
                { field: 'nama_lengkap', check: v => v.trim().length >= 3 },
                { field: 'nik', check: v => /^\d{16}$/.test(v) },
                { field: 'tanggal_lahir', check: v => v !== '' },
                { field: 'agama', check: v => v !== '' },
                { field: 'alamat', check: v => v.trim().length >= 5 },
                { field: 'tempat_lahir', check: v => v.trim().length >= 3 },
            ];

            rules.forEach(({ field, check }) => {
                const el = getField(card, field);
                const ok = el && check(el.value || '');
                if (!ok) valid = false;
                if (el) el.classList.toggle('is-invalid', !ok);
            });

            ['kartu_keluarga', 'akte_kelahiran', 'ktp_ortu', 'pas_foto'].forEach(field => {
                const item = getUploadItem(card, field);
                const input = item ? item.querySelector('input[type="file"]') : null;
                const ok = input && input.files && input.files.length > 0;

                if (!ok) valid = false;
                if (item) item.classList.toggle('is-invalid', !ok);
            });

            const agama = getField(card, 'agama');
            if (agama && agama.value === 'katolik') {
                const baptisItem = getUploadItem(card, 'surat_baptis');
                const baptisInput = baptisItem ? baptisItem.querySelector('input[type="file"]') : null;
                const ok = baptisInput && baptisInput.files && baptisInput.files.length > 0;

                if (!ok) valid = false;
                if (baptisItem) baptisItem.classList.toggle('is-invalid', !ok);
            }

            return valid;
        }

        if (form) {
            form.addEventListener('submit', function (event) {
                event.preventDefault();

                let isFormValid = true;
                const cards = document.querySelectorAll('.anak-form-card');

                cards.forEach(card => {
                    if (!validateSingleCard(card)) {
                        isFormValid = false;
                    }
                });

                if (!isFormValid) {
                    if (modal) modal.classList.add('show');
                    showToast('⚠️ Gagal mengirim formulir. Lengkapi berkas dan kolom bertanda merah.');

                    const firstInvalid = document.querySelector('.is-invalid');
                    if (firstInvalid) firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    return;
                }

                HTMLFormElement.prototype.submit.call(form);
            });
        }

        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', () => modal.classList.remove('show'));
        }

        document.addEventListener('keydown', e => {
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                saveDraft(document.getElementById('btnDraft'), null);
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            refreshNomorFormAnak();

            document.querySelectorAll('.anak-form-card').forEach(card => {
                const agamaSelect = getField(card, 'agama');
                if (agamaSelect && agamaSelect.value === 'katolik') {
                    toggleSuratBaptisDynamic(agamaSelect);
                }
            });
        });
    </script>
</body>

</html>