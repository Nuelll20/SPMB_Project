<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAKTI Portal – Portal Orang Tua</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy:      #1a2a6c;
            --blue:      #004AAD;
            --gold:      #f5c400;
            --gold-dark: #c9a200;
            --bg:        #f0f2f8;
            --surface:   #ffffff;
            --surface2:  #f4f6fb;
            --border:    #e0e4ef;
            --text:      #1a1f36;
            --muted:     #7b82a0;
            --green:     #16a34a;
            --green-bg:  #dcfce7;
            --red:       #dc2626;
            --radius:    14px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

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
            box-shadow: 0 2px 16px rgba(26,42,108,0.07);
        }

        /* Brand */
        .topbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-right: 40px;
        }

        .brand-logo-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .brand-logo-wrap img {
            height: 42px;
            width: auto;
            object-fit: contain;
        }

        .brand-text { display: flex; flex-direction: column; line-height: 1.1; }

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
            gap: 7px;
            padding: 8px 16px;
            border-radius: 8px;
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

        .nav-link:hover { background: var(--surface2); color: var(--text); }

        .nav-link.active {
            color: var(--blue);
            background: rgba(0,74,173,0.07);
            font-weight: 700;
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
            width: 36px; height: 36px;
            background: rgba(220,38,38,0.07);
            border: 1.5px solid rgba(220,38,38,0.15);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            color: var(--red);
        }

        .topbar-logout:hover {
            background: rgba(220,38,38,0.12);
            border-color: rgba(220,38,38,0.3);
        }

        /* ==================== PAGE BODY ==================== */
        .page-body {
            flex: 1;
            padding: 48px 40px 40px;
            max-width: 1100px;
            width: 100%;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 28px;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ==================== MAIN CARD ==================== */
        .main-card {
            background: var(--surface);
            border-radius: 22px;
            border: 1px solid var(--border);
            padding: 40px 44px 44px;
            box-shadow: 0 4px 40px rgba(26, 42, 108, 0.07);
            display: flex;
            flex-direction: column;
            gap: 32px;
            opacity: 0;
            animation: fadeUp 0.5s ease 0.1s forwards;
            position: relative;
            overflow: hidden;
        }

        .main-card::before {
            content: '';
            position: absolute;
            top: -80px;
            right: -80px;
            width: 280px;
            height: 280px;
            background: radial-gradient(circle, rgba(245,196,0,0.08) 0%, transparent 70%);
            pointer-events: none;
        }

        .main-card::after {
            content: '';
            position: absolute;
            bottom: -60px;
            left: -60px;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(0,74,173,0.06) 0%, transparent 70%);
            pointer-events: none;
        }

        /* ==================== CARD HEADER ==================== */
        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        .card-header-left { display: flex; flex-direction: column; gap: 12px; }

        .card-title {
            font-size: 34px;
            font-weight: 800;
            color: var(--navy);
            letter-spacing: -0.5px;
            line-height: 1.1;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(22, 163, 74, 0.1);
            border: 1px solid rgba(22, 163, 74, 0.25);
            border-radius: 40px;
            padding: 7px 16px;
            width: fit-content;
        }

        .status-badge-icon { font-size: 14px; }

        .status-badge-text {
            font-size: 12px;
            font-weight: 800;
            color: var(--green);
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .status-badge-dot {
            width: 4px;
            height: 4px;
            background: var(--green);
            border-radius: 50%;
        }

        .btn-daftarkan {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--navy);
            color: #fff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            font-weight: 800;
            padding: 15px 34px;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            letter-spacing: 0.5px;
            transition: all 0.25s ease;
            box-shadow: 0 6px 24px rgba(26, 42, 108, 0.25);
            white-space: nowrap;
            flex-shrink: 0;
            text-decoration: none;
        }

        .btn-daftarkan:hover {
            background: #111c50;
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(26, 42, 108, 0.35);
        }

        .btn-daftarkan .plus-icon {
            width: 22px;
            height: 22px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 700;
            line-height: 1;
            flex-shrink: 0;
        }

        /* ==================== STUDENT LIST ==================== */
        .student-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            position: relative;
            z-index: 1;
        }

        .student-card {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 22px 28px;
            background: var(--surface2);
            border: 1.5px solid var(--border);
            border-radius: 16px;
            transition: all 0.22s;
            position: relative;
            overflow: hidden;
        }

        .student-card::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 4px;
            background: var(--navy);
            border-radius: 0 3px 3px 0;
            opacity: 0;
            transition: opacity 0.2s;
        }

        .student-card:hover {
            border-color: rgba(26, 42, 108, 0.2);
            background: #f8f9fd;
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(26, 42, 108, 0.08);
        }

        .student-card:hover::before { opacity: 1; }

        .student-avatar {
            width: 52px;
            height: 52px;
            background: var(--border);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
        }

        .student-avatar svg {
            width: 28px;
            height: 28px;
            color: var(--muted);
        }

        .student-info {
            flex: 1;
            min-width: 0;
        }

        .student-name {
            font-size: 17px;
            font-weight: 800;
            color: var(--navy);
            margin-bottom: 6px;
        }

        .student-meta {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            font-weight: 600;
            color: var(--muted);
        }

        .student-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .btn-verifikasi {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--surface);
            border: 1.5px solid var(--gold-dark);
            color: #a07700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 12px;
            font-weight: 800;
            padding: 10px 20px;
            border-radius: 40px;
            cursor: pointer;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .btn-verifikasi:hover {
            background: rgba(245,196,0,0.1);
            border-color: var(--gold);
        }

        .btn-verifikasi .spin-icon {
            font-size: 13px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }

        .btn-antrian {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--navy);
            color: #fff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 12.5px;
            font-weight: 800;
            padding: 10px 22px;
            border-radius: 40px;
            border: none;
            cursor: pointer;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .btn-antrian:hover {
            background: #111c50;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(26,42,108,0.28);
        }

        /* ==================== FOOTER ==================== */
        .page-footer {
            text-align: center;
            padding: 24px;
            font-size: 11px;
            font-weight: 700;
            color: var(--muted);
            letter-spacing: 1.4px;
            text-transform: uppercase;
            opacity: 0;
            animation: fadeUp 0.5s ease 0.3s forwards;
        }

        /* ==================== TOAST ==================== */
        #toast {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%) translateY(70px);
            background: var(--navy);
            color: white;
            padding: 12px 28px;
            border-radius: 40px;
            font-size: 13.5px;
            font-weight: 600;
            opacity: 0;
            pointer-events: none;
            transition: transform 0.4s cubic-bezier(0.22,1,0.36,1), opacity 0.4s;
            z-index: 9999;
            white-space: nowrap;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
        }

        #toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }

        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 900px) {
            .page-body   { padding: 28px 20px; }
            .topbar      { padding: 0 20px; }
            .brand-uid   { display: none; }
            .main-card   { padding: 28px 24px 32px; }
            .card-title  { font-size: 26px; }
        }

        @media (max-width: 640px) {
            .topbar-nav  { display: none; }
            .card-header { flex-direction: column; align-items: flex-start; }
            .btn-daftarkan { width: 100%; justify-content: center; }
            .student-card  { flex-wrap: wrap; gap: 14px; }
            .student-actions { width: 100%; }
            .btn-verifikasi, .btn-antrian { flex: 1; justify-content: center; }
        }
    </style>
