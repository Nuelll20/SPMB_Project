<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAKTI Portal – Riwayat Pendaftaran</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --navy: #002B5B;
            --navy-dark: #001F42;
            --blue: #004AAD;
            --gold: #E5A93C;
            --gold-light: #FFF8E7;
            --gold-border: #FCE8BD;
            --bg: #F4F7FA;
            --surface: #ffffff;
            --surface2: #F4F7FA;
            --border: #e4eaf2;
            --text-dark: #002B5B;
            --text-gray: #73829a;
            --green: #16a34a;
            --green-bg: #eaf9f1;
            --red: #dc2626;
            --red-bg: #fff0f0;
            --orange: #f97316;
            --orange-bg: #fff7ed;
            --blue-bg: #e8f0fe;
            --radius-sm: 16px;
            --radius-md: 22px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

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

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

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

        .topbar-brand { display: flex; align-items: center; gap: 12px; }
        .brand-title { font-size: 16px; font-weight: 900; color: var(--text-dark); letter-spacing: 0.5px; line-height: 1.2; }
        .brand-meta { display: flex; align-items: center; gap: 6px; margin-top: 2px; }
        .badge-parent { background: var(--gold-light); color: var(--gold); border: 1px solid var(--gold-border); font-size: 9px; font-weight: 800; padding: 1px 6px; border-radius: 99px; text-transform: uppercase; display: inline-flex; align-items: center; gap: 3px; }
        .uid-text { font-family: 'DM Mono', monospace; font-size: 9px; color: #94a3b8; }
        .brand-logo-box { width: 44px; height: 44px; background: var(--navy); border-radius: 12px; display: flex; align-items: center; justify-content: center; }
        .brand-logo-box i { color: #fff; font-size: 20px; }

        .topbar-nav { display: flex; align-items: center; gap: 28px; }
        .nav-link { display: flex; align-items: center; gap: 8px; text-decoration: none; color: var(--text-gray); font-size: 13.5px; font-weight: 700; transition: color .2s ease; }
        .nav-link:hover, .nav-link.active { color: var(--navy); }
        .nav-dot { width: 5px; height: 5px; background: var(--gold); border-radius: 50%; display: inline-block; }

        .topbar-right { display: flex; align-items: center; gap: 16px; }
        .user-info { text-align: right; line-height: 1.3; }
        .user-name { font-size: 13.5px; font-weight: 800; color: var(--text-dark); }
        .user-branch { font-size: 9.5px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: .5px; }
        .btn-logout { width: 38px; height: 38px; background: #fff0f0; border: none; border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all .2s ease; }
        .btn-logout:hover { background: #ffe0e0; transform: scale(1.05); }
        .btn-logout i { color: #ff4d4d; font-size: 14px; }

        .main-wrapper { padding: 32px 0; flex: 1; }
        .dashboard-card {
            background: var(--surface);
            border-radius: var(--radius-md);
            padding: 36px 40px 42px;
            box-shadow: 0 4px 40px rgba(26, 42, 108, 0.07);
            border: 1px solid var(--border);
            opacity: 0;
            animation: fadeUp .55s cubic-bezier(.16, 1, .3, 1) .08s forwards;
        }

        .page-title-row { display: flex; justify-content: space-between; align-items: flex-start; gap: 20px; flex-wrap: wrap; margin-bottom: 24px; }
        .page-kicker { font-size: 12px; font-weight: 900; color: var(--text-gray); letter-spacing: 1.2px; text-transform: uppercase; margin-bottom: 6px; }
        .page-title { font-size: 30px; font-weight: 900; color: var(--text-dark); letter-spacing: -0.7px; }
        .page-desc { font-size: 13px; color: var(--text-gray); font-weight: 600; margin-top: 6px; }

        .summary-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px; margin-bottom: 22px; }
        .summary-card { background: #f8fafc; border: 1px solid var(--border); border-radius: 18px; padding: 16px; }
        .summary-label { font-size: 10px; font-weight: 900; color: var(--text-gray); text-transform: uppercase; letter-spacing: .9px; margin-bottom: 8px; }
        .summary-value { font-size: 24px; font-weight: 900; color: var(--navy); }
        .summary-card.approved { background: var(--green-bg); }
        .summary-card.approved .summary-value { color: var(--green); }
        .summary-card.rejected { background: var(--red-bg); }
        .summary-card.rejected .summary-value { color: var(--red); }
        .summary-card.proses { background: var(--orange-bg); }
        .summary-card.proses .summary-value { color: var(--orange); }

        .filter-card { background: #f8fafc; border: 1px solid var(--border); border-radius: 18px; padding: 14px; margin-bottom: 22px; }
        .filter-form { display: grid; grid-template-columns: 1.4fr 1fr 1fr auto auto; gap: 10px; align-items: center; }
        .filter-control { width: 100%; border: 1px solid #dbe3ee; border-radius: 13px; padding: 12px 13px; font-family: inherit; font-size: 12.5px; font-weight: 700; color: #334155; background: #fff; outline: none; }
        .filter-control:focus { border-color: rgba(0, 74, 173, .45); box-shadow: 0 0 0 3px rgba(0, 74, 173, .08); }
        .btn-filter, .btn-reset { border: none; border-radius: 13px; padding: 12px 16px; font-family: inherit; font-size: 12px; font-weight: 900; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px; white-space: nowrap; }
        .btn-filter { background: var(--navy); color: #fff; }
        .btn-reset { background: #eef2f7; color: #516178; }

        .history-table-wrap { border: 1px solid var(--border); border-radius: 18px; overflow: hidden; background: #fff; }
        .history-table { width: 100%; border-collapse: collapse; }
        .history-table thead { background: #f8fafc; }
        .history-table th { padding: 14px 16px; text-align: left; font-size: 10.5px; font-weight: 900; color: #8ba0bb; text-transform: uppercase; letter-spacing: .8px; border-bottom: 1px solid var(--border); }
        .history-table td { padding: 16px; font-size: 12.5px; font-weight: 650; color: #334155; border-bottom: 1px solid #eef2f6; vertical-align: middle; }
        .history-table tbody tr:hover { background: #fbfdff; }
        .history-table tbody tr:last-child td { border-bottom: none; }
        .student-name { font-size: 13.5px; font-weight: 900; color: var(--navy); margin-bottom: 4px; }
        .mini-text { font-size: 11px; color: #8ba0bb; font-family: 'DM Mono', monospace; font-weight: 600; }
        .date-main { color: #334155; font-weight: 800; }
        .date-sub { display: block; margin-top: 3px; font-size: 10.5px; color: #94a3b8; font-weight: 700; }
        .batch-pill { display: inline-flex; align-items: center; gap: 6px; background: #edf4ff; color: var(--blue); border-radius: 999px; padding: 7px 10px; font-size: 11px; font-weight: 900; }
        .badge-status-pill { border: none; border-radius: 999px; padding: 7px 12px; font-size: 10.5px; font-weight: 900; text-transform: uppercase; letter-spacing: .6px; display: inline-flex; align-items: center; gap: 6px; }
        .badge-status-pill::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: currentColor; }
        .status-approved { background: var(--green-bg); color: var(--green); }
        .status-rejected { background: var(--red-bg); color: var(--red); }
        .status-pending { background: var(--orange-bg); color: var(--orange); }
        .status-draft { background: #eef2f7; color: #64748b; }
        .invoice-total { font-weight: 900; color: var(--navy); }
        .invoice-empty { color: #94a3b8; font-size: 11px; font-weight: 750; }
        .reason-text { max-width: 200px; color: #64748b; line-height: 1.35; }
        .btn-detail { width: 36px; height: 36px; border: 1px solid #dbe3ee; background: #fff; color: var(--navy); border-radius: 11px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; transition: .2s; }
        .btn-detail:hover { background: var(--navy); color: #fff; border-color: var(--navy); transform: translateY(-1px); }

        .empty-state { text-align: center; padding: 48px 24px; color: var(--text-gray); }
        .empty-state i { font-size: 34px; margin-bottom: 12px; color: #94a3b8; display: block; }
        .empty-state p { font-size: 14px; font-weight: 700; }

        .modal-overlay { position: fixed; inset: 0; background: rgba(26, 42, 108, .4); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; z-index: 1000; opacity: 0; pointer-events: none; transition: opacity .25s ease; padding: 18px; }
        .modal-overlay.show { opacity: 1; pointer-events: auto; }
        .modal-box { background: #fff; padding: 28px; border-radius: 24px; max-width: 560px; width: 100%; box-shadow: 0 20px 25px -5px rgba(0,0,0,.1); transform: scale(.94); transition: transform .25s ease; position: relative; }
        .modal-overlay.show .modal-box { transform: scale(1); }
        .modal-close { position: absolute; top: 16px; right: 16px; width: 34px; height: 34px; border: none; border-radius: 50%; background: #f1f5f9; color: #64748b; display: flex; align-items: center; justify-content: center; font-size: 15px; cursor: pointer; transition: .2s ease; }
        .modal-close:hover { background: #fee2e2; color: #ef4444; }
        .modal-title { font-size: 18px; font-weight: 900; color: var(--navy); margin-bottom: 6px; padding-right: 36px; }
        .modal-desc { font-size: 13px; color: var(--text-gray); line-height: 1.5; margin-bottom: 18px; }
        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px; }
        .detail-item { background: #f8fafc; border: 1px solid var(--border); border-radius: 14px; padding: 13px; }
        .detail-item.full { grid-column: 1 / -1; }
        .detail-label { display: block; font-size: 9.5px; font-weight: 900; text-transform: uppercase; color: #8ba0bb; letter-spacing: .7px; margin-bottom: 5px; }
        .detail-value { font-size: 13px; font-weight: 800; color: var(--navy); line-height: 1.35; }
        .modal-btn-close { background: var(--navy); color: #fff; border: none; padding: 12px 24px; border-radius: 12px; font-weight: 800; font-size: 14px; cursor: pointer; width: 100%; transition: background .2s; }
        .modal-btn-close:hover { background: var(--navy-dark); }
        .modal-btn-group { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .modal-btn-cancel { background: var(--surface2); color: #334155; border: 1px solid var(--border); }

        #toast { position: fixed; bottom: 30px; right: 30px; background: var(--navy); color: white; padding: 14px 28px; border-radius: 12px; font-size: 13.5px; font-weight: 600; opacity: 0; pointer-events: none; transform: translateX(30px); transition: transform .4s cubic-bezier(.22,1,.36,1), opacity .4s; z-index: 9999; box-shadow: 0 10px 25px -5px rgba(26,42,108,.3); display: flex; align-items: center; gap: 10px; }
        #toast.show { opacity: 1; transform: translateX(0); }
        .page-footer { text-align: center; padding: 24px; font-size: 10.5px; font-weight: 700; color: #a4b2c6; letter-spacing: 1.5px; text-transform: uppercase; margin-top: auto; }

        @media (max-width: 1000px) {
            .summary-grid { grid-template-columns: repeat(2, 1fr); }
            .filter-form { grid-template-columns: 1fr 1fr; }
            .history-table-wrap { overflow-x: auto; }
            .history-table { min-width: 920px; }
        }

        @media (max-width: 640px) {
            .topbar { flex-direction: column; gap: 14px; padding: 16px; text-align: center; }
            .topbar-brand { flex-direction: column; gap: 4px; }
            .topbar-nav { width: 100%; justify-content: center; gap: 16px; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); padding: 8px 0; }
            .topbar-right { width: 100%; justify-content: space-between; }
            .user-info { text-align: left; }
            .dashboard-card { padding: 28px 18px 32px; }
            .page-title { font-size: 25px; }
            .summary-grid, .filter-form, .detail-grid { grid-template-columns: 1fr; }
            #toast { left: 20px; right: 20px; bottom: 20px; transform: translateY(30px); text-align: center; justify-content: center; }
            #toast.show { transform: translateY(0); }
        }
    </style>
</head>

<body>
    @php
        $summary = $summary ?? [
            'total' => 0,
            'approved' => 0,
            'rejected' => 0,
            'proses' => 0,
            'total_tagihan' => 0,
        ];

        $fmtDate = function ($value, $withTime = false) {
            if (empty($value)) {
                return '-';
            }

            try {
                return \Carbon\Carbon::parse($value)->format($withTime ? 'd/m/Y H:i' : 'd/m/Y');
            } catch (\Throwable $e) {
                return '-';
            }
        };

        $fmtMoney = function ($value) {
            $number = (float) ($value ?? 0);
            return $number > 0 ? 'Rp ' . number_format($number, 0, ',', '.') : '-';
        };
    @endphp

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
                            <span class="uid-text">UID-{{ auth()->id() ?? 'GUEST' }}</span>
                        </div>
                    </div>
                </div>

                <nav class="topbar-nav">
                    <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    <a class="nav-link active" href="{{ route('riwayat') }}">Riwayat <span class="nav-dot"></span></a>
                    <a class="nav-link" href="{{ route('pusat_bantuan') }}">Pusat Bantuan</a>
                </nav>

                <div class="topbar-right">
                    <div class="user-info">
                        <div class="user-name">{{ auth()->user()->name ?? 'Orang Tua' }}</div>
                        <div class="user-branch">Cabang Global</div>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <button type="button" class="btn-logout" title="Keluar" onclick="openLogoutModal()" style="border: none; cursor: pointer;">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </button>
                </div>
            </header>
        </div>
    </div>

    <main class="main-wrapper">
        <div class="container">
            <div class="dashboard-card">
                <div class="page-title-row">
                    <div>
                        <div class="page-kicker"><i class="fa-solid fa-clock-rotate-left"></i> Riwayat Verifikasi</div>
                        <h1 class="page-title">Riwayat Pendaftaran Siswa</h1>
                        <p class="page-desc">Data submit, keputusan admin, batch/gelombang, dan nominal invoice admisi.</p>
                    </div>
                </div>

                @if (session('success'))
                    <div style="background:#dcfce7;color:#166534;padding:12px 16px;border-radius:12px;margin-bottom:18px;font-size:13px;font-weight:700;">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('warning'))
                    <div style="background:#fef3c7;color:#92400e;padding:12px 16px;border-radius:12px;margin-bottom:18px;font-size:13px;font-weight:700;">
                        {{ session('warning') }}
                    </div>
                @endif

                @if (session('error'))
                    <div style="background:#fee2e2;color:#991b1b;padding:12px 16px;border-radius:12px;margin-bottom:18px;font-size:13px;font-weight:700;">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="summary-grid">
                    <div class="summary-card">
                        <div class="summary-label">Total Data</div>
                        <div class="summary-value">{{ $summary['total'] ?? 0 }}</div>
                    </div>
                    <div class="summary-card approved">
                        <div class="summary-label">Approved</div>
                        <div class="summary-value">{{ $summary['approved'] ?? 0 }}</div>
                    </div>
                    <div class="summary-card rejected">
                        <div class="summary-label">Rejected</div>
                        <div class="summary-value">{{ $summary['rejected'] ?? 0 }}</div>
                    </div>
                    <div class="summary-card proses">
                        <div class="summary-label">Proses</div>
                        <div class="summary-value">{{ $summary['proses'] ?? 0 }}</div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-label">Total Invoice</div>
                        <div class="summary-value" style="font-size:18px;">{{ $fmtMoney($summary['total_tagihan'] ?? 0) }}</div>
                    </div>
                </div>

                <div class="filter-card">
                    <form action="{{ route('riwayat') }}" method="GET" class="filter-form">
                        <input type="text" name="q" value="{{ request('q') }}" class="filter-control" placeholder="Cari nama, NIK, atau nomor registrasi...">

                        <select name="batch" class="filter-control">
                            <option value="">Semua Gelombang / Batch</option>
                            @foreach($batchList as $batch)
                                <option value="{{ $batch->uid }}" {{ (string) request('batch') === (string) $batch->uid ? 'selected' : '' }}>
                                    {{ $batch->nama_batch ?? ('Gelombang ' . $batch->uid) }}
                                </option>
                            @endforeach
                        </select>

                        <select name="status" class="filter-control">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Proses</option>
                            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>

                        <button type="submit" class="btn-filter"><i class="fa-solid fa-filter"></i> Sortir</button>
                        <a href="{{ route('riwayat') }}" class="btn-reset"><i class="fa-solid fa-rotate-left"></i> Reset</a>
                    </form>
                </div>

                <div class="history-table-wrap">
                    <table class="history-table">
                        <thead>
                            <tr>
                                <th style="width:44px;">#</th>
                                <th>Nama Peserta</th>
                                <th>Gelombang</th>
                                <th>Tanggal Submit</th>
                                <th>Keputusan Admin</th>
                                <th>Status</th>
                                <th>Nominal Invoice</th>
                                <th>Catatan</th>
                                <th style="text-align:center;">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dataSiswa as $index => $siswa)
                                @php
                                    $tanggalSubmit = $fmtDate($siswa->tanggal_submit_final ?? null);
                                    $tanggalVerifikasi = $fmtDate($siswa->tanggal_verifikasi_final ?? null, true);
                                    $hasTanggalVerifikasi = !empty($siswa->tanggal_verifikasi_final);
                                    $isApproved = ($siswa->status_norm ?? '') === 'approved';
                                    $isRejected = ($siswa->status_norm ?? '') === 'rejected';
                                    $invoiceText = $isApproved && ($siswa->total_tagihan_final ?? 0) > 0 ? $fmtMoney($siswa->total_tagihan_final) : '-';
                                    $invoiceInfo = $isApproved
                                        ? (($siswa->nomor_tagihan ?? null) ? $siswa->nomor_tagihan : 'Invoice belum dibuat')
                                        : 'Tidak tersedia';
                                    $catatan = $isRejected
                                        ? ($siswa->alasan_penolakan ?? '-')
                                        : ($isApproved ? 'Berkas diterima oleh admin.' : 'Menunggu proses verifikasi admin.');
                                    $ttl = trim(($siswa->tempat_lahir ?? '-') . ', ' . $fmtDate($siswa->tanggal_lahir ?? null));
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <div class="student-name">{{ $siswa->nama ?? '-' }}</div>
                                        <div class="mini-text">{{ $siswa->nomor_registrasi_final ?? '-' }}</div>
                                        <div class="mini-text">NIK: {{ $siswa->nik ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <span class="batch-pill"><i class="fa-solid fa-layer-group"></i> {{ $siswa->nama_batch_final ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <span class="date-main">{{ $tanggalSubmit }}</span>
                                        <span class="date-sub">Form dikirim</span>
                                    </td>
                                    <td>
                                        @if($isApproved || $isRejected)
                                            <span class="date-main">{{ $hasTanggalVerifikasi ? $tanggalVerifikasi : 'Belum tercatat' }}</span>
                                            <span class="date-sub">Oleh: {{ $siswa->diverifikasi_oleh ?? '-' }}</span>
                                        @else
                                            <span class="date-main">Belum diverifikasi</span>
                                            <span class="date-sub">Menunggu admin</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge-status-pill {{ $siswa->status_class ?? 'status-pending' }}">{{ $siswa->status_label ?? 'Proses' }}</span>
                                    </td>
                                    <td>
                                        @if($isApproved && ($siswa->total_tagihan_final ?? 0) > 0)
                                            <div class="invoice-total">{{ $invoiceText }}</div>
                                            <div class="mini-text">{{ $siswa->nomor_tagihan ?? '-' }}</div>
                                        @elseif($isApproved)
                                            <span class="invoice-empty">Invoice belum dibuat</span>
                                        @else
                                            <span class="invoice-empty">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="reason-text">{{ $catatan }}</div>
                                    </td>
                                    <td style="text-align:center;">
                                        <button type="button" class="btn-detail"
                                            data-nama="{{ e($siswa->nama ?? '-') }}"
                                            data-nik="{{ e($siswa->nik ?? '-') }}"
                                            data-reg="{{ e($siswa->nomor_registrasi_final ?? '-') }}"
                                            data-ttl="{{ e($ttl) }}"
                                            data-batch="{{ e($siswa->nama_batch_final ?? '-') }}"
                                            data-submit="{{ e($tanggalSubmit) }}"
                                            data-verifikasi="{{ e(($isApproved || $isRejected) ? ($hasTanggalVerifikasi ? $tanggalVerifikasi : 'Belum tercatat') : 'Belum diverifikasi') }}"
                                            data-admin="{{ e($siswa->diverifikasi_oleh ?? '-') }}"
                                            data-status="{{ e($siswa->status_label ?? 'Proses') }}"
                                            data-invoice="{{ e($invoiceText) }}"
                                            data-nomor-invoice="{{ e($invoiceInfo) }}"
                                            data-alasan="{{ e($siswa->alasan_penolakan ?? '-') }}"
                                            data-jenis-penolakan="{{ e($siswa->jenis_penolakan ?? '-') }}"
                                            data-alamat="{{ e($siswa->alamat ?? '-') }}">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9">
                                        <div class="empty-state">
                                            <i class="fa-solid fa-clock"></i>
                                            <p>Belum ada riwayat pendaftaran yang sesuai dengan filter.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <footer class="page-footer">
        Yayasan Kanisius © 2026 &nbsp;·&nbsp; Admisi Terintegrasi
    </footer>

    <div id="logoutModal" class="modal-overlay">
        <div class="modal-box" style="max-width:400px; text-align:center;">
            <h3 class="modal-title" style="padding-right:0;"><i class="fa-solid fa-arrow-right-from-bracket" style="color:var(--red); margin-right:8px;"></i>Mengakhiri Sesi?</h3>
            <p class="modal-desc">Apakah Anda yakin ingin keluar dari SAKTI Portal? Sesi Anda akan dihapus demi keamanan akun.</p>
            <div class="modal-btn-group">
                <button type="button" onclick="closeLogoutModal()" class="modal-btn-close modal-btn-cancel">Batal</button>
                <button type="button" onclick="handleLogout()" class="modal-btn-close">Ya, Keluar</button>
            </div>
        </div>
    </div>

    <div id="detailModal" class="modal-overlay">
        <div class="modal-box">
            <button type="button" class="modal-close" onclick="closeDetailModal()">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <h3 class="modal-title"><i class="fa-solid fa-file-lines" style="color: var(--blue); margin-right: 8px;"></i>Detail Riwayat Pendaftaran</h3>
            <p class="modal-desc">Rangkuman data siswa, status verifikasi admin, batch pendaftaran, dan invoice.</p>

            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">Nama Peserta</span>
                    <span class="detail-value" id="detNama">-</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Nomor Registrasi</span>
                    <span class="detail-value" id="detReg">-</span>
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
                    <span class="detail-label">Gelombang / Batch</span>
                    <span class="detail-value" id="detBatch">-</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Status</span>
                    <span class="detail-value" id="detStatus">-</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Tanggal Submit</span>
                    <span class="detail-value" id="detSubmit">-</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Tanggal Approve / Reject</span>
                    <span class="detail-value" id="detVerifikasi">-</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Admin Verifikasi</span>
                    <span class="detail-value" id="detAdmin">-</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Nominal Invoice</span>
                    <span class="detail-value" id="detInvoice">-</span>
                </div>
                <div class="detail-item full">
                    <span class="detail-label">Nomor Invoice</span>
                    <span class="detail-value" id="detNomorInvoice">-</span>
                </div>
                <div class="detail-item full">
                    <span class="detail-label">Alasan / Catatan</span>
                    <span class="detail-value" id="detAlasan">-</span>
                </div>
                <div class="detail-item full">
                    <span class="detail-label">Alamat</span>
                    <span class="detail-value" id="detAlamat">-</span>
                </div>
            </div>

            <button type="button" onclick="closeDetailModal()" class="modal-btn-close">Tutup Detail</button>
        </div>
    </div>

    <div id="toast"></div>

    <script>
        function showToast(msg, dur = 3000) {
            const t = document.getElementById('toast');
            if (!t) return;
            t.innerHTML = msg;
            t.classList.add('show');
            clearTimeout(t._timer);
            t._timer = setTimeout(() => t.classList.remove('show'), dur);
        }

        const logModal = document.getElementById('logoutModal');
        const detModal = document.getElementById('detailModal');

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
            }, 700);
        }

        function closeDetailModal() {
            if (detModal) detModal.classList.remove('show');
        }

        function setText(id, value) {
            const el = document.getElementById(id);
            if (el) el.textContent = value || '-';
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.btn-detail').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    setText('detNama', this.dataset.nama);
                    setText('detReg', this.dataset.reg);
                    setText('detNik', this.dataset.nik);
                    setText('detTtl', this.dataset.ttl);
                    setText('detBatch', this.dataset.batch);
                    setText('detStatus', this.dataset.status);
                    setText('detSubmit', this.dataset.submit);
                    setText('detVerifikasi', this.dataset.verifikasi);
                    setText('detAdmin', this.dataset.admin);
                    setText('detInvoice', this.dataset.invoice);
                    setText('detNomorInvoice', this.dataset.nomorInvoice);
                    setText('detAlasan', this.dataset.alasan);
                    setText('detAlamat', this.dataset.alamat);

                    if (detModal) detModal.classList.add('show');
                });
            });

            [logModal, detModal].forEach(function (modal) {
                if (!modal) return;
                modal.addEventListener('click', function (e) {
                    if (e.target === modal) {
                        modal.classList.remove('show');
                    }
                });
            });
        });
    </script>
</body>
</html>
