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
            --blue: #004AAD;
            --gold: #E5A93C;       /* Aksen SAKTI Orange / Gold */
            --gold-light: #FFF8E7;
            --gold-border: #FCE8BD;
            --bg: #F4F7FA;         /* Background canvas luar */
            --surface: #ffffff;    /* Warna dasar container/card */
            --border: #eef2f6;
            --text-dark: #002B5B;
            --text-gray: #7b82a0;
            --muted-bg: #F0F5FA;
            --red: #dc2626;
            
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
            max-width: 1152px;
            width: 100%;
            margin: 0 auto;
            padding: 0 16px;
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
            padding-top: 16px; 
            animation: fadeIn 0.6s ease forwards;
        }

        .topbar {
            background: var(--surface);
            border-radius: 16px; 
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 20px rgba(0, 43, 91, 0.04);
            border: 1px solid var(--border); 
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
            border-radius: 22px;
            padding: 40px 44px 44px;
            box-shadow: 0 4px 40px rgba(26, 42, 108, 0.07);
            border: 1px solid var(--border);
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

        /* PERBAIKAN: Menambahkan layout list & gap jarak 16px agar card FAQ tidak menempel */
        .faq-list {
            display: flex;
            flex-direction: column;
            gap: 16px; 
        }

        .faq-card {
            background: var(--muted-bg);
            border-radius: var(--radius-sm);
            padding: 24px 28px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            border: 1px solid transparent;
        }

        .faq-card:hover {
            transform: translateY(-2px);
            background: var(--surface);
            border-color: rgba(0, 74, 173, 0.15);
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
            border-radius: var(--radius-sm);
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

        .modal-overlay.show { opacity: 1; pointer-events: auto; }

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

        .modal-title { font-size: 18px; font-weight: 800; color: var(--navy); margin-bottom: 8px; }
        .modal-desc { font-size: 14px; color: var(--muted); line-height: 1.5; margin-bottom: 24px; }

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
            transition: background 0.2s;
        }
        .modal-btn-close:hover { background: #111c44; }
        .modal-btn-group { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .modal-btn-cancel { background: var(--surface2); color: #334155; border: 1px solid var(--border); }
        .modal-btn-cancel:hover { background: #e2e8f0; }

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

        /* ==================== TOAST ==================== */
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

        /* ==================== MASTER RESPONSIVE ==================== */
        @media (max-width: 900px) {
            .help-grid { grid-template-columns: 1fr; gap: 32px; }
            .dashboard-card { padding: 32px 24px; }
        }

        @media (max-width: 768px) {
            .topbar { padding: 12px 20px; }
            .topbar-nav { gap: 16px; }
        }

        @media (max-width: 640px) {
            .topbar { flex-direction: column; gap: 14px; padding: 16px; text-align: center; }
            .topbar-brand { flex-direction: column; gap: 4px; }
            .topbar-nav { width: 100%; justify-content: center; gap: 16px; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); padding: 8px 0; }
            .topbar-right { width: 100%; justify-content: space-between; }
            .user-info { text-align: left; }
            .btn-operator { width: 100%; justify-content: center; }
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
                    <a class="nav-link active" href="{{ route('pusat_bantuan') }}">
                         Pusat Bantuan<span class="nav-dot"></span>
                    </a>
                </nav>

                <div class="topbar-right">
                    <div class="user-info">
                        <div class="user-name">{{ auth()->user()->name ?? 'Orang Tua' }}</div>
                        <div class="user-branch">Cabang Global</div>
                    </div>
<<<<<<< HEAD
                    <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                        @csrf
                        <button type="submit" class="btn-logout" title="Keluar" onclick="return confirm('Apakah Anda yakin ingin keluar?')">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        </button>
                    </form>
=======
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <button type="button" class="btn-logout" title="Keluar" onclick="openLogoutModal()" style="border: none; background: none; cursor: pointer;">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </button>
>>>>>>> b9efc4c094d501c2c3a3dc6456cc98671d3eb5a7
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
                                    Jika pendaftaran masih berupa Draft, Anda dapat menghapusnya and memulai baru. Jika sudah terkirim, silakan hubungi admin sekolah melalui fitur chat bantuan.
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

    <!-- STRUCTURE LOGOUT POP-UP MODAL -->
    <div id="logoutModal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-icon" style="background: #fff5f5; color: var(--red);"><i class="fa-solid fa-arrow-right-from-bracket"></i></div>
            <h3 class="modal-title">Mengakhiri Sesi?</h3>
            <p class="modal-desc">Apakah Anda yakin ingin keluar dari SAKTI Portal? Sesi Anda akan dihapus demi keamanan akun.</p>
            <div class="modal-btn-group">
                <button type="button" onclick="closeLogoutModal()" class="modal-btn-close modal-btn-cancel">Batal</button>
                <button type="button" onclick="handleLogout()" class="modal-btn-close" style="background: var(--navy);">Ya, Keluar</button>
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

        /* ============================================================
            MODAL LOGOUT CONTROLLERS
        ============================================================ */
        const logModal = document.getElementById('logoutModal');

        function openLogoutModal() { logModal.classList.add('show'); }
        function closeLogoutModal() { logModal.classList.remove('show'); }

        function handleLogout() {
            closeLogoutModal();
            showToast('<i class="fas fa-arrow-right-from-bracket"></i> Mengakhiri Sesi...');
            setTimeout(() => {
                const logoutForm = document.getElementById('logout-form');
                if (logoutForm) logoutForm.submit();
            }, 800); 
        }
    </script>
</body>
</html>