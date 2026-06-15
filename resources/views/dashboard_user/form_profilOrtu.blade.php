<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PORTAL SAKTI - Sistem Admisi Kanisius Terintegrasi</title>

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
            padding-bottom: 48px;
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
            border-radius: 16px; /* Menggunakan nilai konkrit agar langsung rounded sempurna */
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

        /* ===================== MAIN CARD CONTENT ===================== */
        .main-card {
            background: var(--surface);
            border-radius: 22px;
            border: 1px solid var(--border);
            padding: 40px 44px 44px;
            max-width: 896px;
            width: 100%;
            margin: 32px auto 0 auto;
            text-align: center;
            box-shadow: 0 4px 40px rgba(26, 42, 108, 0.07);
        }

        .avatar-container {
            background: #f0f5fa;
            width: 64px;
            height: 64px;
            border-radius: 20px;
            margin: 0 auto 16px auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-container i {
            color: var(--navy);
            font-size: 24px;
        }

        .main-title {
            color: var(--navy);
            font-size: 30px;
            font-weight: 900;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .main-subtitle {
            color: var(--muted);
            font-size: 14px;
            max-width: 448px;
            margin: 0 auto 40px auto;
            line-height: 1.6;
        }

        /* Form & Grid CSS Manual */
        .form-container {
            text-align: left;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        /* Indikator Tanda Bintang Merah untuk Required Field */
        .form-group.required .form-label::after {
            content: " *";
            color: var(--red);
        }

        .form-label {
            font-size: 11px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .select-wrapper {
            position: relative;
            width: 100%;
            display: block;
        }

        .form-control {
            width: 100%;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 14px 16px;
            font-size: 14px;
            font-weight: 600;
            color: var(--navy);
            outline: none;
            transition: border-color 0.2s;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        /* State jika input divalidasi kosong saat submit */
        .form-control.input-error {
            border-color: var(--red) !important;
            background: #fff5f5 !important;
        }

        .form-control:focus {
            border-color: var(--blue);
        }

        select.form-control {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            cursor: pointer;
            padding-right: 44px;
            position: relative;
        }

        .select-icon {
            position: absolute;
            top: 50%;
            right: 16px;
            transform: translateY(-50%);
            pointer-events: none;
            color: var(--navy);
            font-size: 12px;
            line-height: 1;
            z-index: 1;
        }

        textarea.form-control {
            resize: none;
            height: 96px;
            font-family: inherit;
        }

        .btn-group {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }

        .anak-btn {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
            background: var(--surface);
            border: 1px solid var(--border);
            color: var(--muted);
        }

        .anak-btn:hover {
            border-color: var(--navy);
            color: var(--navy);
        }

        .anak-btn.active {
            background: var(--navy);
            color: var(--gold);
            border: none;
        }

        /* Submit Action */
        .submit-container {
            padding-top: 24px;
            display: flex;
            justify-content: center;
        }

        .btn-submit {
            background: var(--navy);
            color: var(--surface);
            font-weight: bold;
            font-size: 14px;
            padding: 16px 32px;
            border-radius: 24px;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 10px 15px -3px rgba(26, 42, 108, 0.3);
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-submit:hover {
            background: #111c44;
            transform: translateY(-1px);
        }

        .btn-submit:disabled {
            opacity: 0.75;
            cursor: not-allowed;
            transform: none;
        }

        .btn-submit i {
            font-size: 12px;
        }

        /* ===================== CUSTOM POP-UP MODAL OVERLAY ===================== */
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
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            transform: scale(0.9);
            transition: transform 0.3s ease;
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

        .modal-btn-close:hover {
            background: #111c44;
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
            .main-card {
                padding: 32px 24px;
            }
        }

        @media (max-width: 768px) {
            .topbar {
                padding: 12px 20px;
            }
            .topbar-nav {
                gap: 16px;
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
                            <span class="uid-text">UID-{{ auth()->id() ?? 'parent' }}</span>
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
                    <a class="nav-link" href="{{ route('pusat_bantuan') }}"> Pusat Bantuan</a>
                </nav>

                <div class="topbar-right">
                    <div class="user-info">
                        <div class="user-name">{{ auth()->user()->name ?? 'Orang Tua' }}</div>
                        <div class="user-branch">Cabang Global</div>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <button type="button" class="btn-logout" title="Keluar" onclick="openLogoutModal()" style="border: none; background: none; cursor: pointer;">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </button>
                </div>
            </header>
        </div>
    </div>

        <main class="main-card">
            <div class="avatar-container">
                <i class="fa-regular fa-user"></i>
            </div>

            <h2 class="main-title">Profil Orang Tua</h2>
            <p class="main-subtitle">
                Lengkapi data pribadi Ayah/Bunda sebelum melanjutkan pendaftaran anak.
            </p>

            <!-- FORM VALIDATION MURNI -->
            <form id="formProfilOrtu" action="{{ route('profil.ortu.store') }}" method="POST" class="form-container" novalidate>
                @csrf

                @if ($errors->any())
                    <div style="background:#fee2e2;color:#991b1b;padding:12px 16px;border-radius:10px;margin-bottom:8px;">
                        <strong>Profil gagal disimpan:</strong>
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
                    <div style="background:#dcfce7;color:#166534;padding:12px 16px;border-radius:10px;margin-bottom:8px;">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('warning'))
                    <div style="background:#fef3c7;color:#92400e;padding:12px 16px;border-radius:10px;margin-bottom:8px;">
                        {{ session('warning') }}
                    </div>
                @endif

                @if (session('error'))
                    <div style="background:#fee2e2;color:#991b1b;padding:12px 16px;border-radius:10px;margin-bottom:8px;">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="form-grid">
                    <div class="form-group required">
                        <label class="form-label">Pendidikan Terakhir</label>
                        <div class="select-wrapper">
                            @php($pendidikanValue = old('pendidikan', $orangTua->pendidikan ?? 'S1'))
                            <select name="pendidikan" class="form-control" required>
                                <option value="SMA" {{ $pendidikanValue == 'SMA' ? 'selected' : '' }}>SMA / Sederajat</option>
                                <option value="D3" {{ $pendidikanValue == 'D3' ? 'selected' : '' }}>D3 / Diploma</option>
                                <option value="S1" {{ $pendidikanValue == 'S1' ? 'selected' : '' }}>S1 / Sarjana</option>
                                <option value="S2" {{ $pendidikanValue == 'S2' ? 'selected' : '' }}>S2 / Magister</option>
                                <option value="S3" {{ $pendidikanValue == 'S3' ? 'selected' : '' }}>S3 / Doktor</option>
                            </select>
                            <div class="select-icon"><i class="fa-solid fa-chevron-down"></i></div>
                        </div>
                    </div>

                    <div class="form-group required">
                        <label class="form-label">Rentang Penghasilan</label>
                        <div class="select-wrapper">
                            @php($penghasilanValue = old('penghasilan', $orangTua->gaji ?? ''))
                            <select name="penghasilan" class="form-control" required>
                                <option value="" {{ $penghasilanValue == '' ? 'selected' : '' }} disabled>Pilih Rentang Gaji</option>
                                <option value="4000000" {{ (string)$penghasilanValue == '4000000.00' || (string)$penghasilanValue == '4000000' ? 'selected' : '' }}>&lt; Rp 5.000.000</option>
                                <option value="7500000" {{ (string)$penghasilanValue == '7500000.00' || (string)$penghasilanValue == '7500000' ? 'selected' : '' }}>Rp 5.000.000 - Rp 10.000.000</option>
                                <option value="12000000" {{ (string)$penghasilanValue == '12000000.00' || (string)$penghasilanValue == '12000000' ? 'selected' : '' }}>&gt; Rp 10.000.000</option>
                            </select>
                            <div class="select-icon"><i class="fa-solid fa-chevron-down"></i></div>
                        </div>
                    </div>
                </div>

                <div class="form-grid">
                    <!-- Nomor Telepon -->
                    <div class="form-group required">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text"
                               name="nomor_telepon"
                               id="nomor_telepon"
                               class="form-control"
                               placeholder="Contoh: 081234567890"
                               maxlength="15"
                               value="{{ old('nomor_telepon', $orangTua->no_telp ?? '') }}"
                               required
                               autocomplete="off"
                               oninput="onlyDigitsPhone(this)">
                    </div>

                    <div class="form-group required">
                        <label class="form-label">Unit Sekolah Tujuan</label>
                        <div class="select-wrapper">
                            @php($unitValue = old('unit_sekolah', $orangTua->unit_sekolah ?? 'TK Wirobrajan'))
                            <select name="unit_sekolah" class="form-control" required>
                                <option value="TK Wirobrajan" {{ $unitValue == 'TK Wirobrajan' ? 'selected' : '' }}>TK Wirobrajan</option>
                                <option value="SD Kanisius" {{ $unitValue == 'SD Kanisius' ? 'selected' : '' }}>SD Kanisius Hati Kudus</option>
                            </select>
                            <div class="select-icon"><i class="fa-solid fa-chevron-down"></i></div>
                        </div>
                    </div>
                </div>

                <!-- Alamat Domisili Sesuai KTP -->
                <div class="form-group required">
                    <label class="form-label">Alamat Domisili Sesuai KTP</label>
                    <textarea name="alamat" id="alamat" class="form-control" placeholder="Masukkan alamat lengkap..." required>{{ old('alamat', $orangTua->alamat ?? '') }}</textarea>
                </div>

                <div class="submit-container">
                    <button type="submit" class="btn-submit">
                        <span>Simpan Profil & Mulai Form Siswa</span>
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>
            </form>
        </main>

    <!-- STRUCTURE CUSTOM POP-UP MODAL -->
    <div id="errorModal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-icon">
                <i class="fa-solid fa-circle-exclamation"></i>
            </div>
            <h3 class="modal-title">Data Belum Lengkap</h3>
            <p class="modal-desc">Mohon periksa kembali. Seluruh bidang data bertanda bintang (*) wajib diisi sebelum melanjutkan.</p>
            <button type="button" id="closeModalBtn" class="modal-btn-close">Mengerti</button>
        </div>
    </div>

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
        function onlyDigitsPhone(el) {
            el.value = el.value.replace(/\D/g, '');
            if (el.value.length >= 10 && el.value.length <= 15) {
                el.classList.remove('input-error');
            }
        }

        /* ============================================================
            TOAST UTILITIES
        ============================================================ */
        function showToast(msg, dur = 3000) {
            const t = document.getElementById('toast');
            if (!t) return;
            t.innerHTML = msg; // Menggunakan innerHTML agar tag ikon bisa dirender
            t.classList.add('show');
            clearTimeout(t._timer);
            t._timer = setTimeout(() => t.classList.remove('show'), dur);
        }

        /* ============================================================
            MODAL LOGOUT CONTROLLERS
        ============================================================ */
        const logModal = document.getElementById('logoutModal');

        function openLogoutModal() {
            logModal.classList.add('show');
        }

        function closeLogoutModal() {
            logModal.classList.remove('show');
        }

        function handleLogout() {
            closeLogoutModal();
            showToast('<i class="fas fa-arrow-right-from-bracket"></i> Mengakhiri Sesi...');
            
            setTimeout(() => {
                const logoutForm = document.getElementById('logout-form');
                if (logoutForm) logoutForm.submit();
            }, 800); 
        }

        document.addEventListener("DOMContentLoaded", function () {
            const buttons = document.querySelectorAll(".anak-btn");
            const jumlahAnakInput = document.getElementById("jumlah_anak");

            buttons.forEach(btn => {
                btn.addEventListener("click", function () {
                    buttons.forEach(b => b.classList.remove("active"));
                    this.classList.add("active");
                    if (jumlahAnakInput) jumlahAnakInput.value = this.dataset.val;
                });
            });

            const form = document.getElementById("formProfilOrtu");
            const modal = document.getElementById("errorModal");
            const closeModalBtn = document.getElementById("closeModalBtn");

            form.addEventListener("submit", function (event) {
                let isFormValid = true;
                const requiredFields = form.querySelectorAll("[required]");

                requiredFields.forEach(field => {
                    if (field.id === "nomor_telepon" && (field.value.length < 10 || field.value.length > 15)) {
                        isFormValid = false;
                        field.classList.add("input-error");
                    } else if (!field.value || field.value.trim() === "") {
                        isFormValid = false;
                        field.classList.add("input-error");
                    } else {
                        field.classList.remove("input-error");
                    }
                });

                if (!isFormValid) {
                    event.preventDefault();
                    modal.classList.add("show");
                    return;
                }

                const submitBtn = form.querySelector('.btn-submit');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span>Menyimpan...</span><i class="fa-solid fa-spinner fa-spin"></i>';
                }
            });

            closeModalBtn.addEventListener("click", function () {
                modal.classList.remove("show");
            });

            form.querySelectorAll("[required]").forEach(field => {
                const eventType = field.tagName === "SELECT" ? "change" : "input";
                field.addEventListener(eventType, function() {
                    if (this.id === "nomor_telepon" && this.value.length >= 10) {
                        this.classList.remove("input-error");
                    } else if (this.value && this.value.trim() !== "" && this.id !== "nomor_telepon") {
                        this.classList.remove("input-error");
                    }
                });
            });
        });
    </script>
</body>

</html>