</head>
<body>

    <header class="topbar">
        <div class="topbar-brand">
            <div class="brand-logo-wrap">
                <img src="{{ asset('img/E-Kanisius 1.png') }}" alt="Logo SAKTI">
            </div>
            <div class="brand-text">
                <div class="brand-name">PORTAL SAKTI</div>
                <div class="brand-meta">
                    <span class="brand-role">Parent</span>
                    <span class="brand-uid">UID-MOCK-parent-001</span>
                </div>
            </div>
        </div>

        <nav class="topbar-nav">
            <a class="nav-link active" href="{{ route('dashboard') }}">
                Dashboard
            </a>
            <a class="nav-link" href="{{ route('riwayat') }}" onclick="showToast('🕐 Membuka Riwayat...');">
                Riwayat
            </a>
            <a class="nav-link" href="{{ route('pusat-bantuan') }}" onclick="showToast('ⓘ Membuka Pusat Bantuan...');">
                Pusat Bantuan
            </a>
        </nav>

        <div class="topbar-right">
            <div class="topbar-username">
                <div class="topbar-uname">Ortu Demo</div>
                <div class="topbar-urole">Cabang Global</div>
            </div>
            <a href="{{ route('logout') }}" class="topbar-logout" title="Keluar" onclick="showToast('🚪 Sedang keluar...');">
                ↪
            </a>
        </div>
    </header>

    <main class="page-body">
        <div class="main-card">
            <div class="card-header">
                <div class="card-header-left">
                    <h1 class="card-title">Portal Orang Tua</h1>
                    <div class="status-badge">
                        <span class="status-badge-icon">✦</span>
                        <span class="status-badge-text">Status: Batch 1 (Gelombang Utama)</span>
                        <span class="status-badge-dot"></span>
                        <span class="status-badge-text">Sisa Kuota: 23</span>
                    </div>
                </div>

                <a href="{{ route('dashboard_user.form_daftar') }}" class="btn-daftarkan" onclick="showToast('➕ Membuka formulir pendaftaran...')">
                    <span class="plus-icon">＋</span>
                    DAFTARKAN ANAK
                </a>
            </div>

            <div class="student-list" id="studentList">
                <div class="student-card">
                    <div class="student-avatar">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg" style="color: #7b82a0;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 20.118a7.5 7.5 0 0115 0"/>
                        </svg>
                    </div>

                    <div class="student-info">
                        <div class="student-name">alex</div>
                        <div class="student-meta">
                            <div class="meta-item">
                                <span class="meta-icon">🏫</span> JOG-WRO
                            </div>
                            <div class="meta-item">
                                <span class="meta-icon">🕐</span> 11/6/2026
                            </div>
                            <div class="meta-item">
                                <span class="meta-icon">🔖</span> REG-0
                            </div>
                        </div>
                    </div>

                    <div class="student-actions">
                        <button class="btn-verifikasi" onclick="showToast('📋 Membuka verifikasi berkas...')">
                            <span class="spin-icon">◌</span> VERIFIKASI BERKAS
                        </button>
                        <button class="btn-antrian" onclick="showToast('📌 Kamu dalam antrian pendaftaran.')">
                            DALAM ANTRIAN
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="page-footer">
        Yayasan Kanisius © 2026 &nbsp;·&nbsp; Admisi Terintegrasi
    </footer>

    <div id="toast"></div>

    <script>
    function showToast(msg, dur = 3000) {
        const t = document.getElementById('toast');
        t.textContent = msg;
        t.classList.add('show');
        clearTimeout(t._timer);
        t._timer = setTimeout(() => t.classList.remove('show'), dur);
    }

    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function () {
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });
    </script>
</body>
</html>