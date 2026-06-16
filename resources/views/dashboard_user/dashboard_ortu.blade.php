<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAKTI Portal – Portal Orang Tua</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=DM+Mono:wght@400;500&display=swap"
        rel="stylesheet">
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
            --radius-md: 16px;
            --text-dark: #1a1f36;
            --text-gray: #7b82a0;
            --gold-light: rgba(245, 196, 0, 0.12);
            --gold-border: rgba(245, 196, 0, 0.28);
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
            padding-top: 16px;
            /* Jarak dari paling atas layar dikurangi agar lebih presisi */
            animation: fadeIn 0.6s ease forwards;
        }

        .topbar {
            background: var(--surface);
            border-radius: 16px;
            /* DIUBAH LANGSUNG KE ANGKA: Biar langsung rounded sempurna tanpa variabel gaib */
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 20px rgba(0, 43, 91, 0.04);
            border: 1px solid var(--border);
            /* Ditambahkan border tipis agar senada dengan main-card */
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

        .nav-link:hover,
        .nav-link.active {
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

        .status-badge-active {
            background: rgba(22, 163, 74, 0.1);
            border: 1px solid rgba(22, 163, 74, 0.25);
        }

        .status-badge-active .status-badge-text {
            color: var(--green);
        }

        .status-badge-active .status-badge-dot {
            background: var(--green);
        }

        .status-badge-closed {
            background: rgba(220, 38, 38, 0.1);
            border: 1px solid rgba(220, 38, 38, 0.25);
        }

        .status-badge-closed .status-badge-text {
            color: var(--red);
        }

        .status-badge-closed .status-badge-dot {
            background: var(--red);
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
            min-width: 120px;
            justify-content: center;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 35px;
        }

        .btn-tambah-anak {
            background: #18296b;
            color: #ffffff;
            padding: 13px 24px;
            border-radius: 999px;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            border: none;
            box-shadow: 0 8px 18px rgba(24, 41, 107, 0.22);
            transition: 0.2s ease;
            white-space: nowrap;
        }

        .btn-tambah-anak:hover {
            background: #101f57;
            transform: translateY(-1px);
        }

        /* REVISI CSS: Tambahkan status warna agar selaras saat filter if else bekerja */
        .btn-antrian.approved-style {
            background: var(--green) !important;
        }

        .btn-antrian.rejected-style {
            background: var(--red) !important;
        }

        .btn-antrian:hover {
            background: #111c50;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(26, 42, 108, 0.28);
        }

        .btn-invoice {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: #ffffff;
            color: var(--navy);
            border: 1.5px solid rgba(26, 42, 108, 0.22);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 12px;
            font-weight: 800;
            padding: 10px 18px;
            border-radius: 40px;
            cursor: pointer;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            transition: all 0.2s ease;
            white-space: nowrap;
            box-shadow: 0 4px 12px rgba(26, 42, 108, 0.06);
        }

        .btn-invoice:hover {
            background: rgba(26, 42, 108, 0.06);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(26, 42, 108, 0.12);
        }

        #invoiceModal {
            align-items: flex-start;
            overflow-y: auto;
            padding: 18px 12px;
        }

        .invoice-modal-box {
            max-width: 760px;
            width: min(760px, calc(100vw - 28px));
            text-align: left;
            padding: 26px;
            margin: 18px auto;
            max-height: none;
        }

        .invoice-modal-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
            padding-bottom: 18px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 18px;
        }

        .invoice-modal-kicker {
            font-size: 11px;
            font-weight: 900;
            color: var(--gold-dark);
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-bottom: 4px;
        }

        .invoice-modal-title {
            font-size: 22px;
            font-weight: 900;
            color: var(--navy);
            line-height: 1.2;
        }

        .invoice-modal-status {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(22, 163, 74, 0.1);
            color: var(--green);
            border: 1px solid rgba(22, 163, 74, 0.22);
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            white-space: nowrap;
            margin-top: 2px;
        }

        .invoice-info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
            margin-bottom: 18px;
        }

        .invoice-info-item {
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 12px 14px;
        }

        .invoice-info-label {
            font-size: 10px;
            font-weight: 900;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.7px;
            margin-bottom: 4px;
        }

        .invoice-info-value {
            font-size: 13px;
            font-weight: 800;
            color: var(--text-dark);
            word-break: break-word;
        }

        .invoice-table-wrap {
            overflow-x: visible;
            border: 1px solid var(--border);
            border-radius: 14px;
            margin-top: 12px;
            background: #fff;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .invoice-table th {
            background: var(--navy);
            color: #fff;
            text-align: left;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            padding: 12px;
        }

        .invoice-table td {
            padding: 12px;
            border-bottom: 1px solid var(--border);
            font-size: 12.5px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .invoice-table tr:last-child td {
            border-bottom: none;
        }

        .text-right {
            text-align: right !important;
        }

        .invoice-summary {
            margin-top: 16px;
            display: flex;
            justify-content: flex-end;
        }

        .invoice-summary-box {
            width: 100%;
            max-width: 360px;
            background: #fbfcff;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 14px 16px;
        }

        .invoice-summary-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            font-size: 13px;
            font-weight: 800;
            color: var(--text-dark);
            padding: 7px 0;
        }

        .invoice-summary-row.total {
            border-top: 1px dashed var(--border);
            margin-top: 6px;
            padding-top: 12px;
            color: var(--navy);
            font-size: 16px;
            font-weight: 900;
        }

        .invoice-empty-state {
            background: #fff7ed;
            color: #9a3412;
            border: 1px solid #fed7aa;
            border-radius: 16px;
            padding: 16px;
            font-size: 13px;
            font-weight: 800;
            line-height: 1.5;
        }

        .invoice-modal-actions {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-download-invoice {
            background: var(--green);
            color: #ffffff;
            border: none;
            padding: 12px 18px;
            border-radius: 12px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            font-weight: 900;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-width: 170px;
            transition: 0.2s ease;
        }

        .btn-download-invoice:hover {
            background: #15803d;
            transform: translateY(-1px);
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
            right: 30px;
            /* Memindahkan posisi dari tengah ke kanan */
            background: var(--navy);
            color: white;
            padding: 14px 28px;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 600;
            opacity: 0;
            pointer-events: none;
            transform: translateX(30px);
            /* Efek animasi transisi masuk dari kanan */
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
            color: #1a1f36;
            border: 1px solid var(--border);
        }

        .modal-btn-cancel:hover {
            background: #e2e8f0;
        }

        /* ==================== RESPONSIVE (MEDIA QUERIES) ==================== */
        @media (max-width: 1024px) {
            .page-body {
                padding: 32px 24px;
            }

            .main-card {
                padding: 32px;
            }
        }

        @media (max-width: 768px) {
            .topbar {
                padding: 12px 20px;
            }

            .topbar-nav {
                gap: 16px;
            }

            .card-title {
                font-size: 28px;
            }

            .student-card {
                padding: 16px 20px;
            }
        }

        @media (max-width: 640px) {
            .topbar {
                flex-direction: column;
                gap: 16px;
                padding: 16px;
                text-align: center;
            }

            .topbar-brand {
                flex-direction: column;
                gap: 6px;
            }

            .topbar-nav {
                width: 100%;
                justify-content: center;
                gap: 20px;
                border-top: 1px solid var(--border);
                border-bottom: 1px solid var(--border);
                padding: 10px 0;
            }

            .topbar-right {
                width: 100%;
                justify-content: space-between;
                padding-top: 4px;
            }

            .user-info {
                text-align: left;
            }

            .card-header {
                flex-direction: column;
                align-items: stretch;
                gap: 16px;
            }

            .card-header-left {
                align-items: center;
                text-align: center;
            }

            .status-badge {
                justify-content: center;
                width: 100%;
            }

            .btn-daftarkan {
                width: 100%;
                justify-content: center;
            }

            .student-card {
                flex-direction: column;
                align-items: center;
                text-align: center;
                gap: 16px;
                padding: 24px 16px;
            }

            .student-card::before {
                left: 0;
                right: 0;
                top: 0;
                bottom: auto;
                width: auto;
                height: 4px;
            }

            .student-meta {
                justify-content: center;
                gap: 12px;
            }

            .student-actions {
                width: 100%;
                flex-direction: column;
                gap: 8px;
            }

            .btn-verifikasi,
            .btn-antrian,
            .btn-invoice {
                width: 100%;
                justify-content: center;
            }

            #invoiceModal {
                align-items: flex-start;
                padding: 10px;
            }

            .invoice-modal-box {
                width: calc(100vw - 20px);
                padding: 20px 14px;
                margin: 10px auto;
                border-radius: 18px;
            }

            .invoice-modal-header {
                flex-direction: column;
                gap: 10px;
                padding-right: 36px;
            }

            .invoice-info-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .invoice-info-item {
                padding: 11px 12px;
            }

            .invoice-table-wrap {
                border: none;
                overflow: visible;
                background: transparent;
            }

            .invoice-table {
                min-width: 0;
                width: 100%;
                table-layout: auto;
            }

            .invoice-table thead {
                display: none;
            }

            .invoice-table tbody,
            .invoice-table tr,
            .invoice-table td {
                display: block;
                width: 100%;
            }

            .invoice-table tr {
                background: #ffffff;
                border: 1px solid var(--border);
                border-radius: 14px;
                margin-bottom: 10px;
                overflow: hidden;
            }

            .invoice-table td {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                gap: 12px;
                padding: 10px 12px;
                border-bottom: 1px solid var(--border);
                text-align: right !important;
                font-size: 12px;
                line-height: 1.35;
            }

            .invoice-table td:last-child {
                border-bottom: none;
            }

            .invoice-table td::before {
                flex: 0 0 92px;
                content: '';
                text-align: left;
                color: var(--muted);
                font-size: 10px;
                font-weight: 900;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .invoice-table td:nth-child(1)::before { content: 'No'; }
            .invoice-table td:nth-child(2)::before { content: 'Komponen'; }
            .invoice-table td:nth-child(3)::before { content: 'Qty'; }
            .invoice-table td:nth-child(4)::before { content: 'Nominal'; }
            .invoice-table td:nth-child(5)::before { content: 'Subtotal'; }

            .invoice-summary {
                justify-content: stretch;
            }

            .invoice-summary-box {
                max-width: none;
            }

            .invoice-modal-actions {
                flex-direction: column-reverse;
                align-items: stretch;
            }

            .invoice-modal-actions .modal-btn-close,
            .invoice-modal-actions .btn-download-invoice {
                width: 100%;
                max-width: none !important;
            }

            #toast {
                bottom: 20px;
                right: 20px;
                left: 20px;
                transform: translateY(50px);
                white-space: normal;
                text-align: center;
                justify-content: center;
            }

            #toast.show {
                transform: translateY(0);
            }
        }

        .modal-box {
            position: relative;
        }

        .modal-close {
            position: absolute;
            top: 18px;
            right: 18px;
            width: 34px;
            height: 34px;
            border: none;
            border-radius: 50%;
            background: #f1f5f9;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .modal-close:hover {
            background: #fee2e2;
            color: #ef4444;
        }


        .btn-danger {
            width: 100%;
            border: none;
            border-radius: 12px;
            padding: 13px 24px;
            background: var(--red);
            color: #ffffff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s ease;
        }

        .btn-danger:hover {
            background: #b91c1c;
            transform: translateY(-1px);
        }

        /* ===================== PATCH INVOICE LANDSCAPE ===================== */
        #invoiceModal {
            align-items: flex-start;
            justify-content: center;
            overflow: auto;
            padding: 22px 16px;
        }

        #invoiceModal .invoice-modal-box {
            max-width: 1040px;
            width: min(1040px, calc(100vw - 56px));
            min-width: 820px;
            text-align: left;
            padding: 26px;
            margin: 16px auto;
            border-radius: 22px;
        }

        #invoiceModal .invoice-modal-header {
            flex-direction: row;
            align-items: flex-start;
            padding-right: 48px;
        }

        #invoiceModal .invoice-info-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }

        #invoiceModal .invoice-table-wrap {
            border: 1px solid var(--border);
            overflow: hidden;
            background: #fff;
        }

        #invoiceModal .invoice-table {
            display: table;
            width: 100%;
            min-width: 0;
            table-layout: fixed;
            border-collapse: collapse;
        }

        #invoiceModal .invoice-table thead {
            display: table-header-group;
        }

        #invoiceModal .invoice-table tbody {
            display: table-row-group;
        }

        #invoiceModal .invoice-table tr {
            display: table-row;
            background: transparent;
            border: none;
            border-radius: 0;
            margin-bottom: 0;
            overflow: visible;
        }

        #invoiceModal .invoice-table th,
        #invoiceModal .invoice-table td {
            display: table-cell;
            width: auto;
        }

        #invoiceModal .invoice-table td {
            padding: 12px;
            border-bottom: 1px solid var(--border);
            font-size: 12.5px;
            line-height: 1.35;
            text-align: left;
        }

        #invoiceModal .invoice-table td::before {
            display: none;
            content: none;
        }

        #invoiceModal .invoice-table .text-right,
        #invoiceModal .invoice-table td.text-right {
            text-align: right !important;
        }

        #invoiceModal .invoice-summary {
            justify-content: flex-end;
        }

        #invoiceModal .invoice-summary-box {
            max-width: 360px;
        }

        #invoiceModal .invoice-modal-actions {
            flex-direction: row;
            justify-content: flex-end;
            align-items: center;
        }

        #invoiceModal .invoice-modal-actions .modal-btn-close,
        #invoiceModal .invoice-modal-actions .btn-download-invoice {
            width: auto;
            max-width: 180px !important;
        }

        @media (max-width: 900px) {
            #invoiceModal {
                justify-content: flex-start;
                align-items: flex-start;
                overflow: auto;
                padding: 12px;
            }

            #invoiceModal .invoice-modal-box {
                width: 820px;
                min-width: 820px;
                max-width: none;
                margin: 10px 0;
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
                    <a class="nav-link active" href="{{ route('dashboard') }}">
                        <i class=""></i> Dashboard <span class="nav-dot"></span>
                    </a>
                    <a class="nav-link" href="{{ route('riwayat') }}">
                        <i class=""></i> Riwayat
                    </a>
                    <a class="nav-link" href="{{ route('pusat_bantuan') }}">
                        <i class=""></i> Pusat Bantuan
                    </a>
                </nav>

                <div class="topbar-right">
                    <div class="user-info">
                        <div class="user-name">{{ auth()->user()->name ?? 'Orang Tua' }}</div>
                        <div class="user-branch">Cabang Global</div>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <button type="button" class="btn-logout" title="Keluar" onclick="openLogoutModal()"
                        style="border: none; background: none; cursor: pointer;">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </button>
                </div>
            </header>
        </div>
    </div>

    <main class="page-body">
        @if (session('success'))
            <div
                style="background:#dcfce7;color:#166534;padding:14px 18px;border-radius:14px;border:1px solid rgba(22,163,74,.25);font-weight:700;">
                {{ session('success') }}
            </div>
        @endif

        @if (session('warning'))
            <div
                style="background:#fef3c7;color:#92400e;padding:14px 18px;border-radius:14px;border:1px solid rgba(245,158,11,.25);font-weight:700;">
                {{ session('warning') }}
            </div>
        @endif

        @if (session('error'))
            <div
                style="background:#fee2e2;color:#991b1b;padding:14px 18px;border-radius:14px;border:1px solid rgba(220,38,38,.25);font-weight:700;">
                {{ session('error') }}
            </div>
        @endif

        <div class="main-card">
            <div class="card-header">
                <div class="card-header-left">
                    <h1 class="card-title">Portal Orang Tua</h1>

                    @if($batchAktif)
                        <div class="status-badge status-badge-active">
                            <span class="status-badge-text">
                                Status: {{ strtoupper($batch->nama_batch ?? 'BATCH AKTIF') }}
                            </span>

                            <span class="status-badge-dot"></span>

                            <span class="status-badge-text">
                                Sisa Kuota: {{ $sisaKuota }}
                            </span>
                        </div>
                    @else
                        <div class="status-badge status-badge-closed">
                            <span class="status-badge-text">
                                Status: Batch Tutup
                            </span>

                            <span class="status-badge-dot"></span>

                            <span class="status-badge-text">
                                Sisa Kuota: 0
                            </span>
                        </div>
                    @endif
                </div>

                @if($batchAktif)
                    <a href="{{ route('form.daftar') }}" class="btn-tambah-anak">
                        + Tambah Anak
                    </a>
                @endif
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
                                {{ $siswa->nama ?? '-' }}
                            </div>

                            <div class="student-meta">
                                <div class="meta-item">
                                    <span class="meta-icon">📍</span>
                                    {{ $siswa->tempat_lahir ?? '-' }}
                                </div>

                                <div class="meta-item">
                                    <span class="meta-icon">🕐</span>
                                    {{ !empty($siswa->created_at) ? \Carbon\Carbon::parse($siswa->created_at)->format('d/m/Y') : '-' }}
                                </div>

                                <div class="meta-item">
                                    <span class="meta-icon">🔖</span>
                                    {{ $siswa->nomor_registrasi ?? '-' }}
                                </div>
                            </div>
                        </div>

                        <div class="student-actions">

                            @php
                                $statusText = $siswa->status ?? 'pending';
                                $statusLower = strtolower(trim($statusText));

                                $extraClass = '';

                                if (in_array($statusLower, ['approved', 'accepted', 'diterima'])) {
                                    $extraClass = 'approved-style';
                                } elseif (in_array($statusLower, ['rejected', 'ditolak'])) {
                                    $extraClass = 'rejected-style';
                                }
                            @endphp

                            @if($statusLower === 'pending')
                                <a href="{{ route('verifikasi.berkas', $siswa->pendaftaran_uid ?? $siswa->uid_pendaftaran ?? $siswa->uid) }}"
                                    class="btn-verifikasi">
                                    <span class="spin-icon">◌</span> VERIFIKASI BERKAS
                                </a>
                            @endif

                            <button type="button" class="btn-antrian {{ $extraClass }}" onclick="handleStatusAction(
                                                @js($statusLower),
                                                @js($siswa->nama ?? '-'),
                                                @js($siswa->alasan_penolakan ?? ''),
                                                @js($siswa->jenis_penolakan ?? '')
                                            )">
                                {{ strtoupper($statusText) }}
                            </button>

                            @if(in_array($statusLower, ['approved', 'accepted', 'diterima']))
                                @php
                                    $komponenInvoice = collect($siswa->komponen_tagihan ?? [])->map(function ($item) {
                                        $qty = (float) ($item->qty ?? 0);
                                        $nominal = (float) ($item->nominal ?? 0);

                                        return [
                                            'nama_komponen' => $item->nama_komponen ?? '-',
                                            'qty' => $qty,
                                            'nominal' => $nominal,
                                            'subtotal' => (float) ($item->subtotal ?? ($qty * $nominal)),
                                        ];
                                    })->values();

                                    $invoicePayload = [
                                        'has_tagihan' => !empty($siswa->tagihan_uid),
                                        'nama_siswa' => $siswa->nama ?? '-',
                                        'no_pendaftaran' => $siswa->no_pendaftaran ?? $siswa->nomor_registrasi ?? '-',
                                        'nomor_tagihan' => $siswa->nomor_tagihan ?? '-',
                                        'status_tagihan' => $siswa->status_tagihan ?? '-',
                                        'tanggal_tagihan' => !empty($siswa->tanggal_tagihan)
                                            ? \Carbon\Carbon::parse($siswa->tanggal_tagihan)->format('d/m/Y')
                                            : '-',
                                        'admin_pembuat' => $siswa->tagihan_dibuat_oleh ?? '-',
                                        'subtotal_tagihan' => (float) ($siswa->subtotal_tagihan ?? 0),
                                        'diskon_tagihan' => (float) ($siswa->diskon_tagihan ?? 0),
                                        'total_tagihan' => (float) ($siswa->total_tagihan ?? 0),
                                        'items' => $komponenInvoice,
                                    ];
                                @endphp

                                <button type="button" class="btn-invoice" onclick="openInvoiceModal(@js($invoicePayload))">
                                    <i class="fa-solid fa-file-invoice-dollar"></i> Invoice
                                </button>
                            @endif

                        </div>
                    </div>
                @empty
                    <p style="text-align: center; padding: 24px; color: var(--muted); font-weight: 600;">Tidak ada data
                        siswa yang ditemukan.</p>
                @endforelse
            </div>
        </div>
    </main>

    <footer class="page-footer">
        Yayasan Kanisius © 2026 &nbsp;·&nbsp; Admisi Terintegrasi
    </footer>

    <div id="logoutModal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-icon" style="background: #fff5f5; color: var(--red);"><i
                    class="fa-solid fa-arrow-right-from-bracket"></i></div>
            <h3 class="modal-title">Mengakhiri Sesi?</h3>
            <p class="modal-desc">Apakah Anda yakin ingin keluar dari SAKTI Portal? Sesi Anda akan dihapus demi keamanan
                akun.</p>
            <div class="modal-btn-group">
                <button type="button" onclick="closeLogoutModal()"
                    class="modal-btn-close modal-btn-cancel">Batal</button>
                <button type="button" onclick="handleLogout()" class="modal-btn-close"
                    style="background: var(--navy);">Ya, Keluar</button>
            </div>
        </div>
    </div>

    <div id="rejectedModal" class="modal-overlay">
        <div class="modal-box">

            <button type="button" class="modal-close" onclick="closeRejectedModal()">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="modal-icon reject-icon">
                <i class="fa-solid fa-xmark"></i>
            </div>

            <h3 class="modal-title" id="rejectTitle">Berkas Ditolak</h3>
            <p class="modal-desc" id="rejectDesc">Tidak sesuai</p>

            <a href="{{ route('form.daftar') }}" id="btnPerbaikiBerkas" class="btn-danger">
                Perbaiki Berkas
            </a>
        </div>
    </div>

    <div id="invoiceModal" class="modal-overlay">
        <div class="modal-box invoice-modal-box">
            <button type="button" class="modal-close" onclick="closeInvoiceModal()">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="invoice-modal-header">
                <div>
                    <div class="invoice-modal-kicker">Invoice Admisi</div>
                    <div class="invoice-modal-title" id="invoiceStudentName">-</div>
                </div>
                <span class="invoice-modal-status" id="invoicePaymentStatus">
                    <i class="fa-solid fa-circle-check"></i> -
                </span>
            </div>

            <div id="invoiceModalContent"></div>

            <div class="invoice-modal-actions">
                <button type="button" id="btnDownloadInvoice" onclick="downloadInvoicePDF()" class="btn-download-invoice">
                    <i class="fa-solid fa-download"></i> Download PDF
                </button>
                <button type="button" onclick="closeInvoiceModal()" class="modal-btn-close" style="max-width:180px;">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <div id="toast"></div>

    <script>
        // 1. Sempurnakan fungsi showToast agar bisa menerima HTML Icon
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
            REVISI JAVASCRIPT: CORE LOGIC CONDITIONAL HANDLING STATUS BUTTON
        ============================================================ */
        const rejModal = document.getElementById('rejectedModal');

        function closeRejectedModal() {
            if (rejModal) {
                rejModal.classList.remove('show');
            }
        }

        function handleStatusAction(status, studentName, alasanPenolakan = '', jenisPenolakan = '') {
            status = String(status || '').toLowerCase().trim();
            jenisPenolakan = String(jenisPenolakan || '').toLowerCase().trim();

            if (status === 'rejected' || status === 'ditolak') {
                const rejectTitle = document.getElementById('rejectTitle');
                const rejectDesc = document.getElementById('rejectDesc');
                const btnPerbaikiBerkas = document.getElementById('btnPerbaikiBerkas');

                if (rejectTitle) {
                    rejectTitle.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> Berkas ${studentName} Ditolak`;
                }

                if (rejectDesc) {
                    rejectDesc.innerText = alasanPenolakan || 'Tidak ada alasan penolakan.';
                }

                if (btnPerbaikiBerkas) {
                    btnPerbaikiBerkas.style.display = jenisPenolakan === 'batch_penuh' ? 'none' : 'flex';
                }

                if (rejModal) {
                    rejModal.classList.add('show');
                }
            }
        }

        const invoiceModal = document.getElementById('invoiceModal');
        let currentInvoiceData = null;

        function escapeHtml(value) {
            return String(value ?? '')
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');
        }

        function formatRupiah(value) {
            const numberValue = Number(value || 0);
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(numberValue);
        }

        function openInvoiceModal(data) {
            if (!invoiceModal) return;
            currentInvoiceData = data || null;

            const invoiceStudentName = document.getElementById('invoiceStudentName');
            const invoicePaymentStatus = document.getElementById('invoicePaymentStatus');
            const invoiceModalContent = document.getElementById('invoiceModalContent');
            const btnDownloadInvoice = document.getElementById('btnDownloadInvoice');

            if (invoiceStudentName) {
                invoiceStudentName.textContent = data?.nama_siswa || '-';
            }

            if (invoicePaymentStatus) {
                const statusTagihan = data?.status_tagihan && data.status_tagihan !== '-' ? data.status_tagihan : 'belum dibuat';
                invoicePaymentStatus.innerHTML = `<i class="fa-solid fa-circle-check"></i> ${escapeHtml(statusTagihan).toUpperCase()}`;
            }

            if (!data?.has_tagihan) {
                if (btnDownloadInvoice) {
                    btnDownloadInvoice.style.display = 'none';
                }

                invoiceModalContent.innerHTML = `
                    <div class="invoice-empty-state">
                        Invoice untuk pendaftar approved ini belum dibuat atau belum disimpan oleh admin.
                        Silakan tunggu admin mengisi dan menyimpan data tagihan terlebih dahulu.
                    </div>
                `;
                invoiceModal.classList.add('show');
                return;
            }

            if (btnDownloadInvoice) {
                btnDownloadInvoice.style.display = 'inline-flex';
            }

            const items = Array.isArray(data.items) ? data.items : [];
            const rows = items.length
                ? items.map((item, index) => `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${escapeHtml(item.nama_komponen || '-')}</td>
                        <td class="text-right">${escapeHtml(item.qty || 0)}</td>
                        <td class="text-right">${formatRupiah(item.nominal)}</td>
                        <td class="text-right">${formatRupiah(item.subtotal)}</td>
                    </tr>
                `).join('')
                : `<tr><td colspan="5" style="text-align:center;color:var(--muted);">Komponen tagihan belum tersedia.</td></tr>`;

            invoiceModalContent.innerHTML = `
                <div class="invoice-info-grid">
                    <div class="invoice-info-item">
                        <div class="invoice-info-label">Nomor Tagihan</div>
                        <div class="invoice-info-value">${escapeHtml(data.nomor_tagihan || '-')}</div>
                    </div>
                    <div class="invoice-info-item">
                        <div class="invoice-info-label">Nomor Pendaftaran</div>
                        <div class="invoice-info-value">${escapeHtml(data.no_pendaftaran || '-')}</div>
                    </div>
                    <div class="invoice-info-item">
                        <div class="invoice-info-label">Tanggal Tagihan</div>
                        <div class="invoice-info-value">${escapeHtml(data.tanggal_tagihan || '-')}</div>
                    </div>
                    <div class="invoice-info-item">
                        <div class="invoice-info-label">Dibuat Oleh</div>
                        <div class="invoice-info-value">${escapeHtml(data.admin_pembuat || '-')}</div>
                    </div>
                </div>

                <div class="invoice-table-wrap">
                    <table class="invoice-table">
                        <thead>
                            <tr>
                                <th style="width:50px;">No</th>
                                <th>Komponen</th>
                                <th class="text-right" style="width:80px;">Qty</th>
                                <th class="text-right" style="width:150px;">Nominal</th>
                                <th class="text-right" style="width:160px;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>${rows}</tbody>
                    </table>
                </div>

                <div class="invoice-summary">
                    <div class="invoice-summary-box">
                        <div class="invoice-summary-row">
                            <span>Subtotal</span>
                            <strong>${formatRupiah(data.subtotal_tagihan)}</strong>
                        </div>
                        <div class="invoice-summary-row">
                            <span>Diskon</span>
                            <strong>${formatRupiah(data.diskon_tagihan)}</strong>
                        </div>
                        <div class="invoice-summary-row total">
                            <span>Total Tagihan</span>
                            <strong>${formatRupiah(data.total_tagihan)}</strong>
                        </div>
                    </div>
                </div>
            `;

            invoiceModal.classList.add('show');
        }

        function closeInvoiceModal() {
            if (invoiceModal) {
                invoiceModal.classList.remove('show');
            }
        }

        function buildPrintableInvoice(data) {
            const items = Array.isArray(data?.items) ? data.items : [];
            const rows = items.length
                ? items.map((item, index) => `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${escapeHtml(item.nama_komponen || '-')}</td>
                        <td class="text-center">${escapeHtml(item.qty || 0)}</td>
                        <td class="text-right">${formatRupiah(item.nominal)}</td>
                        <td class="text-right">${formatRupiah(item.subtotal)}</td>
                    </tr>
                `).join('')
                : `<tr><td colspan="5" class="text-center">Komponen tagihan belum tersedia.</td></tr>`;

            return `<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>${escapeHtml(data?.nomor_tagihan || 'Invoice SPMB')}</title>
    <style>
        @page { size: A4 landscape; margin: 12mm; }
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; margin: 0; padding: 18px; color: #1a1f36; background: #f4f6fb; }
        .sheet { width: 100%; max-width: 1120px; margin: 0 auto; background: #fff; border: 1px solid #dfe3ef; border-radius: 18px; padding: 24px; }
        .header { display: flex; justify-content: space-between; gap: 18px; border-bottom: 3px solid #1a2a6c; padding-bottom: 16px; margin-bottom: 18px; }
        .brand { font-size: 12px; font-weight: 800; color: #7b82a0; text-transform: uppercase; letter-spacing: .8px; }
        h1 { margin: 6px 0 0; color: #1a2a6c; font-size: 28px; }
        .status { color: #16a34a; border: 1px solid rgba(22,163,74,.25); border-radius: 999px; padding: 8px 12px; font-size: 12px; font-weight: 800; height: fit-content; }
        .info { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 12px; margin-bottom: 18px; }
        .box { background: #f7f8fc; border: 1px solid #dfe3ef; border-radius: 12px; padding: 12px; }
        .label { font-size: 10px; color: #7b82a0; text-transform: uppercase; font-weight: 800; letter-spacing: .7px; margin-bottom: 5px; }
        .value { font-size: 14px; font-weight: 800; color: #1a1f36; word-break: break-word; }
        table { width: 100%; border-collapse: collapse; table-layout: fixed; margin-top: 12px; }
        th { background: #1a2a6c; color: #fff; text-align: left; padding: 11px; font-size: 11px; text-transform: uppercase; }
        td { border: 1px solid #dfe3ef; padding: 10px 11px; font-size: 12.5px; font-weight: 600; line-height: 1.35; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .summary { margin-left: auto; margin-top: 16px; width: 360px; border: 1px solid #dfe3ef; border-radius: 14px; padding: 12px 16px; }
        .summary-row { display: flex; justify-content: space-between; gap: 14px; padding: 7px 0; font-weight: 800; }
        .total { border-top: 1px dashed #dfe3ef; margin-top: 6px; padding-top: 12px; color: #1a2a6c; font-size: 18px; }
        .note { margin-top: 18px; font-size: 12px; color: #64748b; line-height: 1.6; }
        @media print {
            body { background: #fff; padding: 0; }
            .sheet { border: none; border-radius: 0; max-width: none; padding: 0; }
        }
    </style>
</head>
<body>
    <div class="sheet">
        <div class="header">
            <div>
                <div class="brand">SAKTI Portal - Invoice Admisi</div>
                <h1>${escapeHtml(data?.nama_siswa || '-')}</h1>
            </div>
            <div class="status">${escapeHtml((data?.status_tagihan || 'BELUM DIBUAT')).toUpperCase()}</div>
        </div>

        <div class="info">
            <div class="box"><div class="label">Nomor Tagihan</div><div class="value">${escapeHtml(data?.nomor_tagihan || '-')}</div></div>
            <div class="box"><div class="label">Nomor Pendaftaran</div><div class="value">${escapeHtml(data?.no_pendaftaran || '-')}</div></div>
            <div class="box"><div class="label">Tanggal Tagihan</div><div class="value">${escapeHtml(data?.tanggal_tagihan || '-')}</div></div>
            <div class="box"><div class="label">Dibuat Oleh</div><div class="value">${escapeHtml(data?.admin_pembuat || '-')}</div></div>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width:50px;">No</th>
                    <th>Komponen</th>
                    <th class="text-center" style="width:70px;">Qty</th>
                    <th class="text-right" style="width:150px;">Nominal</th>
                    <th class="text-right" style="width:150px;">Subtotal</th>
                </tr>
            </thead>
            <tbody>${rows}</tbody>
        </table>

        <div class="summary">
            <div class="summary-row"><span>Subtotal</span><span>${formatRupiah(data?.subtotal_tagihan)}</span></div>
            <div class="summary-row"><span>Diskon</span><span>${formatRupiah(data?.diskon_tagihan)}</span></div>
            <div class="summary-row total"><span>Total Tagihan</span><span>${formatRupiah(data?.total_tagihan)}</span></div>
        </div>

        <div class="note">
            Dokumen ini dibuat dari data tagihan yang tersimpan di database SPMB. Gunakan dialog cetak browser lalu pilih <strong>Save as PDF</strong> untuk menyimpan file.
        </div>
    </div>
</body>
</html>`;
        }

        function downloadInvoicePDF() {
            if (!currentInvoiceData || !currentInvoiceData.has_tagihan) {
                showToast('<i class="fa-solid fa-circle-info"></i> Invoice belum tersedia untuk diunduh.');
                return;
            }

            const printWindow = window.open('', '_blank', 'width=900,height=720');
            if (!printWindow) {
                showToast('<i class="fa-solid fa-triangle-exclamation"></i> Pop-up browser diblokir. Izinkan pop-up untuk download invoice.');
                return;
            }

            printWindow.document.open();
            printWindow.document.write(buildPrintableInvoice(currentInvoiceData));
            printWindow.document.close();
            printWindow.focus();

            setTimeout(() => {
                printWindow.print();
            }, 350);
        }

        if (rejModal) {
            rejModal.addEventListener('click', function (e) {
                if (e.target === rejModal) {
                    closeRejectedModal();
                }
            });
        }

        if (invoiceModal) {
            invoiceModal.addEventListener('click', function (e) {
                if (e.target === invoiceModal) {
                    closeInvoiceModal();
                }
            });
        }

        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', function () {
                    document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
    </script>
</body>

</html>