<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAKTI Portal – SPMB Kanisius</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --navy: #122763;
            --navy-soft: #1b3a84;
            --blue: #004AAD;
            --gold: #f5b72a;
            --gold-dark: #d69000;
            --cream: #fff8e8;
            --bg: #f2f5fb;
            --surface: #ffffff;
            --text: #16213f;
            --muted: #6f7f98;
            --border: #dce5f2;
            --green: #16a34a;
            --red: #ef4444;
            --shadow: 0 22px 60px rgba(18, 39, 99, .14);
            --shadow-soft: 0 10px 28px rgba(18, 39, 99, .08);
            --radius-xl: 34px;
            --radius-md: 18px;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text);
            background:
                linear-gradient(rgba(18,39,99,.035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(18,39,99,.035) 1px, transparent 1px),
                radial-gradient(circle at 8% 12%, rgba(245,183,42,.34), transparent 28%),
                radial-gradient(circle at 92% 10%, rgba(0,74,173,.14), transparent 32%),
                linear-gradient(180deg, #ffffff 0%, #f3f6fc 48%, #ffffff 100%);
            background-size: 34px 34px, 34px 34px, auto, auto, auto;
            min-height: 100vh;
            overflow-x: hidden;
        }

        a { color: inherit; text-decoration: none; }
        .container { width: min(1180px, calc(100% - 40px)); margin: 0 auto; }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 40;
            background: rgba(255,255,255,.88);
            border-bottom: 1px solid rgba(220,229,242,.78);
            backdrop-filter: blur(16px);
        }

        .nav {
            min-height: 78px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 22px;
        }

        .brand { display: inline-flex; align-items: center; gap: 13px; min-width: 220px; }
        .brand img { width: 82px; height: auto; object-fit: contain; }
        .brand-name { font-size: 20px; line-height: 1; color: var(--navy); font-weight: 900; letter-spacing: .2px; }
        .brand-caption { margin-top: 5px; color: var(--muted); font-size: 10.5px; font-weight: 800; letter-spacing: .9px; text-transform: uppercase; }

        .nav-links { display: flex; align-items: center; gap: 7px; }
        .nav-links a {
            display: inline-flex;
            align-items: center;
            min-height: 36px;
            padding: 0 14px;
            border-radius: 999px;
            font-size: 12.5px;
            font-weight: 800;
            color: #5f6f8a;
            transition: .2s ease;
        }
        .nav-links a:hover, .nav-links a.active { background: #edf4ff; color: var(--navy); }

        .nav-actions { display: flex; align-items: center; gap: 10px; }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            border-radius: 999px;
            padding: 13px 20px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 900;
            border: 0;
            cursor: pointer;
            transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
            white-space: nowrap;
        }
        .btn:hover { transform: translateY(-2px); }
        .btn-primary { background: linear-gradient(135deg, var(--navy), var(--navy-soft)); color: #fff; box-shadow: 0 14px 28px rgba(18,39,99,.22); }
        .btn-gold { background: linear-gradient(135deg, #f8b21d, #ffd76d); color: #172554; box-shadow: 0 14px 28px rgba(245,183,42,.28); }
        .btn-light { background: #fff; color: var(--navy); border: 1px solid var(--border); box-shadow: var(--shadow-soft); }
        .btn-ghost { background: #edf4ff; color: var(--navy); border: 1px solid rgba(0,74,173,.10); }

        .hero { position: relative; padding: 58px 0 54px; }
        .hero-wrap {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(420px, .92fr);
            align-items: center;
            gap: 44px;
        }
        .hero-copy { position: relative; z-index: 2; }
        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 9px 14px;
            border-radius: 999px;
            background: rgba(255,255,255,.82);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-soft);
            color: var(--navy);
            font-size: 12px;
            font-weight: 900;
            margin-bottom: 22px;
        }
        .eyebrow i { color: var(--gold-dark); }
        .hero h1 {
            font-size: clamp(46px, 6vw, 78px);
            line-height: .96;
            letter-spacing: -2.4px;
            font-weight: 900;
            color: var(--navy);
            max-width: 720px;
            margin-bottom: 20px;
        }
        .hero h1 .gold { color: var(--gold-dark); }
        .hero h1 .blue { color: var(--blue); }
        .lead { color: #5f6f8a; font-size: 16px; line-height: 1.9; font-weight: 600; max-width: 660px; margin-bottom: 27px; }
        .hero-actions { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; margin-bottom: 24px; }
        .hero-notes { display: flex; align-items: center; gap: 16px; flex-wrap: wrap; color: #60708c; font-size: 12.5px; font-weight: 800; }
        .hero-notes span { display: inline-flex; align-items: center; gap: 7px; }
        .hero-notes i { color: var(--green); }

        .hero-art { position: relative; min-height: 470px; }
        .photo-ring {
            position: absolute;
            right: 0;
            top: 26px;
            width: min(520px, 100%);
            aspect-ratio: 1.08/1;
            border: 2px solid rgba(18,39,99,.78);
            border-radius: 48% 48% 20px 20px;
            padding: 16px;
            background: rgba(255,255,255,.72);
            box-shadow: var(--shadow);
        }
        .photo-ring::after {
            content: '';
            position: absolute;
            inset: 24px -14px -16px 34px;
            border-right: 2px solid rgba(18,39,99,.26);
            border-bottom: 2px solid rgba(18,39,99,.26);
            border-radius: 0 0 18px 0;
            z-index: -1;
        }
        .main-photo {
            width: 100%;
            height: 100%;
            border-radius: 46% 46% 14px 14px;
            object-fit: cover;
            object-position: center;
            display: block;
            filter: saturate(1.04) contrast(1.02);
        }
        .small-photo-card {
            position: absolute;
            left: 0;
            bottom: 14px;
            width: 240px;
            padding: 10px;
            border-radius: 24px;
            background: #fff;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-soft);
            transform: rotate(-4deg);
        }
        .small-photo-card img { width: 100%; height: 132px; object-fit: cover; border-radius: 18px; display: block; }
        .small-photo-card span { display: block; margin-top: 9px; color: var(--navy); font-size: 12px; font-weight: 900; text-align: center; }
        .decor-star {
            position: absolute;
            color: var(--gold);
            filter: drop-shadow(0 8px 14px rgba(214,144,0,.25));
            animation: floatY 3.5s ease-in-out infinite;
        }
        .star-1 { top: 16px; left: 28px; font-size: 36px; }
        .star-2 { top: 120px; right: 12px; font-size: 24px; animation-delay: .6s; }
        .star-3 { bottom: 116px; left: 258px; font-size: 30px; animation-delay: 1s; }
        .book-badge, .lamp-badge {
            position: absolute;
            display: grid;
            place-items: center;
            width: 76px;
            height: 76px;
            border-radius: 24px;
            background: #fff;
            color: var(--gold-dark);
            box-shadow: var(--shadow-soft);
            border: 1px solid var(--border);
            font-size: 34px;
        }
        .book-badge { left: 38px; bottom: 156px; transform: rotate(-12deg); }
        .lamp-badge { right: 6px; bottom: 90px; transform: rotate(8deg); }
        @keyframes floatY { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }

        .quick-stats { margin-top: -18px; position: relative; z-index: 3; }
        .stats-card {
            background: rgba(255,255,255,.9);
            border: 1px solid var(--border);
            border-radius: 28px;
            box-shadow: var(--shadow-soft);
            padding: 18px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }
        .stat-item { padding: 16px 18px; border-radius: 20px; background: #f8fbff; border: 1px solid #e7edf7; }
        .stat-item strong { display: block; font-size: 28px; color: var(--navy); font-weight: 900; line-height: 1; }
        .stat-item span { display: block; margin-top: 7px; color: var(--muted); font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: .7px; }
        .status-open strong { color: var(--green); }
        .status-closed strong { color: var(--red); }

        .section { padding: 74px 0; }
        .section-head { display: flex; align-items: end; justify-content: space-between; gap: 24px; margin-bottom: 26px; }
        .kicker { color: var(--gold-dark); font-size: 12px; font-weight: 900; letter-spacing: 1.4px; text-transform: uppercase; margin-bottom: 8px; }
        .section h2 { font-size: clamp(28px, 4vw, 44px); line-height: 1.12; color: var(--navy); font-weight: 900; letter-spacing: -1px; }
        .section-desc { color: #657690; line-height: 1.8; font-size: 15px; font-weight: 600; max-width: 620px; }

        .about-grid { display: grid; grid-template-columns: .9fr 1.1fr; gap: 24px; align-items: stretch; }
        .about-photo { overflow: hidden; border-radius: var(--radius-xl); border: 1px solid var(--border); box-shadow: var(--shadow-soft); background: #fff; min-height: 380px; }
        .about-photo img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .content-card { background: #fff; border: 1px solid var(--border); border-radius: var(--radius-xl); box-shadow: var(--shadow-soft); padding: 34px; }
        .content-card p { color: #657690; line-height: 1.85; font-size: 15px; font-weight: 600; margin-top: 12px; }
        .pill-list { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-top: 22px; }
        .pill { display: flex; align-items: center; gap: 12px; background: #f8fbff; border: 1px solid #e7edf7; padding: 14px; border-radius: 18px; color: var(--navy); font-weight: 900; font-size: 13px; }
        .pill i { width: 34px; height: 34px; display: grid; place-items: center; border-radius: 12px; background: #fff1cf; color: var(--gold-dark); }

        .program-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
        .program-card { position: relative; overflow: hidden; background: #fff; border: 1px solid var(--border); border-radius: 28px; box-shadow: var(--shadow-soft); padding: 26px; min-height: 228px; }
        .program-card::after { content: ''; position: absolute; right: -44px; bottom: -44px; width: 130px; height: 130px; border-radius: 999px; background: rgba(245,183,42,.16); }
        .program-icon { width: 54px; height: 54px; display: grid; place-items: center; border-radius: 18px; background: #edf4ff; color: var(--blue); font-size: 22px; margin-bottom: 18px; }
        .program-card h3 { color: var(--navy); font-size: 18px; font-weight: 900; margin-bottom: 10px; }
        .program-card p { color: #657690; font-size: 13.5px; line-height: 1.75; font-weight: 600; position: relative; z-index: 1; }

        .timeline { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; }
        .step { background: #fff; border: 1px solid var(--border); border-radius: 26px; padding: 24px; box-shadow: var(--shadow-soft); }
        .step-no { width: 42px; height: 42px; display: grid; place-items: center; border-radius: 16px; background: var(--navy); color: #fff; font-weight: 900; margin-bottom: 16px; }
        .step h3 { color: var(--navy); font-size: 16px; font-weight: 900; margin-bottom: 8px; }
        .step p { color: #657690; font-size: 13px; line-height: 1.7; font-weight: 600; }

        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
        .info-card { background: #fff; border: 1px solid var(--border); border-radius: var(--radius-xl); box-shadow: var(--shadow-soft); padding: 30px; }
        .batch-box { margin-top: 20px; display: grid; gap: 12px; }
        .batch-row { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 15px; border-radius: 18px; background: #f8fbff; border: 1px solid #e7edf7; }
        .batch-row strong { display: block; color: var(--navy); font-size: 13.5px; font-weight: 900; }
        .batch-row span { display: block; margin-top: 4px; color: var(--muted); font-size: 11.5px; font-weight: 700; }
        .tiny-pill { border-radius: 999px; padding: 7px 10px; font-size: 10px; font-weight: 900; white-space: nowrap; }
        .pill-on { background: #dcfce7; color: #15803d; }
        .pill-off { background: #eef2f7; color: #64748b; }
        .requirements { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-top: 18px; }
        .req { display: flex; gap: 12px; align-items: flex-start; padding: 14px; border-radius: 18px; background: #f8fbff; border: 1px solid #e7edf7; }
        .req i { color: var(--gold-dark); margin-top: 2px; }
        .req strong { display: block; color: var(--navy); font-size: 13px; font-weight: 900; }
        .req small { display: block; margin-top: 4px; color: var(--muted); line-height: 1.45; font-weight: 700; }

        .help-band { background: linear-gradient(135deg, var(--navy), #173a86); border-radius: var(--radius-xl); box-shadow: var(--shadow); padding: 34px; color: #fff; display: grid; grid-template-columns: 1.2fr .8fr; gap: 24px; align-items: center; overflow: hidden; position: relative; }
        .help-band::after { content: ''; position: absolute; right: -90px; top: -120px; width: 270px; height: 270px; border-radius: 50%; background: rgba(245,183,42,.25); }
        .help-band h2 { color: #fff; font-size: clamp(26px, 4vw, 42px); }
        .help-band p { color: rgba(255,255,255,.78); line-height: 1.8; font-weight: 600; margin-top: 10px; max-width: 680px; }
        .help-actions { display: flex; justify-content: flex-end; gap: 12px; flex-wrap: wrap; position: relative; z-index: 1; }

        footer { padding: 34px 0; color: #71819d; font-size: 12px; font-weight: 800; }
        .footer-inner { display: flex; justify-content: space-between; align-items: center; gap: 16px; border-top: 1px solid var(--border); padding-top: 24px; }
        .footer-links { display: flex; gap: 16px; }

        @media (max-width: 980px) {
            .nav { align-items: flex-start; padding: 16px 0; flex-direction: column; }
            .nav-links { width: 100%; overflow-x: auto; padding-bottom: 4px; }
            .nav-actions { width: 100%; }
            .hero-wrap, .about-grid, .info-grid, .help-band { grid-template-columns: 1fr; }
            .hero-art { min-height: 560px; }
            .photo-ring { left: 50%; right: auto; transform: translateX(-50%); }
            .stats-card { grid-template-columns: repeat(2, 1fr); }
            .program-grid, .timeline { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 640px) {
            .container { width: min(100% - 28px, 1180px); }
            .hero { padding-top: 34px; }
            .hero h1 { font-size: 42px; letter-spacing: -1.4px; }
            .lead { font-size: 14.5px; }
            .hero-art { min-height: 420px; }
            .photo-ring { width: 96%; top: 20px; }
            .small-photo-card { width: 190px; bottom: 0; }
            .small-photo-card img { height: 100px; }
            .book-badge, .lamp-badge { width: 58px; height: 58px; font-size: 26px; border-radius: 18px; }
            .book-badge { left: 12px; bottom: 120px; }
            .lamp-badge { right: 0; bottom: 64px; }
            .stats-card, .program-grid, .timeline, .pill-list, .requirements { grid-template-columns: 1fr; }
            .section { padding: 52px 0; }
            .section-head { flex-direction: column; align-items: flex-start; }
            .content-card, .info-card, .help-band { padding: 24px; border-radius: 26px; }
            .footer-inner { align-items: flex-start; flex-direction: column; }
        }
    </style>
</head>
<body>
    @php
        $landingInfo = $landingInfo ?? [];
        $batch = $landingInfo['batch'] ?? null;
        $batchList = $landingInfo['batch_list'] ?? collect();
        $totalPendaftar = $landingInfo['total_pendaftar'] ?? 0;
        $approved = $landingInfo['approved'] ?? 0;
        $proses = $landingInfo['proses'] ?? 0;
        $sisaKuota = $landingInfo['sisa_kuota'] ?? 0;
        $isOpen = $landingInfo['is_open'] ?? false;
    @endphp

    <header class="topbar">
        <div class="container">
            <nav class="nav">
                <a href="{{ route('landing') }}" class="brand" aria-label="SAKTI Portal">
                    <img src="{{ asset('img/E-Kanisius 1.png') }}" alt="Logo Kanisius">
                    <div>
                        <div class="brand-name">SAKTI Portal</div>
                        <div class="brand-caption">SPMB Kanisius Terintegrasi</div>
                    </div>
                </a>

                <div class="nav-links" aria-label="Navigasi utama">
                    <a href="#home" class="active">Home</a>
                    <a href="#tentang">Tentang</a>
                    <a href="#program">Program</a>
                    <a href="#alur">Alur</a>
                    <a href="#informasi">Informasi</a>
                    <a href="#bantuan">Bantuan</a>
                </div>

                <div class="nav-actions">
                    <a href="{{ route('login') }}" class="btn btn-ghost"><i class="fa-solid fa-right-to-bracket"></i> Masuk Portal</a>
                    <a href="{{ route('register') }}" class="btn btn-primary"><i class="fa-solid fa-user-plus"></i> Buat Akun</a>
                </div>
            </nav>
        </div>
    </header>

    <main id="home">
        <section class="hero">
            <div class="container hero-wrap">
                <div class="hero-copy">
                    <div class="eyebrow"><i class="fa-solid fa-graduation-cap"></i> Sistem Penerimaan Murid Baru</div>
                    <h1>Belajar, Bertumbuh, <span class="blue">dan</span> <span class="gold">Berkarakter.</span></h1>
                    <p class="lead">
                        SAKTI Portal membantu proses pendaftaran calon siswa Kanisius menjadi lebih rapi: mulai dari pembuatan akun, pengisian data, unggah berkas, pemantauan status, sampai informasi tagihan admisi.
                    </p>
                    <div class="hero-actions">
                        <a href="{{ route('login') }}" class="btn btn-gold"><i class="fa-solid fa-paper-plane"></i> Daftar / Masuk Portal</a>
                        <a href="#alur" class="btn btn-light"><i class="fa-solid fa-circle-play"></i> Lihat Alur</a>
                    </div>
                    <div class="hero-notes">
                        <span><i class="fa-solid fa-circle-check"></i> Pendaftaran online</span>
                        <span><i class="fa-solid fa-circle-check"></i> Verifikasi berkas</span>
                        <span><i class="fa-solid fa-circle-check"></i> Invoice digital</span>
                    </div>
                </div>

                <div class="hero-art" aria-label="Kegiatan siswa Kanisius">
                    <i class="fa-solid fa-star decor-star star-1"></i>
                    <i class="fa-solid fa-star decor-star star-2"></i>
                    <i class="fa-solid fa-star decor-star star-3"></i>
                    <div class="photo-ring">
                        <img src="{{ asset('img/landing/kegiatan-kanisius.png') }}" alt="Kegiatan bersama siswa Kanisius" class="main-photo">
                    </div>
                    <div class="small-photo-card">
                        <img src="{{ asset('img/landing/karya-siswa.png') }}" alt="Kegiatan karya siswa">
                        <span>Kegiatan Kreatif Siswa</span>
                    </div>
                    <div class="book-badge"><i class="fa-solid fa-book-open-reader"></i></div>
                    <div class="lamp-badge"><i class="fa-solid fa-lightbulb"></i></div>
                </div>
            </div>
        </section>

        <section class="quick-stats">
            <div class="container">
                <div class="stats-card">
                    <div class="stat-item {{ $isOpen ? 'status-open' : 'status-closed' }}">
                        <strong>{{ $isOpen ? 'Buka' : 'Tutup' }}</strong>
                        <span>Status Pendaftaran</span>
                    </div>
                    <div class="stat-item">
                        <strong>{{ number_format($totalPendaftar, 0, ',', '.') }}</strong>
                        <span>Total Pendaftar</span>
                    </div>
                    <div class="stat-item">
                        <strong>{{ number_format($approved, 0, ',', '.') }}</strong>
                        <span>Sudah Diterima</span>
                    </div>
                    <div class="stat-item">
                        <strong>{{ number_format($sisaKuota, 0, ',', '.') }}</strong>
                        <span>Sisa Kuota</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="section" id="tentang">
            <div class="container about-grid">
                <div class="about-photo">
                    <img src="{{ asset('img/landing/karya-siswa.png') }}" alt="Aktivitas belajar siswa Kanisius">
                </div>
                <div class="content-card">
                    <div class="kicker">Tentang SAKTI Portal</div>
                    <h2>Portal admisi yang memudahkan orang tua dan sekolah.</h2>
                    <p>
                        Melalui SAKTI Portal, proses pendaftaran tidak lagi tersebar di banyak tempat. Orang tua dapat melengkapi data calon siswa, mengunggah dokumen, memantau status verifikasi, dan memperoleh informasi admisi secara lebih tertata.
                    </p>
                    <div class="pill-list">
                        <div class="pill"><i class="fa-solid fa-shield-halved"></i> Data lebih aman</div>
                        <div class="pill"><i class="fa-solid fa-clock"></i> Proses lebih cepat</div>
                        <div class="pill"><i class="fa-solid fa-folder-open"></i> Berkas terpusat</div>
                        <div class="pill"><i class="fa-solid fa-chart-line"></i> Status transparan</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section" id="program">
            <div class="container">
                <div class="section-head">
                    <div>
                        <div class="kicker">Program Layanan</div>
                        <h2>Semua kebutuhan admisi dalam satu alur.</h2>
                    </div>
                    <p class="section-desc">Menu dan informasi disesuaikan dengan kebutuhan pendaftaran siswa baru Kanisius.</p>
                </div>

                <div class="program-grid">
                    <article class="program-card">
                        <div class="program-icon"><i class="fa-solid fa-user-pen"></i></div>
                        <h3>Form Pendaftaran</h3>
                        <p>Orang tua mengisi identitas calon siswa, data keluarga, dan informasi pendukung admisi.</p>
                    </article>
                    <article class="program-card">
                        <div class="program-icon"><i class="fa-solid fa-file-circle-check"></i></div>
                        <h3>Unggah Berkas</h3>
                        <p>Dokumen seperti KK, akta, KTP orang tua, pas foto, dan berkas pendukung dapat diunggah secara digital.</p>
                    </article>
                    <article class="program-card">
                        <div class="program-icon"><i class="fa-solid fa-receipt"></i></div>
                        <h3>Invoice Admisi</h3>
                        <p>Informasi tagihan admisi tersedia setelah proses pendaftaran dan verifikasi dinyatakan selesai.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="section" id="alur">
            <div class="container">
                <div class="section-head">
                    <div>
                        <div class="kicker">Alur Pendaftaran</div>
                        <h2>Empat langkah sederhana untuk mulai mendaftar.</h2>
                    </div>
                    <p class="section-desc">Jika sudah memiliki akun, orang tua cukup masuk ke portal. Pengguna baru dapat membuat akun terlebih dahulu melalui halaman register.</p>
                </div>

                <div class="timeline">
                    <div class="step">
                        <div class="step-no">01</div>
                        <h3>Masuk atau Buat Akun</h3>
                        <p>Gunakan halaman login. Pengguna baru dapat memilih register untuk membuat akun orang tua.</p>
                    </div>
                    <div class="step">
                        <div class="step-no">02</div>
                        <h3>Lengkapi Profil</h3>
                        <p>Isi data orang tua sebagai penanggung jawab pendaftaran calon siswa.</p>
                    </div>
                    <div class="step">
                        <div class="step-no">03</div>
                        <h3>Isi Form & Berkas</h3>
                        <p>Lengkapi data calon siswa dan unggah dokumen sesuai persyaratan.</p>
                    </div>
                    <div class="step">
                        <div class="step-no">04</div>
                        <h3>Pantau Status</h3>
                        <p>Lihat status proses, diterima, ditolak, atau perbaikan berkas melalui portal orang tua.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="section" id="informasi">
            <div class="container info-grid">
                <div class="info-card">
                    <div class="kicker">Informasi Gelombang</div>
                    <h2>Jadwal dan kuota pendaftaran.</h2>
                    <p class="section-desc" style="margin-top:12px;">Informasi berikut mengikuti data gelombang yang tersedia pada sistem.</p>

                    <div class="batch-box">
                        @forelse($batchList as $item)
                            <div class="batch-row">
                                <div>
                                    <strong>{{ $item->nama_batch ?? 'Gelombang Pendaftaran' }}</strong>
                                    <span>{{ $item->tanggal_buka ?? '-' }} – {{ $item->tanggal_tutup ?? '-' }} · Kuota {{ $item->kuota ?? 0 }}</span>
                                </div>
                                <div class="tiny-pill {{ (int)($item->is_active ?? 0) === 1 ? 'pill-on' : 'pill-off' }}">
                                    {{ (int)($item->is_active ?? 0) === 1 ? 'Buka' : 'Tutup' }}
                                </div>
                            </div>
                        @empty
                            <div class="batch-row">
                                <div>
                                    <strong>Jadwal belum tersedia</strong>
                                    <span>Informasi gelombang pendaftaran akan diumumkan melalui portal.</span>
                                </div>
                                <div class="tiny-pill pill-off">Info</div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="info-card">
                    <div class="kicker">Persyaratan Berkas</div>
                    <h2>Siapkan dokumen sebelum mengisi form.</h2>
                    <div class="requirements">
                        <div class="req"><i class="fa-solid fa-house-user"></i><div><strong>Kartu Keluarga</strong><small>Dokumen keluarga calon siswa.</small></div></div>
                        <div class="req"><i class="fa-solid fa-certificate"></i><div><strong>Akta Kelahiran</strong><small>Identitas resmi calon siswa.</small></div></div>
                        <div class="req"><i class="fa-solid fa-id-card"></i><div><strong>KTP Orang Tua</strong><small>Identitas penanggung jawab.</small></div></div>
                        <div class="req"><i class="fa-solid fa-image"></i><div><strong>Pas Foto</strong><small>Foto terbaru calon siswa.</small></div></div>
                        <div class="req"><i class="fa-solid fa-cross"></i><div><strong>Surat Baptis</strong><small>Jika tersedia atau diminta.</small></div></div>
                        <div class="req"><i class="fa-solid fa-phone"></i><div><strong>Kontak Aktif</strong><small>Nomor yang dapat dihubungi.</small></div></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section" id="bantuan">
            <div class="container">
                <div class="help-band">
                    <div>
                        <div class="kicker" style="color:#ffd76d;">Pusat Bantuan</div>
                        <h2>Butuh bantuan saat proses pendaftaran?</h2>
                        <p>Gunakan halaman login untuk masuk ke portal. Jika belum memiliki akun, pilih register untuk membuat akun orang tua. Simpan email dan password agar status pendaftaran dapat dipantau kembali.</p>
                    </div>
                    <div class="help-actions">
                        <a href="{{ route('login') }}" class="btn btn-gold"><i class="fa-solid fa-right-to-bracket"></i> Masuk Portal</a>
                        <a href="{{ route('register') }}" class="btn btn-light"><i class="fa-solid fa-user-plus"></i> Buat Akun</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container footer-inner">
            <div>Yayasan Kanisius © 2026 · SAKTI Portal SPMB</div>
            <div class="footer-links">
                <a href="#tentang">Tentang</a>
                <a href="#informasi">Informasi</a>
                <a href="#bantuan">Bantuan</a>
            </div>
        </div>
    </footer>
</body>
</html>
