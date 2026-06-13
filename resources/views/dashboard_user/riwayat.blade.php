<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAKTI Portal – Riwayat Pendaftaran</title>
    
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

        /* ===================== LIST RECORD ROW ===================== */
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

        .student-profile {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        /* Avatar Box diubah warnanya jadi soft blue untuk menampung icon dokumen */
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

        .student-meta-tags {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #94a3b8;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 11px;
            font-weight: 700;
        }

        .uid-code {
            font-family: 'DM Mono', monospace;
            font-size: 11px;
            color: #a4b2c6;
            letter-spacing: -0.2px;
        }

        .meta-divider {
            color: #cbd5e1;
        }

        /* ===================== STATUS BADGES PILL ===================== */
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
        }

        /* State Warna Dinamis */
        .status-pending {
            background: var(--blue-status-bg);
            color: var(--blue-status);
        }

        .status-approved {
            background: var(--green-status-bg);
            color: var(--green-status);
        }

        .status-rejected {
            background: var(--red-status-bg);
            color: var(--red-status);
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
            .history-row { flex-direction: column; align-items: stretch; text-align: center; padding: 24px; }
            .student-profile { flex-direction: column; gap: 12px; }
            .student-meta-tags { justify-content: center; flex-direction: column; gap: 4px; }
            .meta-divider { display: none; }
            .badge-status-pill { width: 100%; }
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
                        <i class="fa-solid fa-table-cells-large"></i> Dashboard<span class="nav-dot"></span>
                    </a>
                    <a class="nav-link" href="#">
                        <i class="fa-solid fa-clock-rotate-left"></i> Riwayat 
                    </a>
                    <a class="nav-link" href="#"><i class="fa-solid fa-circle-info"></i> Pusat Bantuan</a>
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

    <main class="main-wrapper">
        <div class="container">
            <div class="dashboard-card">
                
                <div class="card-header-history">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <h2 class="card-title-history">Riwayat Pendaftaran</h2>
                </div>

                <div class="history-list-container">
                    
                    @forelse($dataSiswa as $siswa)
                        <div class="history-row">
                            <div class="student-profile">
                                <div class="document-icon-box">
                                    <i class="fa-solid fa-file-lines"></i>
                                </div>
                                <div class="student-details">
                                    <h3 class="student-name">{{ $siswa->nama_lengkap }}</h3>
                                    
                                    <div class="student-meta-tags">
                                        <span class="uid-code">ID: {{ $siswa->nomor_registrasi ?? 'REG-MOCK-PARENT-001-1781196705596-0' }}</span>
                                        <span class="meta-divider">•</span>
                                        <span>{{ $siswa->created_at ? $siswa->created_at->format('d/m/Y') : '11/6/2026' }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="status-actions">
                                @if($siswa->status == 'pending' || $siswa->status == 'verifikasi' || $siswa->status == 'proses')
                                    <div class="badge-status-pill status-pending">
                                        Pending
                                    </div>
                                @elif($siswa->status == 'approved' || $siswa->status == 'diterima')
                                    <div class="badge-status-pill status-approved">
                                        Approved
                                    </div>
                                @else
                                    <div class="badge-status-pill status-rejected">
                                        Rejected
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="history-row" style="justify-content: center; padding: 48px; color: var(--text-gray); border-style: dashed;">
                            <div style="text-align: center;">
                                <i class="fa-solid fa-clock" style="font-size: 28px; margin-bottom: 12px; display: block; color: #94a3b8;"></i>
                                <p style="font-size: 14px; font-weight: 600;">Belum ada riwayat pendaftaran berkas.</p>
                            </div>
                        </div>
                    @endforelse

                </div>

            </div>
        </div>
    </main>

    <footer class="page-footer">
        Yayasan Kanisius © 2026 • Admisi Terintegrasi
    </footer>

</body>
</html>