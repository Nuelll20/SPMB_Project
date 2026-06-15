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

        /* ===================== LIST RECORD ROW ===================== */
        .history-list-container {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .history-row {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
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

        /* Document Box Kursor Pointer untuk Aksi Klik Detail */
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
            cursor: pointer;
        }

        .document-icon-box:hover {
            background: #004AAD !important;
            color: #ffffff !important;
            transform: scale(1.05);
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

        .status-pending { background: var(--blue-status-bg); color: var(--blue-status); }
        .status-approved { background: var(--green-status-bg); color: var(--green-status); }
        .status-rejected { background: var(--red-status-bg); color: var(--red-status); }

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
        
        /* Modal Box Khusus Detail Rangkuman Siswa */
        .modal-box-detail {
            max-width: 550px;
            text-align: left;
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

        .modal-title { font-size: 18px; font-weight: 800; color: var(--navy); margin-bottom: 8px; }
        .modal-desc { font-size: 14px; color: var(--muted); line-height: 1.5; margin-bottom: 24px; }

        /* Detail Grid untuk info KTP/Biodata di dalam modal */
        .detail-info-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 14px;
            margin-bottom: 24px;
            background: var(--surface2);
            padding: 20px;
            border-radius: 12px;
            border: 1px solid var(--border);
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .detail-label {
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            color: var(--text-gray);
            letter-spacing: 0.5px;
        }

        .detail-value {
            font-size: 14px;
            font-weight: 600;
            color: var(--navy);
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
            .page-body { padding: 24px 16px; }
            .dashboard-card { padding: 32px 24px; }
        }

        @media (max-width: 768px) {
            .topbar { padding: 12px 20px; }
            .topbar-nav { gap: 16px; }
            .history-row { padding: 24px; }
        }

        @media (max-width: 640px) {
            .topbar { flex-direction: column; gap: 14px; padding: 16px; text-align: center; }
            .topbar-brand { flex-direction: column; gap: 4px; }
            .topbar-nav { width: 100%; justify-content: center; gap: 16px; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); padding: 8px 0; }
            .topbar-right { width: 100%; justify-content: space-between; }
            .user-info { text-align: left; }
            .history-row { flex-direction: column; align-items: stretch; text-align: center; gap: 16px; padding: 20px 16px; }
            .student-profile { flex-direction: column; gap: 12px; }
            .student-meta-tags { justify-content: center; flex-direction: column; gap: 4px; }
            .meta-divider { display: none; }
            .badge-status-pill { width: 100%; }
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
                    <a class="nav-link active" href="{{ route('riwayat') }}">
                         Riwayat <span class="nav-dot"></span>
                    </a>
<<<<<<< HEAD
                    <a class="nav-link" href="{{ route('pusat_bantuan') }}"><i class="fa-solid fa-circle-info"></i> Pusat Bantuan</a>
=======
                    <a class="nav-link" href="{{ route('pusat_bantuan') }}"> Pusat Bantuan</a>
>>>>>>> b9efc4c094d501c2c3a3dc6456cc98671d3eb5a7
                </nav>

                <div class="topbar-right">
                    <div class="user-info">
                        <div class="user-name">{{ auth()->user()->name ?? 'Orang Tua' }}</div>
                        <div class="user-branch">Cabang Global</div>
                    </div>
<<<<<<< HEAD
                    <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                        @csrf
                        <button type="submit" id="btnTopbarLogout" class="btn-logout" title="Keluar" onclick="return confirm('Apakah Anda yakin ingin keluar?')">
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
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <h2 class="card-title-history">Riwayat Pendaftaran</h2>
                </div>

                <div class="history-list-container">
                    
                    @forelse($dataSiswa as $siswa)
                        <div class="history-row">
                            <div class="student-profile">
                                <div class="document-icon-box" title="Lihat Detail Formulir" 
                                     onclick="openDetailModal('{{ $siswa->nama_lengkap }}', '{{ $siswa->nik }}', '{{ $siswa->tempat_lahir }}, {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d/m/Y') }}', '{{ $siswa->agama }}', '{{ $siswa->golongan_darah }}', '{{ $siswa->alamat }}')">
                                    <i class="fa-solid fa-file-lines"></i>
                                </div>
                                <div class="student-details">
                                    <h3 class="student-name">{{ $siswa->nama }}</h3>
                                    
                                    <div class="student-meta-tags">
                                        <span class="uid-code">ID: {{ $siswa->nomor_registrasi ?? 'REG-MOCK-PARENT-001' }}</span>
                                        <span class="meta-divider">•</span>
                                        <span>{{ $siswa->created_at ? \Carbon\Carbon::parse($siswa->created_at)->format('d/m/Y') : '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="status-actions">
                                @if($siswa->status == 'pending' || $siswa->status == 'verifikasi' || $siswa->status == 'proses')
<<<<<<< HEAD
                                    <div class="badge-status-pill status-pending">
                                        Pending
                                    </div>
                                @elseif($siswa->status == 'approved' || $siswa->status == 'diterima')
                                    <div class="badge-status-pill status-approved">
                                        Approved
                                    </div>
=======
                                    <div class="badge-status-pill status-pending">Pending</div>
                                @elif($siswa->status == 'approved' || $siswa->status == 'diterima')
                                    <div class="badge-status-pill status-approved">Approved</div>
>>>>>>> b9efc4c094d501c2c3a3dc6456cc98671d3eb5a7
                                @else
                                    <div class="badge-status-pill status-rejected">Rejected</div>
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

    <div id="detailModal" class="modal-overlay">
        <div class="modal-box modal-box-detail">
            <h3 class="modal-title" style="margin-bottom: 4px;"><i class="fa-solid fa-id-card" style="color: var(--blue); margin-right: 8px;"></i>Rangkuman Formulir Siswa</h3>
            <p class="modal-desc" style="margin-bottom: 16px;">Berikut data biner yang tersimpan di dalam sistem admisi.</p>
            
            <div class="detail-info-grid">
                <div class="detail-item">
                    <span class="detail-label">Nama Lengkap</span>
                    <span class="detail-value" id="detNama">-</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">NIK</span>
                    <span class="detail-value" id="detNik">-</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Tempat, Tanggal Lahir</span>
                    <span class="detail-value" id="detTtl">-</span>
                </div>
                <div class="detail-item">
                    <div style="display: flex; gap: 32px;">
                        <div>
                            <span class="detail-label">Agama</span>
                            <span class="detail-value" id="detAgama" style="text-transform: capitalize;">-</span>
                        </div>
                        <div>
                            <span class="detail-label">Gol. Darah</span>
                            <span class="detail-value" id="detGoldar">-</span>
                        </div>
                    </div>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Alamat Domisili</span>
                    <span class="detail-value" id="detAlamat" style="font-size: 13px; line-height: 1.4;">-</span>
                </div>
            </div>
            
            <button type="button" onclick="closeDetailModal()" class="modal-btn-close">Tutup Data</button>
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

        /* ============================================================
            MODAL DETAIL SISWA CONTROLLERS
        ============================================================ */
        const detModal = document.getElementById('detailModal');

        function openDetailModal(nama, nik, ttl, agama, goldar, alamat) {
            document.getElementById('detNama').textContent = nama;
            document.getElementById('detNik').textContent = nik;
            document.getElementById('detTtl').textContent = ttl;
            document.getElementById('detAgama').textContent = agama;
            document.getElementById('detGoldar').textContent = goldar;
            document.getElementById('detAlamat').textContent = alamat;
            detModal.classList.add('show');
        }

        function closeDetailModal() {
            detModal.classList.remove('show');
        }
    </script>
</body>
</html>