<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAKTI Portal – Portal Orang Tua</title>
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
            --green-bg: #dcfce7;
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
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            padding: 0 24px;
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

        /* Indikator Titik Emas Aktif Berpindah Ke Riwayat */
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
        }

        .btn-logout:hover {
            background: #FFE0E0;
            transform: scale(1.05);
        }

        .btn-logout i {
            color: #FF4D4D;
            font-size: 14px;
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
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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
            background: radial-gradient(circle, rgba(245, 196, 0, 0.08) 0%, transparent 70%);
            pointer-events: none;
        }

        .main-card::after {
            content: '';
            position: absolute;
            bottom: -60px;
            left: -60px;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(0, 74, 173, 0.06) 0%, transparent 70%);
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

        .card-header-left {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

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

        .status-badge-icon {
            font-size: 14px;
        }

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
            background: rgba(255, 255, 255, 0.2);
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
            left: 0;
            top: 0;
            bottom: 0;
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

        .student-card:hover::before {
            opacity: 1;
        }

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
            background: rgba(245, 196, 0, 0.1);
            border-color: var(--gold);
        }

        .btn-verifikasi .spin-icon {
            font-size: 13px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
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
            box-shadow: 0 4px 14px rgba(26, 42, 108, 0.28);
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
            transition: transform 0.4s cubic-bezier(0.22, 1, 0.36, 1), opacity 0.4s;
            z-index: 9999;
            white-space: nowrap;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.18);
        }

        #toast.show {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 900px) {
            .page-body {
                padding: 28px 20px;
            }

            .topbar {
                padding: 0 20px;
            }

            .brand-uid {
                display: none;
            }

            .main-card {
                padding: 28px 24px 32px;
            }

            .card-title {
                font-size: 26px;
            }
        }

        @media (max-width: 640px) {
            .topbar-nav {
                display: none;
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .btn-daftarkan {
                width: 100%;
                justify-content: center;
            }

            .student-card {
                flex-wrap: wrap;
                gap: 14px;
            }

            .student-actions {
                width: 100%;
            }

            .btn-verifikasi,
            .btn-antrian {
                flex: 1;
                justify-content: center;
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
                    <a class="nav-link active" href="{{ route('dashboard') }}">
                         Dashboard <span class="nav-dot"></span>
                    </a>
                    <a class="nav-link" href="{{ route('riwayat') }}">
                         Riwayat 
                    </a>
                    <a class="nav-link" href="#"> Pusat Bantuan</a>
                </nav>

                <div class="topbar-right">
                    <div class="user-info">
                        <div class="user-name">Ortu Demo</div>
                        <div class="user-branch">Cabang Global</div>
                    </div>
                    <button class="btn-logout" title="Keluar">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </button>
                </div>
            </header>
        </div>
    </div>

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

                <a href="{{ route('form.daftar') }}" class="btn-daftarkan"
                    onclick="showToast('Membuka formulir pendaftaran...')">
                    <span class="plus-icon">＋</span>
                    DAFTARKAN ANAK
                </a>
            </div>

            <div class="student-list" id="studentList">
                @forelse($dataSiswa as $siswa)
                    <div class="student-card">
                        <div class="student-avatar">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                xmlns="http://www.w3.org/2000/svg" style="color: #7b82a0;">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 20.118a7.5 7.5 0 0115 0" />
                            </svg>
                        </div>



                        <div class="student-info">
                            <div class="student-name">
                                {{ $siswa->nama }}
                            </div>

                            <div class="student-meta">

                                <div class="meta-item">
                                    <span class="meta-icon">📍</span>
                                    {{ $siswa->tempat_lahir }}
                                </div>

                                <div class="meta-item">
                                    <span class="meta-icon">🕐</span>
                                    {{ \Carbon\Carbon::parse($siswa->created_at)->format('d/m/Y') }}
                                </div>

                                <div class="meta-item">
                                    <span class="meta-icon">🔖</span>
                                    {{ $siswa->nomor_registrasi }}
                                </div>

                            </div>
                        </div>


                        <div class="student-actions">
                            <a href="{{ route('verifikasi.berkas', $siswa->uid) }}" class="btn-verifikasi">
                                <span class="spin-icon">◌</span> VERIFIKASI BERKAS
                            </a>
                            <button class="btn-antrian">
                                {{ strtoupper($siswa->status) }}
                            </button>
                        </div>
                    </div>
                @empty
                    <p>Tidak ada data siswa yang ditemukan.</p>
                @endforelse
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