<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SAKTI Portal - Verifikasi Berkas</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --navy: #002b5b;
            --navy-dark: #001f42;
            --blue: #004aad;
            --gold: #e5a93c;
            --gold-light: #fff8e7;
            --background: #f4f7fa;
            --surface: #ffffff;
            --border: #e5eaf1;
            --text: #1e293b;
            --muted: #7b82a0;
            --green: #16a34a;
            --green-light: #eaf9f1;
            --red: #dc2626;
            --red-light: #fff0f0;
            --orange: #d97706;
            --orange-light: #fff7ed;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background: var(--background);
            color: var(--text);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        a {
            text-decoration: none;
        }

        .container {
            width: 100%;
            max-width: 1150px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .topbar-wrapper {
            padding-top: 16px;
        }

        .topbar {
            min-height: 74px;
            padding: 14px 24px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 43, 91, 0.05);

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-image {
            width: 44px;
            height: 44px;
            object-fit: contain;
            border-radius: 11px;
        }

        .brand-title {
            color: var(--navy);
            font-size: 16px;
            font-weight: 800;
        }

        .brand-subtitle {
            margin-top: 3px;
            color: var(--muted);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .topbar-nav {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .nav-link {
            color: var(--muted);
            font-size: 13px;
            font-weight: 700;

            display: inline-flex;
            align-items: center;
            gap: 8px;

            transition: 0.2s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--navy);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            color: var(--navy);
            font-size: 13px;
            font-weight: 800;
        }

        .user-role {
            margin-top: 2px;
            color: var(--muted);
            font-size: 10px;
            font-weight: 600;
        }

        .logout-button {
            width: 38px;
            height: 38px;
            border: 0;
            border-radius: 11px;
            background: var(--red-light);
            color: var(--red);
            cursor: pointer;
            transition: 0.2s ease;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logout-button:hover {
            background: #ffe1e1;
            transform: translateY(-1px);
        }

        .page-content {
            padding-top: 42px;
            padding-bottom: 50px;
        }

        .breadcrumb {
            margin-bottom: 20px;
            color: var(--muted);
            font-size: 12px;
            font-weight: 600;

            display: flex;
            align-items: center;
            gap: 8px;
        }

        .breadcrumb a {
            color: var(--blue);
        }

        .page-header {
            margin-bottom: 28px;

            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 24px;
        }

        .page-eyebrow {
            margin-bottom: 8px;
            color: var(--gold);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .page-title {
            color: var(--navy);
            font-size: 30px;
            font-weight: 800;
            line-height: 1.25;
        }

        .page-description {
            max-width: 650px;
            margin-top: 8px;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.7;
        }

        .back-button {
            flex-shrink: 0;
            padding: 11px 16px;
            border: 1px solid var(--border);
            border-radius: 11px;
            background: var(--surface);
            color: var(--navy);
            font-size: 12px;
            font-weight: 700;

            display: inline-flex;
            align-items: center;
            gap: 8px;

            transition: 0.2s ease;
        }

        .back-button:hover {
            border-color: var(--navy);
            transform: translateY(-1px);
        }

        .content-grid {
            display: grid;
            grid-template-columns: 330px minmax(0, 1fr);
            align-items: start;
            gap: 24px;
        }

        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            box-shadow: 0 8px 30px rgba(0, 43, 91, 0.05);
        }

        .student-card {
            padding: 26px;
        }

        .student-avatar {
            width: 64px;
            height: 64px;
            margin-bottom: 18px;
            border-radius: 17px;
            background: linear-gradient(135deg, var(--navy), var(--blue));
            color: #ffffff;
            font-size: 24px;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .student-name {
            color: var(--navy);
            font-size: 19px;
            font-weight: 800;
            line-height: 1.4;
        }

        .registration-number {
            margin-top: 5px;
            color: var(--muted);
            font-family: 'DM Mono', monospace;
            font-size: 11px;
        }

        .student-status {
            width: fit-content;
            margin-top: 15px;
            padding: 7px 11px;
            border-radius: 99px;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .status-approved {
            color: var(--green);
            background: var(--green-light);
        }

        .status-rejected {
            color: var(--red);
            background: var(--red-light);
        }

        .status-draft {
            color: var(--orange);
            background: var(--orange-light);
        }

        .status-process {
            color: var(--blue);
            background: #e8f0fe;
        }

        .student-details {
            margin-top: 24px;
            padding-top: 22px;
            border-top: 1px solid var(--border);

            display: grid;
            gap: 17px;
        }

        .detail-label {
            margin-bottom: 4px;
            color: var(--muted);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.4px;
            text-transform: uppercase;
        }

        .detail-value {
            color: var(--text);
            font-size: 13px;
            font-weight: 700;
            line-height: 1.5;
            word-break: break-word;
        }

        .documents-card {
            overflow: hidden;
        }

        .card-header {
            padding: 23px 26px;
            border-bottom: 1px solid var(--border);

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .card-title-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .card-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--gold-light);
            color: var(--gold);

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-title {
            color: var(--navy);
            font-size: 16px;
            font-weight: 800;
        }

        .card-subtitle {
            margin-top: 3px;
            color: var(--muted);
            font-size: 11px;
        }

        .document-count {
            padding: 7px 11px;
            border-radius: 99px;
            background: #edf3fb;
            color: var(--blue);
            font-size: 10px;
            font-weight: 800;
        }

        .documents-list {
            padding: 10px 26px 18px;
        }

        .document-item {
            padding: 17px 0;
            border-bottom: 1px solid var(--border);

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .document-item:last-child {
            border-bottom: 0;
        }

        .document-info {
            min-width: 0;

            display: flex;
            align-items: center;
            gap: 14px;
        }

        .document-icon {
            width: 44px;
            height: 44px;
            flex-shrink: 0;
            border-radius: 12px;
            background: #edf3fb;
            color: var(--blue);

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .document-name {
            color: var(--text);
            font-size: 13px;
            font-weight: 800;
        }

        .document-meta {
            margin-top: 5px;
            color: var(--muted);
            font-size: 10px;

            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .file-extension {
            font-family: 'DM Mono', monospace;
            text-transform: uppercase;
        }

        .file-status {
            padding: 4px 7px;
            border-radius: 99px;
            font-size: 9px;
            font-weight: 800;
        }

        .file-valid {
            color: var(--green);
            background: var(--green-light);
        }

        .file-waiting {
            color: var(--orange);
            background: var(--orange-light);
        }

        .file-revision {
            color: var(--red);
            background: var(--red-light);
        }

        .view-file-button {
            flex-shrink: 0;
            padding: 9px 13px;
            border-radius: 10px;
            background: var(--navy);
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;

            display: inline-flex;
            align-items: center;
            gap: 7px;

            transition: 0.2s ease;
        }

        .view-file-button:hover {
            background: var(--blue);
            transform: translateY(-1px);
        }

        .empty-state {
            padding: 50px 20px;
            text-align: center;
        }

        .empty-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 15px;
            border-radius: 16px;
            background: #edf3fb;
            color: var(--blue);
            font-size: 22px;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .empty-title {
            color: var(--navy);
            font-size: 15px;
            font-weight: 800;
        }

        .empty-description {
            margin-top: 6px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.6;
        }

        .information-box {
            margin: 0 26px 25px;
            padding: 15px 17px;
            border: 1px solid #dbeafe;
            border-radius: 12px;
            background: #eff6ff;
            color: #475569;
            font-size: 11px;
            line-height: 1.7;

            display: flex;
            align-items: flex-start;
            gap: 11px;
        }

        .information-box i {
            margin-top: 3px;
            color: var(--blue);
        }

        @media (max-width: 900px) {
            .topbar {
                align-items: flex-start;
                flex-wrap: wrap;
            }

            .topbar-nav {
                width: 100%;
                order: 3;
                padding-top: 12px;
                border-top: 1px solid var(--border);
            }

            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 620px) {
            .container {
                padding: 0 14px;
            }

            .page-content {
                padding-top: 30px;
            }

            .page-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .page-title {
                font-size: 25px;
            }

            .topbar-right .user-info {
                display: none;
            }

            .topbar-nav {
                gap: 16px;
                overflow-x: auto;
            }

            .nav-link {
                white-space: nowrap;
            }

            .card-header,
            .documents-list {
                padding-left: 18px;
                padding-right: 18px;
            }

            .document-item {
                align-items: flex-start;
                flex-direction: column;
            }

            .view-file-button {
                width: 100%;
                justify-content: center;
            }

            .information-box {
                margin-left: 18px;
                margin-right: 18px;
            }
        }
    </style>
</head>

<body>
    @php
        $status = strtolower((string) ($siswa->status ?? 'pending'));

        $statusData = match ($status) {
            'approved', 'accepted', 'diterima' => [
                'label' => 'Diterima',
                'class' => 'status-approved',
            ],
            'rejected', 'ditolak' => [
                'label' => 'Ditolak',
                'class' => 'status-rejected',
            ],
            'draft' => [
                'label' => 'Draft',
                'class' => 'status-draft',
            ],
            default => [
                'label' => 'Dalam Proses',
                'class' => 'status-process',
            ],
        };
    @endphp

    <header class="topbar-wrapper">
        <div class="container">
            <div class="topbar">
                <div class="brand">
                    <img class="brand-image" src="{{ asset('img/E-Kanisius 1.png') }}" alt="Logo Kanisius">

                    <div>
                        <div class="brand-title">SAKTI Portal</div>
                        <div class="brand-subtitle">Portal Orang Tua</div>
                    </div>
                </div>

                <nav class="topbar-nav">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <i class="fa-solid fa-house"></i>
                        Dashboard
                    </a>

                    <a class="nav-link active" href="{{ route('riwayat') }}">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        Riwayat
                    </a>
                </nav>

                <div class="topbar-right">
                    <div class="user-info">
                        <div class="user-name">
                            {{ auth()->user()->name ?? 'Orang Tua' }}
                        </div>

                        <div class="user-role">
                            Akun Orang Tua
                        </div>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button class="logout-button" type="submit" title="Keluar">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main class="container page-content">
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <i class="fa-solid fa-chevron-right"></i>
            <span>Verifikasi Berkas</span>
        </div>

        <section class="page-header">
            <div>
                <div class="page-eyebrow">
                    Detail Pendaftaran
                </div>

                <h1 class="page-title">
                    Data Siswa dan Berkas
                </h1>

                <p class="page-description">
                    Lihat kembali data calon siswa dan dokumen yang sudah
                    dikirim untuk proses verifikasi panitia SPMB.
                </p>
            </div>

            <a class="back-button" href="{{ route('dashboard') }}">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali ke Dashboard
            </a>
        </section>

        <div class="content-grid">
            <section class="card student-card">
                <div class="student-avatar">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>

                <h2 class="student-name">
                    {{ $siswa->nama ?? '-' }}
                </h2>

                <div class="registration-number">
                    {{ $siswa->nomor_registrasi ?? 'Nomor registrasi belum tersedia' }}
                </div>

                <div class="student-status {{ $statusData['class'] }}">
                    {{ $statusData['label'] }}
                </div>

                <div class="student-details">
                    <div>
                        <div class="detail-label">NIK</div>
                        <div class="detail-value">
                            {{ $siswa->nik ?? '-' }}
                        </div>
                    </div>

                    <div>
                        <div class="detail-label">Tempat, Tanggal Lahir</div>
                        <div class="detail-value">
                            {{ $siswa->tempat_lahir ?? '-' }},
                            {{ !empty($siswa->tanggal_lahir)
    ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d/m/Y')
    : '-' }}
                        </div>
                    </div>

                    <div>
                        <div class="detail-label">Agama</div>
                        <div class="detail-value">
                            {{ ucfirst($siswa->agama ?? '-') }}
                        </div>
                    </div>

                    <div>
                        <div class="detail-label">Golongan Darah</div>
                        <div class="detail-value">
                            {{ $siswa->golongan_darah ?? '-' }}
                        </div>
                    </div>

                    <div>
                        <div class="detail-label">Alamat</div>
                        <div class="detail-value">
                            {{ $siswa->alamat ?? '-' }}
                        </div>
                    </div>
                </div>
            </section>

            <section class="card documents-card">
                <div class="card-header">
                    <div class="card-title-wrapper">
                        <div class="card-icon">
                            <i class="fa-solid fa-folder-open"></i>
                        </div>

                        <div>
                            <h2 class="card-title">Dokumen Pendaftaran</h2>
                            <p class="card-subtitle">
                                Dokumen yang dikirim untuk diperiksa panitia
                            </p>
                        </div>
                    </div>

                    <div class="document-count">
                        {{ $berkas->count() }} Dokumen
                    </div>
                </div>

                @if($berkas->isNotEmpty())
                    <div class="documents-list">
                        @foreach($berkas as $file)
                                        @php
                                            $extension = pathinfo(
                                                $file->file_url,
                                                PATHINFO_EXTENSION
                                            );

                                            $isValid = (int) $file->is_valid === 1;

                                            if ($isValid) {
                                                $fileStatus = 'Valid';
                                                $fileStatusClass = 'file-valid';
                                            } elseif ($status === 'rejected') {
                                                $fileStatus = 'Perlu diperbaiki';
                                                $fileStatusClass = 'file-revision';
                                            } else {
                                                $fileStatus = 'Menunggu verifikasi';
                                                $fileStatusClass = 'file-waiting';
                                            }
                                        @endphp

                                        <article class="document-item">
                                            <div class="document-info">
                                                <div class="document-icon">
                                                    @if(strtolower($extension) === 'pdf')
                                                        <i class="fa-solid fa-file-pdf"></i>
                                                    @else
                                                        <i class="fa-solid fa-file-image"></i>
                                                    @endif
                                                </div>

                                                <div>
                                                    <div class="document-name">
                                                        {{ $file->jenis_berkas }}
                                                    </div>

                                                    <div class="document-meta">
                                                        <span class="file-extension">
                                                            {{ $extension ?: 'FILE' }}
                                                        </span>

                                                        <span class="file-status {{ $fileStatusClass }}">
                                                            {{ $fileStatus }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <a class="view-file-button" href="{{ route('berkas.show', [
                                'uid' => $file->uid,
                                'filename' => basename((string) $file->file_url),
                            ]) }}" target="_blank" rel="noopener noreferrer">
                                                <i class="fa-solid fa-eye"></i>
                                                Lihat Berkas
                                            </a>
                                        </article>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fa-solid fa-folder-open"></i>
                        </div>

                        <div class="empty-title">
                            Belum ada berkas
                        </div>

                        <p class="empty-description">
                            Dokumen pendaftaran calon siswa belum tersedia.
                        </p>
                    </div>
                @endif

                <div class="information-box">
                    <i class="fa-solid fa-circle-info"></i>

                    <div>
                        Status dokumen diperbarui oleh panitia SPMB setelah
                        proses pemeriksaan. Apabila terdapat dokumen yang perlu
                        diperbaiki, silakan lihat informasi penolakan pada
                        dashboard atau riwayat pendaftaran.
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>

</html>