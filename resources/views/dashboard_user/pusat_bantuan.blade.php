<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAKTI Portal – Pusat Bantuan</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* ===================== CSS VARIABLES (:ROOT) ===================== */
        :root {
            --navy: #002B5B;       /* Warna utama SAKTI Blue */
            --navy-dark: #001F42;
            --gold: #E5A93C;       /* Aksen SAKTI Orange / Gold */
            --gold-light: #FFF8E7;
            --gold-border: #FCE8BD;
            --bg: #F4F7FA;         /* Background canvas luar */
            --surface: #ffffff;    /* Warna dasar container/card */
            --border: #eef2f6;
            --text-dark: #002B5B;
            --text-gray: #7b82a0;
            --muted-bg: #F0F5FA;
            
            /* Status Colors */
            --blue-status: #004AAD;
            --blue-status-bg: #E8F0FE;
            --green-status: #16a34a;
            --green-status-bg: #EAF9F1;
            --red-status: #dc2626;
            --red-status-bg: #FFF0F0;

            --radius-lg: 40px;
            --radius-md: 24px;
            --radius-sm: 16px;
        }

        /* ===================== GENERAL RESET & ANIMATIONS ===================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: #334155;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* Keyframes Animasi Entrance */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* ===================== TOPBAR / NAVBAR ===================== */
        .topbar-wrapper {
            width: 100%;
            background: var(--bg);
            padding-top: 24px;
            animation: fadeIn 0.6s ease forwards;
        }

        .topbar {
            background: var(--surface);
            border-radius: var(--radius-md);
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 20px rgba(0, 43, 91, 0.04);
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

        /* ===================== MAIN CONTENT CARD ===================== */
        .main-wrapper {
            padding: 32px 0;
            flex: 1;
        }

        .dashboard-card {
            background: var(--surface);
            border-radius: var(--radius-lg);
            padding: 48px;
            box-shadow: 0 10px 30px rgba(0, 43, 91, 0.02);
            border: 1px solid rgba(238, 242, 246, 0.5);
            
            opacity: 0;
            animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) 0.1s forwards;
        }

        /* Card Header */
        .card-header-history {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 32px;
        }

        .card-header-history i {
            color: var(--navy);
            font-size: 18px;
        }

        .card-title-history {
            font-size: 13px;
            font-weight: 900;
            color: var(--text-dark);
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        /* ===================== HISTORY LIST / REUSED FOR HELP CENTER ===================== */
        .history-list-container {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .history-row {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 24px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .history-row:hover {
            transform: translateY(-2px);
            border-color: rgba(0, 74, 173, 0.15);
            box-shadow: 0 6px 20px rgba(0, 43, 91, 0.04);
        }

        .document-icon-box {
            width: 54px;
            height: 54px;
            background: #EBF3FC;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #004AAD;
            font-size: 20px;
            transition: all 0.3s ease;
        }

        .history-row:hover .document-icon-box {
            background: #004AAD;
            color: #ffffff;
        }

        .student-profile {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .student-details {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .student-name {
            font-size: 16px;
            font-weight: 800;
            color: var(--text-dark);
        }

        .badge-status-pill {
            border: none;
            border-radius: 12px;
            padding: 10px 28px;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 110px;
            text-decoration: none;
        }

        .status-approved {
            background: var(--green-status-bg);
            color: var(--green-status);
        }

        /* ===================== HELP CENTER LAYOUT ===================== */
        .help-grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr;
            gap: 32px;
            align-items: start;
        }

        .section-title {
            font-size: 26px;
            font-weight: 900;
            color: var(--text-dark);
            margin-bottom: 24px;
        }

        .faq-card {
            background: var(--muted-bg);
            border-radius: var(--radius-md);
            padding: 24px 28px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .faq-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 43, 91, 0.04);
        }

        .faq-question {
            font-size: 15px;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 10px;
        }

        .faq-answer {
            font-size: 13.5px;
            line-height: 1.7;
            color: var(--text-gray);
            font-weight: 500;
        }

        .contact-card {
            background: var(--navy);
            border-radius: var(--radius-md);
            padding: 32px;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
        }

        .contact-icon-box {
            width: 44px;
            height: 44px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            font-size: 18px;
            flex-shrink: 0;
        }

        .contact-text-title {
            font-size: 14.5px;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 4px;
        }

        .contact-text-sub {
            font-size: 12px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.5;
        }

        .contact-text-sub a {
            color: rgba(255, 255, 255, 0.75);
            text-decoration: none;
        }

        .contact-text-sub a:hover {
            color: #ffffff;
        }

        .btn-operator {
            margin-top: 4px;
            background: var(--gold);
            color: var(--navy);
            border: none;
            border-radius: 14px;
            padding: 18px 28px;
            font-size: 13px;
            font-weight: 900;
            letter-spacing: 1px;
            text-transform: uppercase;
            text-align: center;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .btn-operator:hover {
            background: #f0b94e;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(229, 169, 60, 0.35);
        }

        /* ===================== FOOTER SYSTEM ===================== */
        .page-footer {
            text-align: center;
            padding: 24px;
            font-size: 10.5px;
            font-weight: 700;
            color: #a4b2c6;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-top: auto;
        }

        /* Responsive Styling */
        @media (max-width: 768px) {
            .topbar { flex-direction: column; gap: 16px; text-align: center; }
            .topbar-nav { gap: 16px; }
            .help-grid { grid-template-columns: 1fr; }
            .dashboard-card { padding: 28px; }
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
                        <i class=""></i> Dashboard
                    </a>
                    <a class="nav-link" href="{{ route('riwayat') }}">
                        <i class=""></i> Riwayat 
                    </a>
                    <a class="nav-link active" href="{{ route('pusat_bantuan') }}">
                        <i class=""></i> Pusat Bantuan<span class="nav-dot"></span>
                    </a>
                </nav>

                <div class="topbar-right">
                    <div class="user-info">
                        <div class="user-name">Ortu Demo</div>
                        <div class="user-branch">Cabang Global</div>
                    </div>
                    <a href="{{ route('logout') }}" class="btn-logout" title="Keluar">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </a>
                </div>
            </header>
        </div>
    </div>

    <main class="main-wrapper">
        <div class="container">
            <div class="dashboard-card">
                
                <div class="card-header-history">
                    <i class="fa-solid fa-circle-info"></i>
                    <h2 class="card-title-history">Pusat Bantuan SAKTI</h2>
                </div>

                <div class="help-grid">

                    <!-- FAQ Pendaftaran -->
                    <div>
                        <h2 class="section-title">FAQ Pendaftaran</h2>

                        <div class="faq-list">
                            <div class="faq-card">
                                <div class="faq-question">Bagaimana cara mengganti unit sekolah pendaftaran?</div>
                                <div class="faq-answer">
                                    Jika pendaftaran masih berupa Draft, Anda dapat menghapusnya dan memulai baru. Jika sudah terkirim, silakan hubungi admin sekolah melalui fitur chat bantuan.
                                </div>
                            </div>

                            <div class="faq-card">
                                <div class="faq-question">Apa saja berkas yang wajib diunggah?</div>
                                <div class="faq-answer">
                                    Dokumen wajib meliputi Kartu Keluarga, Akte Kelahiran, pas foto 3x4, dan KTP Orang Tua. Untuk pendaftar beragama Katolik, wajib menyertakan Surat Baptis.
                                </div>
                            </div>

                            <div class="faq-card">
                                <div class="faq-question">Berapa lama proses verifikasi berkas?</div>
                                <div class="faq-answer">
                                    Proses verifikasi oleh admin sekolah biasanya memakan waktu 2-3 hari kerja sejak dokumen dinyatakan lengkap.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kontak Kami -->
                    <div>
                        <h2 class="section-title">Kontak Kami</h2>

                        <div class="contact-card">
                            <div class="contact-item">
                                <div class="contact-icon-box">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </div>
                                <div>
                                    <div class="contact-text-title">Chat Bantuan Langsung</div>
                                    <div class="contact-text-sub">
                                        WhatsApp: <a href="https://wa.me/6281234567890" target="_blank" rel="noopener">+62 812-3456-7890</a>
                                    </div>
                                </div>
                            </div>

                            <div class="contact-item">
                                <div class="contact-icon-box">
                                    <i class="fa-solid fa-building-columns"></i>
                                </div>
                                <div>
                                    <div class="contact-text-title">Sekretariat Yayasan</div>
                                    <div class="contact-text-sub">
                                        Jl. Imam Bonjol No. 180, Semarang
                                    </div>
                                </div>
                            </div>

                            <a href="https://wa.me/6281234567890" target="_blank" rel="noopener" class="btn-operator">
                                <i class="fa-solid fa-headset"></i> Hubungi Operator
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </main>

    <footer class="page-footer">
        Yayasan Kanisius © 2026 • Admisi Terintegrasi
    </footer>

</body>
</html>