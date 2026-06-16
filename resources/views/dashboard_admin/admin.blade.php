<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SAKTI PORTAL – Dashboard Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Sora:wght@400;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* ===== CSS VARIABLES ===== */
        :root {
            --primary: #0f2a5e;
            --primary-light: #1a3d8f;
            --accent: #f5a623;
            --green: #22c55e;
            --green-bg: #f0fdf4;
            --green-border: #bbf7d0;
            --red: #ef4444;
            --red-bg: #fff1f2;
            --red-border: #fecdd3;
            --orange: #f97316;
            --orange-bg: #fff7ed;
            --orange-border: #fed7aa;
            --blue: #3b82f6;
            --blue-bg: #eff6ff;
            --blue-border: #bfdbfe;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, .08);
            --shadow-md: 0 4px 16px rgba(0, 0, 0, .10);
            --shadow-lg: 0 8px 32px rgba(0, 0, 0, .12);
            --radius: 16px;
            --radius-sm: 10px;
            --transition: all .22s cubic-bezier(.4, 0, .2, 1);
            --dark-panel: #0f172a;
        }

        /* ===== RESET ===== */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            font-size: 15px;
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--gray-50);
            color: var(--gray-800);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ===== PAGE WRAPPER ===== */
        .page-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ===== BACKGROUND DECOR ===== */
        .bg-decor {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .bg-decor::before {
            content: '';
            position: absolute;
            width: 700px;
            height: 700px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(59, 130, 246, .09) 0%, transparent 70%);
            top: -200px;
            left: -200px;
        }

        .bg-decor::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(245, 166, 35, .07) 0%, transparent 70%);
            bottom: -100px;
            right: -100px;
        }

        /* ===== NAVBAR ===== */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: #fff;
            border-bottom: 1px solid var(--gray-200);
            box-shadow: var(--shadow-sm);
        }

        .navbar-inner {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 28px;
            height: 68px;
            display: flex;
            align-items: center;
            gap: 32px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            min-width: 200px;
        }

        .brand-logo {
            width: 44px;
            height: 44px;
            background: var(--primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            font-size: 18px;
            flex-shrink: 0;
        }

        .brand-text {
            line-height: 1.2;
        }

        .brand-name {
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            font-size: 1.05rem;
            color: var(--primary);
            letter-spacing: .5px;
        }

        .brand-meta {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: .68rem;
            font-weight: 600;
            color: var(--green);
            letter-spacing: 1px;
        }

        .brand-meta .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--green);
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: .5;
                transform: scale(.8);
            }
        }

        .brand-uid {
            font-size: .65rem;
            color: var(--gray-400);
            font-weight: 500;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 4px;
            flex: 1;
            justify-content: center;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 8px 16px;
            border-radius: 10px;
            font-size: .875rem;
            font-weight: 600;
            color: var(--gray-500);
            text-decoration: none;
            transition: var(--transition);
            cursor: pointer;
            border: none;
            background: none;
        }

        .nav-link:hover {
            background: var(--gray-100);
            color: var(--primary);
        }

        .nav-link.active {
            background: var(--blue-bg);
            color: var(--primary);
        }

        .nav-link .nav-badge {
            background: var(--accent);
            color: #fff;
            font-size: .6rem;
            font-weight: 700;
            padding: 1px 6px;
            border-radius: 20px;
        }

        .nav-user {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 6px 10px;
            border-radius: 12px;
            transition: var(--transition);
            position: relative;
        }

        .nav-user:hover {
            background: var(--gray-100);
        }

        .nav-user-text {
            text-align: right;
        }

        .nav-username {
            font-weight: 700;
            font-size: .875rem;
            color: var(--primary);
        }

        .nav-branch {
            font-size: .7rem;
            color: var(--gray-400);
            font-weight: 500;
        }

        .nav-logout {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--red-bg);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--red);
            font-size: .9rem;
            transition: var(--transition);
        }

        .nav-logout:hover {
            background: var(--red);
            color: #fff;
        }

        /* ===== MAIN CONTENT ===== */
        main {
            position: relative;
            z-index: 1;
            max-width: 1400px;
            margin: 0 auto;
            padding: 32px 28px 48px;
            flex: 1;
        }

        /* ===== STAT CARDS ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 36px;
        }

        .stat-card {
            background: #fff;
            border-radius: var(--radius);
            padding: 22px 24px;
            box-shadow: var(--shadow-sm);
            border: 1.5px solid var(--gray-200);
            transition: var(--transition);
            cursor: default;
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            border-radius: var(--radius) var(--radius) 0 0;
        }

        .stat-card.blue::after {
            background: var(--blue);
        }

        .stat-card.green::after {
            background: var(--green);
        }

        .stat-card.red::after {
            background: var(--red);
        }

        .stat-card.orange::after {
            background: var(--orange);
        }

        .stat-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .stat-card.blue {
            background: var(--blue-bg);
            border-color: var(--blue-border);
        }

        .stat-card.green {
            background: var(--green-bg);
            border-color: var(--green-border);
        }

        .stat-card.red {
            background: var(--red-bg);
            border-color: var(--red-border);
        }

        .stat-card.orange {
            background: var(--orange-bg);
            border-color: var(--orange-border);
        }

        .stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .stat-label {
            font-size: .68rem;
            font-weight: 800;
            letter-spacing: 1.2px;
            text-transform: uppercase;
        }

        .stat-card.blue .stat-label {
            color: var(--blue);
        }

        .stat-card.green .stat-label {
            color: var(--green);
        }

        .stat-card.red .stat-label {
            color: var(--red);
        }

        .stat-card.orange .stat-label {
            color: var(--orange);
        }

        .stat-icon {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .stat-card.blue .stat-icon {
            background: rgba(59, 130, 246, .15);
            color: var(--blue);
        }

        .stat-card.green .stat-icon {
            background: rgba(34, 197, 94, .15);
            color: var(--green);
        }

        .stat-card.red .stat-icon {
            background: rgba(239, 68, 68, .15);
            color: var(--red);
        }

        .stat-card.orange .stat-icon {
            background: rgba(249, 115, 22, .15);
            color: var(--orange);
        }

        .stat-number {
            font-family: 'Sora', sans-serif;
            font-size: 2.6rem;
            font-weight: 700;
            line-height: 1;
        }

        .stat-card.blue .stat-number {
            color: var(--blue);
        }

        .stat-card.green .stat-number {
            color: var(--green);
        }

        .stat-card.red .stat-number {
            color: var(--red);
        }

        .stat-card.orange .stat-number {
            color: var(--orange);
        }

        /* ===== VERIFICATION SECTION ===== */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .section-title-wrap {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .section-title {
            font-family: 'Sora', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        .section-sub {
            font-size: .75rem;
            color: var(--gray-500);
            font-weight: 600;
            letter-spacing: .5px;
            margin-top: 2px;
        }

        .section-sub span {
            color: var(--primary);
            font-weight: 700;
        }

        .btn-batch {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 18px;
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .5px;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-batch:hover {
            background: var(--primary-light);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(15, 42, 94, .25);
        }

        /* ===== TOOLBAR ===== */
        .toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 18px;
            flex-wrap: wrap;
        }

        .search-wrap {
            position: relative;
            flex: 1;
            min-width: 240px;
            max-width: 480px;
        }

        .search-wrap i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
            font-size: .9rem;
            pointer-events: none;
        }

        .search-input {
            width: 100%;
            padding: 11px 16px 11px 40px;
            border: 1.5px solid var(--gray-200);
            border-radius: 10px;
            font-size: .875rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 500;
            color: var(--gray-800);
            background: #fff;
            transition: var(--transition);
            outline: none;
        }

        .search-input:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, .12);
        }

        .search-input::placeholder {
            color: var(--gray-400);
        }

        .filter-tabs {
            display: flex;
            align-items: center;
            gap: 6px;
            background: var(--gray-100);
            padding: 4px;
            border-radius: 12px;
        }

        .filter-tab {
            padding: 8px 16px;
            border-radius: 9px;
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .5px;
            cursor: pointer;
            border: none;
            background: transparent;
            color: var(--gray-500);
            transition: var(--transition);
        }

        .filter-tab:hover {
            color: var(--primary);
        }

        .filter-tab.active {
            background: var(--primary);
            color: #fff;
            box-shadow: var(--shadow-sm);
        }

        /* ===== TABLE CARD ===== */
        .table-card {
            background: #fff;
            border-radius: var(--radius);
            border: 1.5px solid var(--gray-200);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            background: var(--gray-50);
            border-bottom: 1.5px solid var(--gray-200);
        }

        th {
            padding: 12px 18px;
            font-size: .7rem;
            font-weight: 800;
            color: var(--gray-400);
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: left;
            white-space: nowrap;
        }

        tbody tr {
            border-bottom: 1px solid var(--gray-100);
            transition: var(--transition);
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody tr:hover {
            background: var(--gray-50);
        }

        td {
            padding: 14px 18px;
            font-size: .85rem;
            color: var(--gray-700);
            vertical-align: middle;
        }

        .td-name {
            font-weight: 700;
            color: var(--primary);
        }

        .td-id {
            font-size: .75rem;
            color: var(--gray-400);
            font-weight: 500;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .3px;
        }

        .badge-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
        }

        .badge-draft {
            background: var(--gray-100);
            color: var(--gray-500);
        }

        .badge-draft .badge-dot {
            background: var(--gray-400);
        }

        .badge-proses {
            background: var(--orange-bg);
            color: var(--orange);
        }

        .badge-proses .badge-dot {
            background: var(--orange);
            animation: pulse-dot 1.5s infinite;
        }

        .badge-approved {
            background: var(--green-bg);
            color: var(--green);
        }

        .badge-approved .badge-dot {
            background: var(--green);
        }

        .badge-rejected {
            background: var(--red-bg);
            color: var(--red);
        }

        .badge-rejected .badge-dot {
            background: var(--red);
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1.5px solid var(--gray-200);
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: .8rem;
            color: var(--gray-500);
            transition: var(--transition);
        }

        .btn-action:hover {
            border-color: var(--blue);
            color: var(--blue);
            background: var(--blue-bg);
        }

        .empty-state {
            padding: 80px 24px;
            text-align: center;
            color: var(--gray-400);
        }

        .empty-icon {
            font-size: 2.5rem;
            margin-bottom: 14px;
            opacity: .5;
        }

        .empty-state p {
            font-size: .8rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .pagination-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px;
            border-top: 1.5px solid var(--gray-100);
            gap: 12px;
            flex-wrap: wrap;
        }

        .pagination-info {
            font-size: .78rem;
            color: var(--gray-500);
            font-weight: 500;
        }

        .pagination-btns {
            display: flex;
            gap: 4px;
        }

        /* ===== MODALS ===== */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(15, 42, 94, .45);
            backdrop-filter: blur(6px);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            animation: fadeIn .2s ease;
        }

        .modal-backdrop.open {
            display: flex;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .modal {
            background: #fff;
            border-radius: 24px;
            box-shadow: var(--shadow-lg);
            width: 100%;
            max-width: 520px;
            animation: slideUp .25s cubic-bezier(.4, 0, .2, 1);
        }

        .modal.modal-wide {
            max-width: 1050px;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            padding: 24px 28px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal.modal-wide .modal-header {
            padding: 24px 32px;
            border-bottom: 1px solid var(--gray-100);
        }

        .modal-title {
            font-family: 'Sora', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary);
        }

        .modal-close {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: none;
            background: var(--gray-100);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-500);
            font-size: .85rem;
            transition: var(--transition);
        }

        .modal-close:hover {
            background: var(--red-bg);
            color: var(--red);
        }

        .modal-body {
            padding: 20px 28px;
        }

        .modal.modal-wide .modal-body {
            padding: 32px;
            overflow-y: auto;
            display: grid;
            grid-template-columns: 1.1fr 1.3fr;
            gap: 32px;
            background: #fff;
        }

        .modal-footer {
            padding: 0 28px 24px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        /* Form */
        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: .75rem;
            font-weight: 700;
            color: var(--gray-600);
            margin-bottom: 6px;
            letter-spacing: .4px;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--gray-200);
            border-radius: 9px;
            font-size: .875rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--gray-800);
            background: #fff;
            outline: none;
            transition: var(--transition);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        /* Buttons */
        .btn {
            padding: 10px 20px;
            border-radius: 9px;
            font-size: .85rem;
            font-weight: 700;
            cursor: pointer;
            border: none;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .btn-secondary {
            background: var(--gray-100);
            color: var(--gray-600);
        }

        .btn-secondary:hover {
            background: var(--gray-200);
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--primary-light);
            box-shadow: 0 4px 12px rgba(15, 42, 94, .25);
        }

        .detail-row {
            display: flex;
            align-items: flex-start;
            padding: 10px 0;
            border-bottom: 1px solid var(--gray-100);
            gap: 12px;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-size: .75rem;
            font-weight: 700;
            color: var(--gray-400);
            width: 130px;
            flex-shrink: 0;
            padding-top: 1px;
        }

        .detail-value {
            font-size: .875rem;
            color: var(--gray-800);
            font-weight: 600;
        }

        .inspeksi-title-block {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .inspeksi-icon-badge {
            width: 48px;
            height: 48px;
            background: var(--primary);
            color: var(--accent);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .inspeksi-title-text h2 {
            font-family: 'Sora', sans-serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
        }

        .inspeksi-title-text p {
            font-size: 0.72rem;
            color: var(--gray-400);
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-top: 2px;
        }

        .inspeksi-section-title {
            font-family: 'Sora', sans-serif;
            font-size: 0.8rem;
            font-weight: 800;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .inspeksi-section-title i {
            color: var(--blue);
            font-size: 0.9rem;
        }

        .info-card-group {
            background: #f8fafc;
            border-radius: 20px;
            padding: 20px;
            border: 1px solid var(--gray-200);
            margin-bottom: 24px;
        }

        .info-item {
            margin-bottom: 14px;
        }

        .info-item:last-child {
            margin-bottom: 0;
        }

        .info-label {
            font-size: 0.68rem;
            font-weight: 800;
            color: var(--gray-400);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--gray-800);
        }

        .info-row-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        /* Berkas Cloud View Box */
        .berkas-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 24px;
        }

        .berkas-card {
            background: #fff;
            border: 1px solid var(--gray-200);
            border-radius: 14px;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: var(--transition);
        }

        .berkas-card:hover {
            border-color: var(--blue);
            box-shadow: var(--shadow-sm);
        }

        .berkas-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .berkas-icon {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--green-bg);
            color: var(--green);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
        }

        .berkas-name {
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--gray-700);
        }

        .berkas-link {
            font-size: 0.75rem;
            font-weight: 800;
            color: var(--primary);
            text-decoration: none;
            letter-spacing: 0.5px;
            cursor: pointer;
        }

        .berkas-link:hover {
            color: var(--blue);
        }

        .control-panel {
            background: var(--dark-panel);
            border-radius: 24px;
            padding: 24px;
            color: #fff;
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.15);
        }

        .control-panel-header {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.72rem;
            font-weight: 800;
            color: #f5a623;
            letter-spacing: 0.8px;
            margin-bottom: 16px;
        }

        .btn-validate-trigger {
            width: 100%;
            padding: 16px;
            background: #f5a623;
            color: #fff;
            border: none;
            border-radius: 14px;
            font-family: 'Sora', sans-serif;
            font-size: 0.9rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: var(--transition);
        }

        .btn-validate-trigger:hover {
            background: #e09216;
            transform: translateY(-1px);
        }

        .validation-actions {
            display: none;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            animation: fadeInBlock 0.3s ease;
        }

        .validation-actions.active {
            display: grid;
        }

        .btn-decision {
            padding: 16px;
            border: none;
            border-radius: 14px;
            font-family: 'Sora', sans-serif;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: #fff;
            transition: var(--transition);
        }

        .btn-decision.approve {
            background: #22c55e;
        }

        .btn-decision.approve:hover {
            background: #16a34a;
            transform: translateY(-1px);
        }

        .btn-decision.reject {
            background: #ef4444;
        }

        .btn-decision.reject:hover {
            background: #dc2626;
            transform: translateY(-1px);
        }

        /* PREVIEW POPUP NESTED */
        .preview-container {
            text-align: center;
            background: #f8fafc;
            border: 1.5px dashed var(--gray-300);
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 20px;
            min-height: 260px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .preview-image-element {
            max-width: 100%;
            max-height: 380px;
            object-fit: contain;
            border-radius: 8px;
            box-shadow: var(--shadow-sm);
        }

        .modal-backdrop-nested {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            z-index: 1100;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-backdrop-nested.open {
            display: flex;
        }

        @keyframes fadeInBlock {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .toast-container {
            position: fixed;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%);

            z-index: 2000;

            display: flex;
            flex-direction: column;
            gap: 10px;

            align-items: center;
        }

        .toast {
            display: flex;
            align-items: center;
            gap: 10px;

            background: linear-gradient(135deg, #3b82f6, #1d4ed8, #1e3a8a);
            color: white;

            border-radius: 12px;
            padding: 14px 18px;

            box-shadow: var(--shadow-lg);

            min-width: 280px;

            animation: slideUp .3s cubic-bezier(.4, 0, .2, 1);

            font-size: .85rem;
            font-weight: 600;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .toast.success {
            border-color: var(--green);
        }

        .toast.success i {
            color: var(--green);
        }

        .toast.error {
            border-color: var(--red);
        }

        .toast.error i {
            color: var(--red);
        }

        .page-section {
            display: none;
        }

        .page-section.active {
            display: block;
        }

        footer {
            text-align: center;
            padding: 18px;
            font-size: .72rem;
            color: var(--gray-400);
            font-weight: 500;
            letter-spacing: .5px;
            border-top: 1px solid var(--gray-200);
            position: relative;
            z-index: 1;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .spin {
            animation: spin 1s linear infinite;
            display: inline-block;
        }

        @media (max-width: 900px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .modal.modal-wide .modal-body {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .berkas-grid {
                grid-template-columns: 1fr;
            }
        }

        /* ===================== LOGOUT MODAL CUSTOM ===================== */
        .logout-modal {
            max-width: 500px;
            border-radius: 28px;
            padding: 36px 40px 32px;
            text-align: center;
        }

        .logout-modal .modal-header {
            padding: 0;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
        }

        .logout-icon-circle {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            background: #fff1f2;
            color: var(--red);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            margin: 0 auto 22px;
        }

        .logout-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 12px;
        }

        .logout-desc {
            font-size: .95rem;
            color: #7b86a8;
            line-height: 1.65;
            margin-bottom: 28px;
        }

        .logout-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .btn-logout-cancel,
        .btn-logout-confirm {
            height: 52px;
            border-radius: 14px;
            font-size: .95rem;
            font-weight: 800;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            transition: all .2s ease;
        }

        .btn-logout-cancel {
            background: #f7f8fc;
            color: #1e293b;
            border: 1.5px solid #e0e4ef;
        }

        .btn-logout-cancel:hover {
            background: #eef2f8;
        }

        .btn-logout-confirm {
            background: #1d2d78;
            color: #ffffff;
            border: none;
        }

        .btn-logout-confirm:hover {
            background: #14215e;
            transform: translateY(-1px);
        }


        /* ===== ADMIN RIWAYAT DETAIL ===== */
        .riwayat-toolbar {
            display: grid;
            grid-template-columns: 1.4fr .75fr .75fr;
            gap: 12px;
            margin-bottom: 18px;
        }

        .riwayat-filter {
            width: 100%;
            height: 44px;
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            padding: 0 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            color: var(--gray-600);
            background: #fff;
            outline: none;
        }

        .riwayat-filter:focus,
        .riwayat-search input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(15, 42, 94, .08);
        }

        .riwayat-search {
            position: relative;
        }

        .riwayat-search i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
            font-size: .85rem;
        }

        .riwayat-search input {
            width: 100%;
            height: 44px;
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            padding: 0 14px 0 40px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            color: var(--gray-600);
            outline: none;
        }

        .riwayat-summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 18px;
        }

        .riwayat-summary-card {
            background: #fff;
            border: 1px solid var(--gray-200);
            border-radius: 16px;
            padding: 16px;
            box-shadow: var(--shadow-sm);
        }

        .riwayat-summary-label {
            font-size: .68rem;
            color: var(--gray-400);
            font-weight: 800;
            letter-spacing: .7px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .riwayat-summary-number {
            font-size: 1.45rem;
            color: var(--primary);
            font-weight: 900;
        }

        .riwayat-table-wrap {
            overflow-x: auto;
        }

        .riwayat-table th,
        .riwayat-table td {
            white-space: nowrap;
        }

        .riwayat-table td:nth-child(2) {
            min-width: 190px;
        }

        .riwayat-total {
            font-weight: 900;
            color: var(--primary);
        }

        .riwayat-detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .riwayat-detail-item {
            background: var(--gray-50);
            border: 1px solid var(--gray-200);
            border-radius: 14px;
            padding: 14px;
        }

        .riwayat-detail-label {
            font-size: .68rem;
            color: var(--gray-400);
            font-weight: 900;
            letter-spacing: .6px;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .riwayat-detail-value {
            color: var(--gray-800);
            font-weight: 800;
            line-height: 1.4;
            word-break: break-word;
        }

        .riwayat-detail-item.full {
            grid-column: 1 / -1;
        }

        @media (max-width: 900px) {
            .riwayat-toolbar,
            .riwayat-summary-grid,
            .riwayat-detail-grid {
                grid-template-columns: 1fr;
            }
        }


        /* ===== ADMIN PUSAT BANTUAN - STYLE ROLE ADMIN ===== */
        .admin-help-card {
            background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
            border: 1px solid var(--gray-200);
            border-radius: 24px;
            padding: 34px;
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            position: relative;
        }

        .admin-help-card::before {
            content: '';
            position: absolute;
            top: -90px;
            right: -90px;
            width: 260px;
            height: 260px;
            background: radial-gradient(circle, rgba(245, 166, 35, .14), transparent 68%);
            pointer-events: none;
        }

        .admin-help-hero {
            position: relative;
            z-index: 1;
            background: var(--primary);
            border-radius: 22px;
            padding: 30px 32px;
            color: #ffffff;
            display: grid;
            grid-template-columns: 1.25fr .9fr;
            gap: 26px;
            align-items: center;
            margin-bottom: 30px;
            box-shadow: 0 18px 38px rgba(15, 42, 94, .18);
        }

        .admin-help-hero-badge {
            width: fit-content;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(245, 166, 35, .14);
            border: 1px solid rgba(245, 166, 35, .32);
            color: #ffd89b;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: .72rem;
            font-weight: 900;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 14px;
        }

        .admin-help-hero h2 {
            font-size: clamp(1.55rem, 2vw, 2.2rem);
            line-height: 1.12;
            font-weight: 900;
            letter-spacing: -.6px;
            margin-bottom: 10px;
        }

        .admin-help-hero p {
            max-width: 640px;
            color: rgba(255, 255, 255, .72);
            font-size: .95rem;
            line-height: 1.65;
            font-weight: 600;
        }

        .admin-help-hero-icon {
            width: 118px;
            height: 118px;
            border-radius: 32px;
            background: rgba(255, 255, 255, .09);
            border: 1px solid rgba(255, 255, 255, .14);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: auto;
            color: var(--accent);
            font-size: 48px;
        }

        .admin-help-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .admin-help-stat {
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .13);
            border-radius: 16px;
            padding: 16px;
        }

        .admin-help-stat strong {
            display: block;
            color: #ffffff;
            font-size: .92rem;
            font-weight: 900;
            margin-bottom: 4px;
        }

        .admin-help-stat span {
            display: block;
            color: rgba(255, 255, 255, .6);
            font-size: .72rem;
            line-height: 1.45;
            font-weight: 700;
        }

        .admin-help-grid {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 1.35fr .9fr;
            gap: 28px;
            align-items: start;
        }

        .admin-help-section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.35rem;
            font-weight: 900;
            color: var(--primary);
            margin-bottom: 18px;
            letter-spacing: -.3px;
        }

        .admin-help-section-title i {
            color: var(--accent);
            font-size: 1rem;
        }

        .admin-faq-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
            margin-bottom: 24px;
        }

        .admin-faq-card {
            background: #f8fafc;
            border: 1px solid var(--gray-200);
            border-radius: 18px;
            padding: 20px 22px;
            transition: var(--transition);
        }

        .admin-faq-card:hover {
            transform: translateY(-2px);
            background: #ffffff;
            border-color: rgba(15, 42, 94, .14);
            box-shadow: 0 8px 24px rgba(15, 42, 94, .06);
        }

        .admin-faq-question {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: .96rem;
            font-weight: 900;
            color: var(--primary);
            margin-bottom: 9px;
        }

        .admin-faq-question i {
            width: 26px;
            height: 26px;
            border-radius: 999px;
            background: rgba(245, 166, 35, .14);
            color: var(--accent);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: .74rem;
            flex-shrink: 0;
        }

        .admin-faq-answer {
            font-size: .88rem;
            line-height: 1.72;
            color: var(--gray-500);
            font-weight: 600;
            padding-left: 36px;
        }

        .admin-guide-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
        }

        .admin-guide-card {
            background: #ffffff;
            border: 1px solid var(--gray-200);
            border-radius: 18px;
            padding: 18px;
            transition: var(--transition);
        }

        .admin-guide-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(15, 42, 94, .06);
        }

        .admin-guide-icon {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: #fff7ed;
            color: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            font-size: 1rem;
        }

        .admin-guide-title {
            color: var(--primary);
            font-size: .92rem;
            font-weight: 900;
            margin-bottom: 6px;
        }

        .admin-guide-desc {
            color: var(--gray-500);
            font-size: .78rem;
            line-height: 1.55;
            font-weight: 600;
        }

        .admin-contact-card {
            background: var(--primary);
            border-radius: 20px;
            padding: 28px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            box-shadow: 0 14px 34px rgba(15, 42, 94, .20);
            position: sticky;
            top: 18px;
        }

        .admin-contact-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .admin-contact-icon {
            width: 44px;
            height: 44px;
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .10);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            font-size: 17px;
            flex-shrink: 0;
        }

        .admin-contact-title {
            font-size: .94rem;
            font-weight: 900;
            color: #ffffff;
            margin-bottom: 5px;
        }

        .admin-contact-sub {
            font-size: .8rem;
            font-weight: 600;
            color: rgba(255, 255, 255, .66);
            line-height: 1.55;
        }

        .admin-contact-sub a {
            color: rgba(255, 255, 255, .82);
            text-decoration: none;
        }

        .admin-contact-sub a:hover {
            color: #ffffff;
        }

        .admin-btn-operator {
            margin-top: 4px;
            background: var(--accent);
            color: var(--primary);
            border: none;
            border-radius: 15px;
            padding: 16px 22px;
            font-size: .84rem;
            font-weight: 900;
            letter-spacing: .8px;
            text-transform: uppercase;
            text-align: center;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            transition: var(--transition);
        }

        .admin-btn-operator:hover {
            background: #f3b64c;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(245, 166, 35, .32);
        }

        .admin-note-card {
            background: #fff7ed;
            border: 1px solid #fed7aa;
            color: #9a5a00;
            border-radius: 18px;
            padding: 18px 20px;
            margin-top: 18px;
            font-size: .84rem;
            line-height: 1.65;
            font-weight: 700;
        }

        .admin-note-card strong {
            color: var(--primary);
        }

        @media (max-width: 980px) {
            .admin-help-hero,
            .admin-help-grid {
                grid-template-columns: 1fr;
            }

            .admin-help-hero-icon {
                margin-left: 0;
            }

            .admin-contact-card {
                position: relative;
                top: auto;
            }
        }

        @media (max-width: 640px) {
            .admin-help-card {
                padding: 24px 18px;
            }

            .admin-help-hero {
                padding: 24px 20px;
            }

            .admin-help-stats,
            .admin-guide-grid {
                grid-template-columns: 1fr;
            }

            .admin-faq-answer {
                padding-left: 0;
            }
        }

    </style>
</head>

<body>
    <div class="page-wrapper">
        <div class="bg-decor"></div>

        <!-- ===== NAVBAR ===== -->
        <nav class="navbar">
            <div class="navbar-inner">
                <div class="brand-logo-box" id="fallback-logo"><img src="{{ asset('img/E-Kanisius 1.png') }}"
                        alt="E-Kanisius Logo" style="width:85px; height:auto; object-fit:contain; flex-shrink:0;">
                </div>
                <div class="brand-text">
                    <div class="brand-name">SAKTI PORTAL</div>
                    <div class="brand-meta"><span class="dot"></span><span>ADMIN</span><span
                            class="brand-uid">UID-MOCK-admin-001</span></div>
                </div>
                </a>
                <nav class="nav-links">
                    <button class="nav-link active" id="nav-dashboard" onclick="switchPage('dashboard')">Dashboard <span
                            class="nav-badge" id="badge-pending">1</span></button>
                    <button class="nav-link" id="nav-riwayat" onclick="switchPage('riwayat')"> Riwayat</button>
                    <button class="nav-link" id="nav-bantuan" onclick="switchPage('bantuan')">Pusat Bantuan</button>
                </nav>
                <div class="nav-user" onclick="openModal('modal-profile')">
                    <div class="nav-user-text">
                        <div class="nav-username">Admin JOG-WRO</div>
                        <div class="nav-branch">JOG-WRO</div>
                    </div>
                    <i class="fas fa-chevron-down" style="color:var(--gray-400);font-size:.75rem;"></i>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>

                <button type="button" class="nav-logout" onclick="handleLogout()">
                    <i class="fas fa-arrow-right-from-bracket"></i>
                </button>
            </div>
        </nav>

        <main>
            <!-- ===== DASHBOARD PAGE ===== -->
            <section class="page-section active" id="page-dashboard">
                <div class="stats-grid">
                    <div class="stat-card blue" onclick="filterTab('semua')">
                        <div class="stat-header"><span class="stat-label">Total Pendaftar</span>
                            <div class="stat-icon"><i class="fas fa-users"></i></div>
                        </div>
                        <div class="stat-number" id="count-total">4</div>
                    </div>
                    <div class="stat-card green" onclick="filterTab('approved')">
                        <div class="stat-header"><span class="stat-label">Diterima</span>
                            <div class="stat-icon"><i class="fas fa-circle-check"></i></div>
                        </div>
                        <div class="stat-number" id="count-approved">1</div>
                    </div>
                    <div class="stat-card red" onclick="filterTab('rejected')">
                        <div class="stat-header"><span class="stat-label">Ditolak</span>
                            <div class="stat-icon"><i class="fas fa-circle-xmark"></i></div>
                        </div>
                        <div class="stat-number" id="count-rejected">1</div>
                    </div>
                    <div class="stat-card orange" onclick="filterTab('proses')">
                        <div class="stat-header"><span class="stat-label">Proses Seleksi</span>
                            <div class="stat-icon"><i class="fas fa-rotate spin"></i></div>
                        </div>
                        <div class="stat-number" id="count-proses">1</div>
                    </div>
                </div>

                <div class="section-header">
                    <div>
                        <div class="section-title">Pusat Verifikasi</div>
                        <div class="section-sub">CABANG PENGELOLAAN: <span>JOG-WRO</span></div>
                    </div>
                    <button class="btn-batch" onclick="openModal('modal-batch')"><i class="fas fa-gear"></i> KELOLA
                        BATCH &amp; KUOTA</button>
                </div>

                <div class="toolbar">
                    <div class="search-wrap">
                        <i class="fas fa-search"></i>
                        <input type="text" class="search-input" id="searchInput"
                            placeholder="Cari Nama, ID, atau NIK..." oninput="handleSearch(this.value)">
                    </div>
                    <div class="filter-tabs">
                        <button class="filter-tab active" id="tab-semua" onclick="filterTab('semua')">SEMUA</button>
                        <button class="filter-tab" id="tab-proses" onclick="filterTab('proses')">PROSES</button>
                        <button class="filter-tab" id="tab-approved" onclick="filterTab('approved')">APPROVED</button>
                        <button class="filter-tab" id="tab-rejected" onclick="filterTab('rejected')">REJECTED</button>
                        <button class="filter-tab" id="tab-draft" onclick="filterTab('draft')">DRAFT</button>
                    </div>
                </div>

                <div class="table-card">
                    <div class="table-container">
                        <table id="mainTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Calon Peserta</th>
                                    <th>NIK / Identitas</th>
                                    <th>Tanggal Submit</th>
                                    <th>Status Berkas</th>
                                    <th style="width:120px; text-align:right;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody"></tbody>
                        </table>
                    </div>
                    <div class="pagination-bar">
                        <div class="pagination-info" id="paginationInfo">Showing 0 to 0 of 0 entries</div>
                        <div class="pagination-btns" id="paginationBtns"></div>
                    </div>
                </div>
            </section>

            <!-- RIWAYAT ADMIN DETAIL -->
            <section class="page-section" id="page-riwayat">
                <div class="section-header">
                    <div>
                        <div class="section-title">Riwayat Verifikasi</div>
                        <div class="section-sub">DETAIL APPROVAL, REJECTED, INVOICE, DAN GELOMBANG PENDAFTARAN</div>
                    </div>
                </div>

                <div class="riwayat-summary-grid">
                    <div class="riwayat-summary-card">
                        <div class="riwayat-summary-label">Total Riwayat</div>
                        <div class="riwayat-summary-number" id="riwayat-total-count">0</div>
                    </div>
                    <div class="riwayat-summary-card">
                        <div class="riwayat-summary-label">Approved</div>
                        <div class="riwayat-summary-number" id="riwayat-approved-count">0</div>
                    </div>
                    <div class="riwayat-summary-card">
                        <div class="riwayat-summary-label">Rejected</div>
                        <div class="riwayat-summary-number" id="riwayat-rejected-count">0</div>
                    </div>
                    <div class="riwayat-summary-card">
                        <div class="riwayat-summary-label">Total Invoice</div>
                        <div class="riwayat-summary-number" id="riwayat-invoice-total">Rp0</div>
                    </div>
                </div>

                <div class="table-card" style="padding:18px;">
                    <div class="riwayat-toolbar">
                        <div class="riwayat-search">
                            <i class="fas fa-search"></i>
                            <input type="text" id="riwayatSearchInput" placeholder="Cari nama, NIK, atau nomor registrasi..."
                                oninput="renderRiwayatTable()">
                        </div>

                        <select class="riwayat-filter" id="riwayatBatchFilter" onchange="renderRiwayatTable()">
                            <option value="semua">Semua Gelombang</option>
                            @foreach(($batchList ?? collect()) as $batchItem)
                                <option value="{{ $batchItem->uid }}">{{ $batchItem->nama_batch ?? ('Batch ' . $batchItem->uid) }}</option>
                            @endforeach
                            <option value="tanpa_batch">Tanpa Batch</option>
                        </select>

                        <select class="riwayat-filter" id="riwayatStatusFilter" onchange="renderRiwayatTable()">
                            <option value="semua">Semua Status</option>
                            <option value="proses">Proses</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>

                    <div class="riwayat-table-wrap">
                        <table class="riwayat-table" id="riwayatTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Calon Peserta</th>
                                    <th>Gelombang</th>
                                    <th>Tanggal Submit</th>
                                    <th>Tanggal Approval/Reject</th>
                                    <th>Admin</th>
                                    <th>Status</th>
                                    <th>Total Invoice</th>
                                    <th style="width:100px; text-align:right;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="riwayatTableBody"></tbody>
                        </table>
                    </div>

                    <div class="pagination-bar">
                        <div class="pagination-info" id="riwayatPaginationInfo">Showing 0 to 0 of 0 entries</div>
                    </div>
                </div>
            </section>
            <section class="page-section" id="page-bantuan">
                <div class="section-header">
                    <div>
                        <div class="section-title">Pusat Bantuan Admin</div>
                        <div class="section-sub">PANDUAN OPERASIONAL VERIFIKASI PENDAFTARAN</div>
                    </div>
                </div>

                <div class="admin-help-card">
                    <div class="admin-help-hero">
                        <div>
                            <div class="admin-help-hero-badge">
                                <i class="fa-solid fa-shield-halved"></i>
                                Admin Help Center
                            </div>
                            <h2>Pusat Bantuan SAKTI untuk Admin</h2>
                            <p>
                                Gunakan halaman ini sebagai panduan cepat untuk mengelola verifikasi berkas,
                                approval, rejection, invoice, riwayat, serta pengaturan batch dan kuota pendaftaran.
                            </p>
                        </div>

                        <div>
                            <div class="admin-help-hero-icon">
                                <i class="fa-solid fa-headset"></i>
                            </div>
                            <div class="admin-help-stats" style="margin-top:16px;">
                                <div class="admin-help-stat">
                                    <strong>Verifikasi</strong>
                                    <span>Cek detail data dan berkas siswa.</span>
                                </div>
                                <div class="admin-help-stat">
                                    <strong>Batch</strong>
                                    <span>Atur gelombang dan sisa kuota.</span>
                                </div>
                                <div class="admin-help-stat">
                                    <strong>Riwayat</strong>
                                    <span>Lihat log approve dan reject.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="admin-help-grid">
                        <div>
                            <h2 class="admin-help-section-title">
                                <i class="fa-solid fa-circle-question"></i>
                                FAQ Admin
                            </h2>

                            <div class="admin-faq-list">
                                <div class="admin-faq-card">
                                    <div class="admin-faq-question">
                                        <i class="fa-solid fa-file-circle-check"></i>
                                        Bagaimana alur verifikasi pendaftar?
                                    </div>
                                    <div class="admin-faq-answer">
                                        Buka menu Dashboard, klik tombol detail pada calon peserta, periksa data siswa,
                                        identitas, berkas, dan informasi tagihan. Setelah valid, pilih Approve. Jika ada
                                        berkas yang belum sesuai, pilih Rejected dan tuliskan alasan penolakan dengan jelas.
                                    </div>
                                </div>

                                <div class="admin-faq-card">
                                    <div class="admin-faq-question">
                                        <i class="fa-solid fa-ban"></i>
                                        Kapan admin harus memilih Rejected?
                                    </div>
                                    <div class="admin-faq-answer">
                                        Gunakan Rejected jika berkas tidak sesuai, data identitas tidak valid, dokumen tidak
                                        terbaca, atau batch sudah penuh. Alasan rejected akan menjadi informasi untuk orang tua
                                        agar mereka memahami tindak lanjut yang perlu dilakukan.
                                    </div>
                                </div>

                                <div class="admin-faq-card">
                                    <div class="admin-faq-question">
                                        <i class="fa-solid fa-layer-group"></i>
                                        Bagaimana cara mengelola batch dan kuota?
                                    </div>
                                    <div class="admin-faq-answer">
                                        Klik tombol Kelola Batch &amp; Kuota pada Dashboard Admin. Dari sana admin dapat
                                        menambah gelombang, mengubah status aktif, menutup batch, dan menyesuaikan kuota
                                        agar jumlah pendaftar tidak melebihi kapasitas.
                                    </div>
                                </div>

                                <div class="admin-faq-card">
                                    <div class="admin-faq-question">
                                        <i class="fa-solid fa-clock-rotate-left"></i>
                                        Di mana melihat riwayat approval dan rejection?
                                    </div>
                                    <div class="admin-faq-answer">
                                        Masuk ke menu Riwayat untuk melihat nama siswa, tanggal submit, tanggal approve atau
                                        rejected, admin verifikator, status, batch, alasan penolakan, dan total nominal invoice.
                                    </div>
                                </div>
                            </div>

                            <h2 class="admin-help-section-title" style="margin-top:8px;">
                                <i class="fa-solid fa-list-check"></i>
                                Panduan Cepat
                            </h2>

                            <div class="admin-guide-grid">
                                <div class="admin-guide-card">
                                    <div class="admin-guide-icon"><i class="fa-solid fa-eye"></i></div>
                                    <div class="admin-guide-title">Cek Detail Pendaftar</div>
                                    <div class="admin-guide-desc">Gunakan ikon mata pada tabel untuk membuka data lengkap dan dokumen siswa.</div>
                                </div>
                                <div class="admin-guide-card">
                                    <div class="admin-guide-icon"><i class="fa-solid fa-check"></i></div>
                                    <div class="admin-guide-title">Approve Berkas</div>
                                    <div class="admin-guide-desc">Approve hanya jika data, dokumen, batch, dan invoice sudah sesuai.</div>
                                </div>
                                <div class="admin-guide-card">
                                    <div class="admin-guide-icon"><i class="fa-solid fa-xmark"></i></div>
                                    <div class="admin-guide-title">Reject Berkas</div>
                                    <div class="admin-guide-desc">Berikan alasan spesifik agar orang tua tahu dokumen mana yang perlu diperbaiki.</div>
                                </div>
                                <div class="admin-guide-card">
                                    <div class="admin-guide-icon"><i class="fa-solid fa-receipt"></i></div>
                                    <div class="admin-guide-title">Invoice</div>
                                    <div class="admin-guide-desc">Invoice muncul untuk data yang sudah disetujui dan dapat dicek melalui detail riwayat.</div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h2 class="admin-help-section-title">
                                <i class="fa-solid fa-headset"></i>
                                Kontak &amp; Eskalasi
                            </h2>

                            <div class="admin-contact-card">
                                <div class="admin-contact-item">
                                    <div class="admin-contact-icon">
                                        <i class="fa-brands fa-whatsapp"></i>
                                    </div>
                                    <div>
                                        <div class="admin-contact-title">Operator SPMB</div>
                                        <div class="admin-contact-sub">
                                            WhatsApp: <a href="https://wa.me/6281234567890" target="_blank" rel="noopener">+62 812-3456-7890</a><br>
                                            Gunakan untuk koordinasi kendala verifikasi, batch, dan data pendaftar.
                                        </div>
                                    </div>
                                </div>

                                <div class="admin-contact-item">
                                    <div class="admin-contact-icon">
                                        <i class="fa-solid fa-building-columns"></i>
                                    </div>
                                    <div>
                                        <div class="admin-contact-title">Sekretariat Yayasan</div>
                                        <div class="admin-contact-sub">
                                            Jl. Imam Bonjol No. 180, Semarang<br>
                                            Layanan administrasi pada jam kerja sekolah.
                                        </div>
                                    </div>
                                </div>

                                <div class="admin-contact-item">
                                    <div class="admin-contact-icon">
                                        <i class="fa-solid fa-clock"></i>
                                    </div>
                                    <div>
                                        <div class="admin-contact-title">Jam Layanan</div>
                                        <div class="admin-contact-sub">
                                            Senin - Jumat, 08.00 - 15.00 WIB.<br>
                                            Di luar jam layanan, data dapat tetap dipantau melalui dashboard.
                                        </div>
                                    </div>
                                </div>

                                <a href="https://wa.me/6281234567890" target="_blank" rel="noopener" class="admin-btn-operator">
                                    <i class="fa-solid fa-headset"></i> Hubungi Operator
                                </a>
                            </div>

                            <div class="admin-note-card">
                                <strong>Catatan:</strong> Halaman bantuan ini khusus role admin. Menu ini tidak membuka akses
                                publik ke dashboard admin dan tidak mengubah sistem login, register, batch, approve, atau reject.
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer>&copy; 2026 SAKTI PORTAL – Sistem Admisi Kanisius Terintegrasi. Dashboard v2.4.0-PROD</footer>
    </div>




    <!-- ======================================================== -->
    <!-- ===== MODAL DETAIL / POP UP INSPEKSI BERKAS        ===== -->
    <!-- ======================================================== -->
    <div class="modal-backdrop" id="modal-detail">
        <div class="modal modal-wide">
            <div class="modal-header">
                <div class="inspeksi-title-block">
                    <div class="inspeksi-icon-badge"><i class="fas fa-shield-halved"></i></div>
                    <div class="inspeksi-title-text">
                        <h2>Verivikasi Berkas</h2>
                        <p id="det-reg-id">ADMINISTRATIVE DATA REVIEW • REG-MOCK-PARENT-001</p>
                    </div>
                </div>
                <button class="modal-close" onclick="closeModal('modal-detail')"><i class="fas fa-times"></i></button>
            </div>

            <div class="modal-body">
                <!-- SISI KIRI: BIODATA INPUT FORM SISWA -->
                <div>
                    <div class="inspeksi-section-title"><i class="fas fa-user-check"></i> Biodata Calon Siswa</div>
                    <div class="info-card-group">
                        <div class="info-item">
                            <div class="info-label">Nama Lengkap</div>
                            <div class="info-value" id="det-nama">-</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">N.I.K</div>
                            <div class="info-value" id="det-nik">-</div>

                        </div>

                        <div class="info-item">
                            <div class="info-label">Tgl Lahir</div>
                            <div class="info-value" id="det-tanggal-lahir">-</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Tempat Lahir</div>
                            <div class="info-value" id="det-tempat-lahir">-</div>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Alamat</div>
                            <div class="info-value" id="det-alamat">-</div>
                        </div>



                        <div class="info-row-grid">
                            <div class="info-item">
                                <div class="info-label">Agama</div>
                                <div class="info-value" id="det-agama">-</div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Gol. Darah</div>
                                <div class="info-value" id="det-gol-darah">-</div>
                            </div>

                        </div>

                    </div>


                    <div class="inspeksi-section-title"><i class="fas fa-users"></i> Data Orang Tua / Wali</div>
                    <div class="info-card-group">
                        <div class="info-item">
                            <div class="info-label">Nama</div>
                            <div class="info-value" id="det-ortu-nama">-</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">No Telepon</div>
                            <div class="info-value" id="det-ortu-telp">-</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Email</div>
                            <div class="info-value" id="det-ortu-email">-</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Pendidikan</div>
                            <div class="info-value" id="det-ortu-pendidikan">-</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Gaji</div>
                            <div class="info-value" id="det-ortu-gaji">-</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Alamat</div>
                            <div class="info-value" id="det-ortu-alamat" style="white-space: pre-wrap;">-</div>
                        </div>
                    </div>
                </div>

                <!-- SISI KANAN: PREVIEW BERKAS DIGITAL (AMBIL DATA DARI DATABASE) -->
                <div>
                    <div class="inspeksi-section-title"><i class="fas fa-cloud-arrow-up"></i> Preview Berkas Digital
                        (Cloud View)</div>

                    <!-- Berkas Grid - ID link diubah agar dapat disuntik URL Database melalui JS -->
                    <div class="berkas-grid">
                        <div class="berkas-card">
                            <div class="berkas-info">
                                <div class="berkas-icon"><i class="fas fa-check"></i></div>
                                <span class="berkas-name">Kartu Keluarga</span>
                            </div>
                            <span class="berkas-link" id="link-kk">LIHAT</span>
                        </div>
                        <div class="berkas-card">
                            <div class="berkas-info">
                                <div class="berkas-icon"><i class="fas fa-check"></i></div>
                                <span class="berkas-name">Akte Kelahiran</span>
                            </div>
                            <span class="berkas-link" id="link-akte">LIHAT</span>
                        </div>
                        <div class="berkas-card">
                            <div class="berkas-info">
                                <div class="berkas-icon"><i class="fas fa-check"></i></div>
                                <span class="berkas-name">E-KTP Orang Tua</span>
                            </div>
                            <span class="berkas-link" id="link-ktp">LIHAT</span>
                        </div>
                        <div class="berkas-card">
                            <div class="berkas-info">
                                <div class="berkas-icon"><i class="fas fa-check"></i></div>
                                <span class="berkas-name">Pas Foto (3x4)</span>
                            </div>
                            <span class="berkas-link" id="link-foto">LIHAT</span>
                        </div>
                        <div class="berkas-card" style="grid-column: span 2;">
                            <div class="berkas-info">
                                <div class="berkas-icon"><i class="fas fa-check"></i></div>
                                <span class="berkas-name">Surat Baptis</span>
                            </div>
                            <span class="berkas-link" id="link-baptis">LIHAT</span>
                        </div>
                    </div>

                    <div class="control-panel">
                        <div class="control-panel-header"><i class="fas fa-terminal"></i> ADMINISTRATIVE CONTROL PANEL
                        </div>
                        <button class="btn-validate-trigger" id="btnValidateTrigger"
                            onclick="activateValidationChoices()"><i class="fas fa-shield-check"></i> Validasi Semua
                            Berkas</button>
                        <div class="validation-actions" id="validationActionsBlock">
                            <button class="btn-decision approve" onclick="submitValidationDecision('approved')">
                                <i class="fas fa-circle-check"></i> Loloskan</button>
                            <button class="btn-decision reject" onclick="showRejectReason()">
                                <i class="fas fa-circle-xmark"></i> Gagalkan</button>
                        </div>

                        <!-- Alasan Reject (Muncul saat validasi ditrigger) -->
                        <div id="reject-reason-wrap" style="display:none; margin-top:14px;">
                            <div class="form-group" style="margin-bottom:10px;">
                                <label class="form-label">Alasan Ditolak</label>

                                <textarea id="reject-alasan" class="form-control" style="height:92px; resize:none;"
                                    placeholder="Masukkan alasan penolakan..."></textarea>
                            </div>

                            <div class="form-group" style="margin-bottom:14px;">
                                <label class="form-label">Berkas yang Tidak Sesuai</label>

                                <label style="display:block; color:white; font-size:13px; margin-bottom:6px;">
                                    <input type="checkbox" class="berkas-invalid" value="Kartu Keluarga">
                                    Kartu Keluarga
                                </label>

                                <label style="display:block; color:white; font-size:13px; margin-bottom:6px;">
                                    <input type="checkbox" class="berkas-invalid" value="Akte Kelahiran">
                                    Akte Kelahiran
                                </label>

                                <label style="display:block; color:white; font-size:13px; margin-bottom:6px;">
                                    <input type="checkbox" class="berkas-invalid" value="E-KTP Orang Tua">
                                    E-KTP Orang Tua
                                </label>

                                <label style="display:block; color:white; font-size:13px; margin-bottom:6px;">
                                    <input type="checkbox" class="berkas-invalid" value="Pas Foto">
                                    Pas Foto
                                </label>

                                <label style="display:block; color:white; font-size:13px; margin-bottom:6px;">
                                    <input type="checkbox" class="berkas-invalid" value="Surat Baptis">
                                    Surat Baptis
                                </label>
                            </div>

                            <button class="btn-decision reject" style="width:100%;"
                                onclick="submitValidationDecision('rejected')">

                                <i class="fas fa-paper-plane"></i>
                                Kirim Penolakan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- =============================================================== -->
    <!-- ===== POP UP NESTED: PREVIEW GAMBAR BERKAS & SIMPAN DOWNLOAD   ===== -->
    <!-- =============================================================== -->
    <div class="modal-backdrop-nested" id="modal-file-preview">
        <div class="modal" style="max-width: 480px;">
            <div class="modal-header" style="padding: 20px 24px 0;">
                <div class="modal-title" id="preview-file-title"><i class="fas fa-file-image"
                        style="color:var(--blue); margin-right:8px;"></i>Pratinjau Dokumen</div>
                <button class="modal-close" onclick="closeFilePreview()"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body" style="padding: 16px 24px;">
                <div class="preview-container">
                    <img src="" id="preview-image-target" class="preview-image-element" alt="Preview Dokumen">
                </div>
            </div>
            <div class="modal-footer" style="padding: 0 24px 20px;">
                <button class="btn btn-secondary" style="font-size: 0.8rem; padding: 8px 16px;"
                    onclick="closeFilePreview()">Tutup</button>
                <button class="btn btn-primary" style="font-size: 0.8rem; padding: 8px 16px; background: var(--blue);"
                    onclick="downloadFileToComputer()">
                    <i class="fas fa-download"></i> Simpan ke Komputer
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL PROFILE & BATCH OVERLAY -->
    <div class="modal-backdrop" id="modal-profile">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-title">Profil Admin</div><button class="modal-close"
                    onclick="closeModal('modal-profile')"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <p>Super Admin Unit JOG-WRO</p>
            </div>
        </div>
    </div>

    <!-- Batch & Kuota Modal -->
    <div class="modal-backdrop" id="modal-batch">
        <div class="modal" style="max-width:620px">
            <div class="modal-header">
                <div class="modal-title">
                    <i class="fas fa-gear" style="color:var(--orange);margin-right:8px"></i>
                    Kelola Batch &amp; Kuota
                </div>

                <div style="display:flex; align-items:center; gap:10px;">
                    <button type="button" onclick="prepareCreateBatch()" title="Tambah Gelombang" style="
                width:32px;
                height:32px;
                border-radius:8px;
                border:none;
                background:var(--primary);
                color:white;
                cursor:pointer;
                display:flex;
                align-items:center;
                justify-content:center;
                font-size:.85rem;
            ">
                        <i class="fas fa-plus"></i>
                    </button>

                    <button class="modal-close" onclick="closeModal('modal-batch')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="modal-body">

                <input type="hidden" id="batch-id" value="{{ $batch->uid ?? '' }}">

                <div class="form-group">
                    <label class="form-label">Nama Batch</label>
                    <input type="text" class="form-control" id="batch-name"
                        value="{{ $batch->nama_batch ?? 'Gelombang 1 Tahun Ajaran 2026/2027' }}">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Tanggal Buka</label>
                        <input type="date" class="form-control" id="batch-open"
                            value="{{ $batch->tanggal_buka ?? '' }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tanggal Tutup</label>
                        <input type="date" class="form-control" id="batch-close"
                            value="{{ $batch->tanggal_tutup ?? '' }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Kuota Total</label>
                        <input type="number" class="form-control" id="batch-quota" value="{{ $batch->kuota ?? 100 }}"
                            min="0">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status Batch</label>
                        <select class="form-control" id="batch-status">
                            <option value="1" {{ ($batch->is_active ?? 1) == 1 ? 'selected' : '' }}>
                                Aktif
                            </option>
                            <option value="0" {{ ($batch->is_active ?? 1) == 0 ? 'selected' : '' }}>
                                Tutup
                            </option>
                        </select>
                    </div>
                </div>

                @if(isset($batchList) && $batchList->count() > 0)
                    <div style="margin-top:22px;">
                        <div style="font-weight:800; color:#0f2a5e; margin-bottom:12px;">
                            Statistik Pendaftar per Gelombang
                        </div>

                        @foreach($batchList as $item)
                            <div id="batch-card-{{ $item->uid }}" class="batch-row" onclick="editBatchFromCard(this)"
                                data-uid="{{ $item->uid }}" data-nama="{{ $item->nama_batch }}"
                                data-tanggal-buka="{{ $item->tanggal_buka }}" data-tanggal-tutup="{{ $item->tanggal_tutup }}"
                                data-kuota="{{ $item->kuota }}" data-active="{{ $item->is_active }}" style="
                                                                display:flex;
                                                                justify-content:space-between;
                                                                align-items:center;
                                                                padding:12px 14px;
                                                                border:1px solid #e2e8f0;
                                                                border-radius:12px;
                                                                margin-bottom:8px;
                                                                background:#f8fafc;
                                                                gap:12px;
                                                                cursor:pointer;
                                                                transition:0.2s;
                                                            ">
                                <div>
                                    <div class="batch-title" style="font-weight:800; color:#1e293b;">
                                        {{ $item->nama_batch }}
                                    </div>

                                    <div class="batch-date" style="font-size:12px; color:#64748b; margin-top:3px;">
                                        {{ $item->tanggal_buka ?? '-' }} s/d {{ $item->tanggal_tutup ?? '-' }}
                                    </div>
                                </div>

                                <div style="display:flex; align-items:center; gap:12px;">
                                    <div style="text-align:right;">
                                        <div class="batch-quota" style="font-weight:900; color:#0f2a5e;">
                                            {{ $item->total_pendaftar }} / {{ $item->kuota }}
                                        </div>

                                        <div class="batch-sisa" style="font-size:12px; color:#64748b;">
                                            Sisa: {{ $item->sisa_kuota }}
                                        </div>
                                    </div>

                                    @if((int) $item->total_pendaftar === 0)
                                        <button type="button" onclick="event.stopPropagation(); deleteBatch('{{ $item->uid }}')"
                                            style="
                                                                                                        border:none;
                                                                                                        background:#fee2e2;
                                                                                                        color:#dc2626;
                                                                                                        width:34px;
                                                                                                        height:34px;
                                                                                                        border-radius:10px;
                                                                                                        cursor:pointer;
                                                                                                        font-weight:800;
                                                                                                    " title="Hapus batch">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @else
                                        <button type="button" disabled style="
                                                                                                        border:none;
                                                                                                        background:#e5e7eb;
                                                                                                        color:#9ca3af;
                                                                                                        width:34px;
                                                                                                        height:34px;
                                                                                                        border-radius:10px;
                                                                                                        cursor:not-allowed;
                                                                                                    "
                                            title="Tidak bisa dihapus karena sudah ada pendaftar">
                                            <i class="fas fa-lock"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal('modal-batch')">
                    Batal
                </button>

                <button class="btn btn-primary" onclick="saveBatch()">
                    <i class="fas fa-save"></i>
                    Simpan
                </button>
            </div>
        </div>
    </div>


    <!-- Modal Detail Riwayat Admin -->
    <div class="modal-backdrop" id="modal-riwayat-detail">
        <div class="modal modal-wide">
            <div class="modal-header">
                <div class="inspeksi-title-block">
                    <div class="inspeksi-icon-badge"><i class="fas fa-clock-rotate-left"></i></div>
                    <div class="inspeksi-title-text">
                        <h2>Detail Riwayat Verifikasi</h2>
                        <p id="riwayat-detail-subtitle">RANGKUMAN AKTIVITAS ADMIN</p>
                    </div>
                </div>
                <button class="modal-close" onclick="closeModal('modal-riwayat-detail')"><i class="fas fa-times"></i></button>
            </div>

            <div class="modal-body">
                <div class="riwayat-detail-grid" style="width:100%;">
                    <div class="riwayat-detail-item">
                        <div class="riwayat-detail-label">Nama Siswa</div>
                        <div class="riwayat-detail-value" id="rd-nama">-</div>
                    </div>
                    <div class="riwayat-detail-item">
                        <div class="riwayat-detail-label">NIK</div>
                        <div class="riwayat-detail-value" id="rd-nik">-</div>
                    </div>
                    <div class="riwayat-detail-item">
                        <div class="riwayat-detail-label">Nomor Registrasi</div>
                        <div class="riwayat-detail-value" id="rd-reg">-</div>
                    </div>
                    <div class="riwayat-detail-item">
                        <div class="riwayat-detail-label">Gelombang / Batch</div>
                        <div class="riwayat-detail-value" id="rd-batch">-</div>
                    </div>
                    <div class="riwayat-detail-item">
                        <div class="riwayat-detail-label">Tanggal Submit</div>
                        <div class="riwayat-detail-value" id="rd-submit">-</div>
                    </div>
                    <div class="riwayat-detail-item">
                        <div class="riwayat-detail-label">Tanggal Approval / Reject</div>
                        <div class="riwayat-detail-value" id="rd-verifikasi">-</div>
                    </div>
                    <div class="riwayat-detail-item">
                        <div class="riwayat-detail-label">Diverifikasi Oleh</div>
                        <div class="riwayat-detail-value" id="rd-admin">-</div>
                    </div>
                    <div class="riwayat-detail-item">
                        <div class="riwayat-detail-label">Status Berkas</div>
                        <div class="riwayat-detail-value" id="rd-status">-</div>
                    </div>
                    <div class="riwayat-detail-item">
                        <div class="riwayat-detail-label">Nomor Invoice</div>
                        <div class="riwayat-detail-value" id="rd-invoice-no">-</div>
                    </div>
                    <div class="riwayat-detail-item">
                        <div class="riwayat-detail-label">Total Nominal Invoice</div>
                        <div class="riwayat-detail-value" id="rd-invoice-total">-</div>
                    </div>
                    <div class="riwayat-detail-item full">
                        <div class="riwayat-detail-label">Alasan Rejected</div>
                        <div class="riwayat-detail-value" id="rd-alasan">-</div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal('modal-riwayat-detail')">Tutup</button>
                <button class="btn btn-primary" id="rd-invoice-btn" onclick="openRiwayatInvoice()" style="display:none;">
                    <i class="fas fa-file-invoice"></i> Buka Invoice
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Logout Admin -->
    <div class="modal-backdrop" id="modal-logout">
        <div class="modal logout-modal">
            <div class="modal-header">
                <div class="logout-icon-circle">
                    <i class="fas fa-arrow-right-from-bracket"></i>
                </div>

                <div class="logout-title">
                    Mengakhiri Sesi?
                </div>
            </div>

            <div class="logout-desc">
                Apakah Anda yakin ingin keluar dari SAKTI Portal?<br>
                Sesi Anda akan dihapus demi keamanan akun.
            </div>

            <div class="logout-actions">
                <button type="button" class="btn-logout-cancel" onclick="closeModal('modal-logout')">
                    Batal
                </button>

                <button type="button" class="btn-logout-confirm"
                    onclick="document.getElementById('logout-form').submit()">
                    Ya, Keluar
                </button>
            </div>
        </div>
    </div>

    <div class="toast-container" id="toastContainer"></div>



    <!-- ===== JAVASCRIPT SYSTEM LOGIC ===== -->
    <script>


        /* ===== MOCK DATABASE DATA (SIMULASI STRUKTUR HASIL FORM DAFTAR) ===== */
        // Di aplikasi nyata (Laravel/PHP), array ini disii dari database: JSON_ENCODE($pendaftar)
        let DATA_SISWA = @json($dataSiswa);
        let RIWAYAT_SISWA = @json($riwayatSiswa ?? []);
        let selectedRiwayatInvoiceUrl = '';

        let currentTab = 'semua';
        let searchQuery = '';
        let selectedSiswaId = null;
        let activeDownloadUrl = '';
        let activeDownloadName = '';

        document.addEventListener("DOMContentLoaded", () => {
            renderTable();
            updateStats();
            renderRiwayatTable();
        });

        function handleLogout() {
            openModal('modal-logout');
        }

        function confirmLogout() {
            showToast('Mengakhiri sesi...', 'success');

            const logoutForm = document.getElementById('logout-form');

            if (logoutForm) {
                setTimeout(() => {
                    logoutForm.submit();
                }, 500);
            }
        }

        function switchPage(pageId) {
            document.querySelectorAll('.page-section').forEach(s => s.classList.remove('active'));
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            document.getElementById(`page-${pageId}`).classList.add('active');
            document.getElementById(`nav-${pageId}`).classList.add('active');
        }

        function updateStats() {
            document.getElementById('count-total').innerText = DATA_SISWA.length;
            document.getElementById('count-approved').innerText = DATA_SISWA.filter(s => s.status === 'approved').length;
            document.getElementById('count-rejected').innerText = DATA_SISWA.filter(s => s.status === 'rejected').length;
            document.getElementById('count-proses').innerText = DATA_SISWA.filter(s => s.status === 'proses').length;
            document.getElementById('badge-pending').innerText = DATA_SISWA.filter(s => s.status === 'proses').length;
        }

        function renderTable() {
            const tbody = document.getElementById('tableBody');
            tbody.innerHTML = '';

            let filtered = DATA_SISWA.filter(siswa => {
                let matchTab = (currentTab === 'semua') || (siswa.status === currentTab);
                let matchSearch = siswa.nama.toLowerCase().includes(searchQuery.toLowerCase()) || siswa.id.toLowerCase().includes(searchQuery.toLowerCase());
                return matchTab && matchSearch;
            });

            filtered.forEach((siswa, idx) => {
                let tr = document.createElement('tr');

                tr.innerHTML = `
            <td>${idx + 1}</td>

            <td>
                <div class="td-name">${siswa.nama}</div>
                <div class="td-id">${siswa.id}</div>
            </td>

            <td style="font-family:monospace;">
                ${siswa.nik}
            </td>

            <td>${siswa.tgl}</td>

            <td>
                <span class="badge badge-${siswa.status}">
                    <span class="badge-dot"></span>
                    ${siswa.status.toUpperCase()}
                </span>
            </td>

            <td>
                <div class="actions" style="justify-content:flex-end">

                    <!-- Tombol Detail -->
                    <button class="btn-action"
                            onclick="viewDetail('${siswa.id}')">
                        <i class="fas fa-eye"></i>
                    </button>

                ${siswa.status === 'approved'
                        ? `
            <button class="btn-action"
                    onclick="window.location.href='${siswa.invoice_url}'"
                    title="Invoice">
                <i class="fas fa-file-invoice"></i>
            </button>
        `
                        : ''
                    }

                </div>
            </td>
        `;

                tbody.appendChild(tr);
            });
            document.getElementById('paginationInfo').innerText = filtered.length > 0 ? `Showing 1 to ${filtered.length} of ${filtered.length} entries` : 'Showing 0 to 0 of 0 entries';
        }

        function formatTanggalAdmin(value) {
            if (!value) return 'Belum tercatat';

            const date = new Date(value);

            if (Number.isNaN(date.getTime())) {
                return value;
            }

            return date.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        function formatRupiah(value) {
            const amount = Number(value || 0);

            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(amount);
        }

        function getFilteredRiwayat() {
            const keyword = (document.getElementById('riwayatSearchInput')?.value || '').toLowerCase().trim();
            const statusFilter = document.getElementById('riwayatStatusFilter')?.value || 'semua';
            const batchFilter = document.getElementById('riwayatBatchFilter')?.value || 'semua';

            return RIWAYAT_SISWA.filter(item => {
                const searchable = `${item.nama || ''} ${item.nik || ''} ${item.id || ''} ${item.nama_batch || ''}`.toLowerCase();
                const matchSearch = !keyword || searchable.includes(keyword);
                const matchStatus = statusFilter === 'semua' || item.status === statusFilter;

                let matchBatch = true;
                if (batchFilter === 'tanpa_batch') {
                    matchBatch = !item.id_batch_pendaftaran;
                } else if (batchFilter !== 'semua') {
                    matchBatch = String(item.id_batch_pendaftaran || '') === String(batchFilter);
                }

                return matchSearch && matchStatus && matchBatch;
            });
        }

        function updateRiwayatSummary(filtered) {
            const totalCount = document.getElementById('riwayat-total-count');
            const approvedCount = document.getElementById('riwayat-approved-count');
            const rejectedCount = document.getElementById('riwayat-rejected-count');
            const invoiceTotal = document.getElementById('riwayat-invoice-total');

            if (!totalCount) return;

            totalCount.innerText = filtered.length;
            approvedCount.innerText = filtered.filter(item => item.status === 'approved').length;
            rejectedCount.innerText = filtered.filter(item => item.status === 'rejected').length;

            const totalNominal = filtered.reduce((sum, item) => sum + Number(item.total_tagihan || 0), 0);
            invoiceTotal.innerText = formatRupiah(totalNominal);
        }

        function renderRiwayatTable() {
            const tbody = document.getElementById('riwayatTableBody');
            const info = document.getElementById('riwayatPaginationInfo');

            if (!tbody) return;

            const filtered = getFilteredRiwayat();
            tbody.innerHTML = '';
            updateRiwayatSummary(filtered);

            if (filtered.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="9" style="text-align:center; color:var(--gray-400); font-weight:700; padding:24px;">
                            Tidak ada riwayat yang sesuai filter.
                        </td>
                    </tr>
                `;

                if (info) info.innerText = 'Showing 0 to 0 of 0 entries';
                return;
            }

            filtered.forEach((item, idx) => {
                const tr = document.createElement('tr');
                const invoiceButton = item.invoice_url
                    ? `<button class="btn-action" onclick="window.location.href='${item.invoice_url}'" title="Buka Invoice"><i class="fas fa-file-invoice"></i></button>`
                    : '';

                tr.innerHTML = `
                    <td>${idx + 1}</td>
                    <td>
                        <div class="td-name">${item.nama || '-'}</div>
                        <div class="td-id">${item.id || '-'}</div>
                    </td>
                    <td>${item.nama_batch || 'Tanpa Batch'}</td>
                    <td>${formatTanggalAdmin(item.tanggal_submit)}</td>
                    <td>${formatTanggalAdmin(item.tanggal_verifikasi)}</td>
                    <td>${item.diverifikasi_oleh || '-'}</td>
                    <td>
                        <span class="badge badge-${item.status || 'proses'}">
                            <span class="badge-dot"></span>
                            ${(item.status_label || item.status || '-').toUpperCase()}
                        </span>
                    </td>
                    <td class="riwayat-total">${formatRupiah(item.total_tagihan)}</td>
                    <td>
                        <div class="actions" style="justify-content:flex-end">
                            <button class="btn-action" onclick="viewRiwayatDetail('${item.pendaftaran_uid}')" title="Detail Riwayat">
                                <i class="fas fa-eye"></i>
                            </button>
                            ${invoiceButton}
                        </div>
                    </td>
                `;

                tbody.appendChild(tr);
            });

            if (info) info.innerText = `Showing 1 to ${filtered.length} of ${filtered.length} entries`;
        }

        function viewRiwayatDetail(pendaftaranUid) {
            const item = RIWAYAT_SISWA.find(row => String(row.pendaftaran_uid) === String(pendaftaranUid));

            if (!item) {
                showToast('Detail riwayat tidak ditemukan.', 'error');
                return;
            }

            selectedRiwayatInvoiceUrl = item.invoice_url || '';

            document.getElementById('riwayat-detail-subtitle').innerText = `RANGKUMAN AKTIVITAS ADMIN • ${item.id || '-'}`;
            document.getElementById('rd-nama').innerText = item.nama || '-';
            document.getElementById('rd-nik').innerText = item.nik || '-';
            document.getElementById('rd-reg').innerText = item.id || '-';
            document.getElementById('rd-batch').innerText = item.nama_batch || 'Tanpa Batch';
            document.getElementById('rd-submit').innerText = formatTanggalAdmin(item.tanggal_submit);
            document.getElementById('rd-verifikasi').innerText = formatTanggalAdmin(item.tanggal_verifikasi);
            document.getElementById('rd-admin').innerText = item.diverifikasi_oleh || '-';
            document.getElementById('rd-status').innerText = (item.status_label || item.status || '-').toUpperCase();
            document.getElementById('rd-invoice-no').innerText = item.nomor_tagihan || '-';
            document.getElementById('rd-invoice-total').innerText = formatRupiah(item.total_tagihan);
            document.getElementById('rd-alasan').innerText = item.status === 'rejected'
                ? (item.alasan_penolakan || '-')
                : '-';

            const invoiceBtn = document.getElementById('rd-invoice-btn');
            if (invoiceBtn) invoiceBtn.style.display = selectedRiwayatInvoiceUrl ? 'inline-flex' : 'none';

            openModal('modal-riwayat-detail');
        }

        function openRiwayatInvoice() {
            if (selectedRiwayatInvoiceUrl) {
                window.location.href = selectedRiwayatInvoiceUrl;
            }
        }

        function handleSearch(val) { searchQuery = val; renderTable(); }
        function filterTab(tab) { currentTab = tab; document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active')); document.getElementById(`tab-${tab}`).classList.add('active'); renderTable(); }
        function openModal(id) { document.getElementById(id).classList.add('open'); }
        function closeModal(id) { document.getElementById(id).classList.remove('open'); }

        /* ===== AMBIL BERKAS DARI DATABASE KETIKA TOMBOL DETAIL/MATA DIKLIK ===== */
        function viewDetail(id) {
            let siswa = DATA_SISWA.find(s => s.id === id);
            if (!siswa) return;

            selectedSiswaId = id;

            // Suntik data biodata dasar text
            document.getElementById('det-nama').innerText = siswa.nama;
            document.getElementById('det-nik').innerText = siswa.nik;
            document.getElementById('det-reg-id').innerText = `ADMINISTRATIVE DATA REVIEW • ${siswa.id}`;

            document.getElementById('det-tanggal-lahir').innerText = siswa.tanggal_lahir || '-';
            document.getElementById('det-tempat-lahir').innerText = siswa.tempat_lahir || '-';
            document.getElementById('det-alamat').innerText = siswa.alamat || '-';
            document.getElementById('det-agama').innerText = siswa.agama || '-';
            document.getElementById('det-gol-darah').innerText = siswa.gol_darah || '-';
            document.getElementById('det-ortu-nama').innerText = siswa.nama_ortu || '-';

            // Suntik data profil ortu (hanya field: no_telp, pendidikan, gaji, alamat)
            document.getElementById('det-ortu-telp').innerText = siswa.no_telp_ortu || '-';
            document.getElementById('det-ortu-email').innerText = siswa.email_ortu || '-';
            document.getElementById('det-ortu-pendidikan').innerText = siswa.pendidikan_ortu || '-';
            document.getElementById('det-ortu-gaji').innerText = siswa.gaji_ortu || '-';
            document.getElementById('det-ortu-alamat').innerText = siswa.alamat_ortu || '-';


            // MENGHUBUNGKAN LINK PREVIEW SECARA DINAMIS SESUAI BERKAS DATABASE SISWA YANG DIPILIH
            document.getElementById('link-kk').onclick = () => openFilePreview('Kartu Keluarga', siswa.berkas.kartu_keluarga);
            document.getElementById('link-akte').onclick = () => openFilePreview('Akte Kelahiran', siswa.berkas.akte_kelahiran);
            document.getElementById('link-ktp').onclick = () => openFilePreview('E-KTP Orang Tua', siswa.berkas.ktp_orang_tua);
            document.getElementById('link-foto').onclick = () => openFilePreview('Pas Foto (3x4)', siswa.berkas.pas_foto);
            document.getElementById('link-baptis').onclick = () => openFilePreview('Surat Baptis', siswa.berkas.surat_baptis);

            const controlPanel = document.querySelector('.control-panel');

            if (siswa.status === 'proses') {
                controlPanel.innerHTML = `
        <div class="control-panel-header">
            <i class="fas fa-terminal"></i>
            ADMINISTRATIVE CONTROL PANEL
        </div>

        <button class="btn-validate-trigger" id="btnValidateTrigger"
            onclick="activateValidationChoices()">
            <i class="fas fa-shield-check"></i>
            Validasi Semua Berkas
        </button>

        <div class="validation-actions" id="validationActionsBlock">
            <button class="btn-decision approve" onclick="submitValidationDecision('approved')">
                <i class="fas fa-circle-check"></i>
                Loloskan
            </button>

            <button class="btn-decision reject" onclick="showRejectReason()">
                <i class="fas fa-circle-xmark"></i>
                Gagalkan
            </button>
        </div>

        <div id="reject-reason-wrap" style="display:none; margin-top:14px;">
            <div class="form-group" style="margin-bottom:10px;">
                <label class="form-label">Alasan Ditolak</label>

                <textarea id="reject-alasan" class="form-control"
                    style="height:92px; resize:none;"
                    placeholder="Masukkan alasan penolakan..."></textarea>
            </div>

            <div class="form-group" style="margin-bottom:14px;">
                <label class="form-label">Berkas yang Tidak Sesuai</label>

                <label style="display:block; color:white; font-size:13px; margin-bottom:6px;">
                    <input type="checkbox" class="berkas-invalid" value="Kartu Keluarga">
                    Kartu Keluarga
                </label>

                <label style="display:block; color:white; font-size:13px; margin-bottom:6px;">
                    <input type="checkbox" class="berkas-invalid" value="Akte Kelahiran">
                    Akte Kelahiran
                </label>

                <label style="display:block; color:white; font-size:13px; margin-bottom:6px;">
                    <input type="checkbox" class="berkas-invalid" value="E-KTP Orang Tua">
                    E-KTP Orang Tua
                </label>

                <label style="display:block; color:white; font-size:13px; margin-bottom:6px;">
                    <input type="checkbox" class="berkas-invalid" value="Pas Foto">
                    Pas Foto
                </label>

                <label style="display:block; color:white; font-size:13px; margin-bottom:6px;">
                    <input type="checkbox" class="berkas-invalid" value="Surat Baptis">
                    Surat Baptis
                </label>
            </div>

            <button class="btn-decision reject" style="width:100%;"
                onclick="submitValidationDecision('rejected')">
                <i class="fas fa-paper-plane"></i>
                Kirim Penolakan
            </button>
        </div>
    `;
            }

            else if (siswa.status === 'approved') {
                controlPanel.innerHTML = `
        <div class="control-panel-header">
            <i class="fas fa-circle-check"></i>
            STATUS BERKAS
        </div>

        <div style="
            background:#22c55e;
            padding:15px;
            border-radius:14px;
            text-align:center;
            font-weight:700;
            color:white;
        ">
            SISWA SUDAH DINYATAKAN LOLOS
        </div>
    `;
            }

            else if (siswa.status === 'rejected') {
                controlPanel.innerHTML = `
        <div class="control-panel-header">
            <i class="fas fa-circle-xmark"></i>
            STATUS BERKAS
        </div>

        <div style="
            background:#ef4444;
            padding:15px;
            border-radius:14px;
            color:white;
            margin-bottom:15px;
            font-weight:700;
            text-align:center;
        ">
            SISWA DITOLAK
        </div>

        <div style="
            background:white;
            padding:15px;
            border-radius:12px;
            color:black;
        ">
            <strong>Alasan Penolakan :</strong><br><br>
            ${siswa.alasan_rejected || '-'}
        </div>
    `;
            }

            openModal('modal-detail');
        }

        function activateValidationChoices() {
            document.getElementById('btnValidateTrigger').style.display = 'none';

            document.getElementById('validationActionsBlock').classList.add('active');

            document.getElementById('reject-reason-wrap').style.display = 'none';

            document.getElementById('reject-alasan').value = '';
        }

        function showRejectReason() {
            const rejectWrap = document.getElementById('reject-reason-wrap');
            const actionsBlock = document.getElementById('validationActionsBlock');
            const alasanInput = document.getElementById('reject-alasan');

            if (!rejectWrap) {
                alert('Form alasan penolakan tidak ditemukan.');
                return;
            }

            rejectWrap.style.display = 'block';

            if (actionsBlock) {
                actionsBlock.classList.remove('active');
            }

            document.querySelectorAll('.berkas-invalid').forEach(cb => {
                cb.checked = false;
            });

            if (alasanInput) {
                alasanInput.focus();
            }
        }

        function submitValidationDecision(newStatus) {
            const siswa = DATA_SISWA.find(s => s.id === selectedSiswaId);

            if (!siswa) {
                showToast('Data siswa tidak ditemukan.', 'error');
                return;
            }

            let targetUrl = '';
            let payload = {};

            if (newStatus === 'approved') {
                targetUrl = siswa.approve_url;
            }

            if (newStatus === 'rejected') {
                const alasanEl = document.getElementById('reject-alasan');
                const alasan = (alasanEl?.value || '').trim();

                if (!alasan) {
                    showToast('Alasan penolakan wajib diisi.', 'error');
                    return;
                }

                const invalidBerkas = [...document.querySelectorAll('.berkas-invalid:checked')]
                    .map(cb => cb.value);

                if (invalidBerkas.length === 0) {
                    showToast('Pilih minimal satu berkas yang tidak sesuai.', 'error');
                    return;
                }

                targetUrl = siswa.reject_url;
                payload = {
                    alasan: alasan,
                    jenis_penolakan: 'berkas',
                    invalid_berkas: invalidBerkas
                };
            }

            if (!targetUrl) {
                showToast('URL proses verifikasi tidak ditemukan.', 'error');
                return;
            }

            fetch(targetUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            })
                .then(async response => {
                    const data = await response.json();

                    if (!response.ok || !data.success) {
                        throw new Error(data.message || 'Proses verifikasi gagal.');
                    }

                    siswa.status = newStatus;

                    if (newStatus === 'rejected') {
                        siswa.alasan_rejected = payload.alasan;
                    }

                    if (newStatus === 'approved') {
                        siswa.invoice_url = data.invoice_url;
                    }

                    const riwayatItem = RIWAYAT_SISWA.find(row => String(row.pendaftaran_uid) === String(siswa.pendaftaran_uid));

                    if (riwayatItem) {
                        riwayatItem.status = newStatus;
                        riwayatItem.status_label = newStatus.toUpperCase();
                        riwayatItem.tanggal_verifikasi = data.tanggal_verifikasi || new Date().toISOString();
                        riwayatItem.diverifikasi_oleh = data.diverifikasi_oleh || riwayatItem.diverifikasi_oleh || 'Admin';

                        if (newStatus === 'rejected') {
                            riwayatItem.alasan_penolakan = payload.alasan || '-';
                        }

                        if (newStatus === 'approved' && data.invoice_url) {
                            riwayatItem.invoice_url = data.invoice_url;
                        }
                    }

                    updateStats();
                    renderTable();
                    renderRiwayatTable();
                    closeModal('modal-detail');

                    if (newStatus === 'approved') {
                        showToast('✅ Pendaftar berhasil diloloskan. Invoice sudah tersedia.', 'success');
                    }

                    if (newStatus === 'rejected') {
                        showToast('❌ Pendaftar berhasil ditolak.', 'success');
                    }
                })
                .catch(error => {
                    showToast('❌ ' + error.message, 'error');
                });
        }



            /* ===== PREVIEW & DOWNLOAD HANDLER POPUP ===== */
            function openFilePreview(fileName, fileUrl) {
                if (!fileUrl) {
                    showToast('Berkas belum tersedia.', 'error');
                    return;
                }

                activeDownloadUrl = fileUrl;
                activeDownloadName = fileName.replace(/\s+/g, '_').toLowerCase();

                document.getElementById('preview-file-title').innerHTML =
                    `<i class="fas fa-file-image" style="color:var(--blue); margin-right:8px;"></i>Pratinjau ${fileName}`;

                const container = document.querySelector('#modal-file-preview .preview-container');
                container.innerHTML = '';

                const lowerUrl = fileUrl.toLowerCase();

                if (lowerUrl.includes('.pdf')) {
                    const iframe = document.createElement('iframe');
                    iframe.src = fileUrl;
                    iframe.style.width = '100%';
                    iframe.style.height = '520px';
                    iframe.style.border = 'none';
                    container.appendChild(iframe);
                } else {
                    const img = document.createElement('img');
                    img.src = fileUrl;
                    img.className = 'preview-image-element';
                    img.alt = fileName;
                    container.appendChild(img);
                }

                document.getElementById('modal-file-preview').classList.add('open');
            }

            function closeFilePreview() { document.getElementById('modal-file-preview').classList.remove('open'); }

            function downloadFileToComputer() {
                if (!activeDownloadUrl) return;
                const virtualAnchor = document.createElement('a');
                virtualAnchor.href = activeDownloadUrl;
                virtualAnchor.download = `dokumen_${activeDownloadName}_${selectedSiswaId}.jpg`;
                virtualAnchor.target = '_blank';
                document.body.appendChild(virtualAnchor);
                virtualAnchor.click();
                document.body.removeChild(virtualAnchor);

                showToast("Berkas berhasil disimpan ke komputer.", "success");
            }
            function saveBatch() {
                const batchId = document.getElementById('batch-id')?.value || '';
                const batchName = document.getElementById('batch-name')?.value || '';
                const batchOpen = document.getElementById('batch-open')?.value || '';
                const batchClose = document.getElementById('batch-close')?.value || '';
                const batchQuota = parseInt(document.getElementById('batch-quota')?.value || '0', 10);
                const batchStatus = document.getElementById('batch-status')?.value || '1';

                if (!batchName.trim()) {
                    return showToast('Nama batch wajib diisi.', 'error');
                }

                if (!batchOpen || !batchClose) {
                    return showToast('Tanggal buka dan tanggal tutup wajib diisi.', 'error');
                }

                if (!Number.isFinite(batchQuota) || batchQuota < 0) {
                    return showToast('Kuota tidak valid.', 'error');
                }

                fetch("{{ route('admin.batch.save') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        uid: batchId || null,
                        nama_batch: batchName,
                        tanggal_buka: batchOpen,
                        tanggal_tutup: batchClose,
                        kuota: batchQuota,
                        is_active: batchStatus
                    })
                })
                    .then(async response => {
                        const data = await response.json();

                        if (!response.ok || !data.success) {
                            throw new Error(data.message || 'Gagal menyimpan batch.');
                        }

                        const batch = data.batch;
                        const card = document.getElementById(`batch-card-${batch.uid}`);

                        if (card) {
                            card.dataset.nama = batch.nama_batch;
                            card.dataset.tanggalBuka = batch.tanggal_buka;
                            card.dataset.tanggalTutup = batch.tanggal_tutup;
                            card.dataset.kuota = batch.kuota;
                            card.dataset.active = batch.is_active;

                            const title = card.querySelector('.batch-title');
                            const date = card.querySelector('.batch-date');
                            const quota = card.querySelector('.batch-quota');
                            const sisa = card.querySelector('.batch-sisa');

                            if (title) title.innerText = batch.nama_batch;
                            if (date) date.innerText = `${batch.tanggal_buka} s/d ${batch.tanggal_tutup}`;
                            if (quota) quota.innerText = `${batch.total_pendaftar} / ${batch.kuota}`;
                            if (sisa) sisa.innerText = `Sisa: ${batch.sisa_kuota}`;
                        }

                        showToast(data.message || 'Batch berhasil disimpan.', 'success');
                    })
                    .catch(error => {
                        showToast(error.message, 'error');
                    });
            }
            function editBatchFromCard(card) {
                document.getElementById('batch-id').value = card.dataset.uid || '';
                document.getElementById('batch-name').value = card.dataset.nama || '';
                document.getElementById('batch-open').value = card.dataset.tanggalBuka || '';
                document.getElementById('batch-close').value = card.dataset.tanggalTutup || '';
                document.getElementById('batch-quota').value = card.dataset.kuota || 0;
                document.getElementById('batch-status').value = card.dataset.active || '0';

                document.querySelectorAll('.batch-row').forEach(row => {
                    row.style.borderColor = '#e2e8f0';
                    row.style.background = '#f8fafc';
                });

                card.style.borderColor = '#0f2a5e';
                card.style.background = '#eef6ff';

                showToast('Data batch dimuat ke form. Edit lalu klik Simpan.', 'success');
            }
            function deleteBatch(uid) {
                if (!confirm('Yakin ingin menghapus batch ini?')) {
                    return;
                }

                fetch(`/admin/batch/${uid}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                    .then(async response => {
                        const data = await response.json();

                        if (!response.ok || !data.success) {
                            throw new Error(data.message || 'Gagal menghapus batch.');
                        }

                        const card = document.getElementById(`batch-card-${uid}`);

                        if (card) {
                            card.remove();
                        }

                        if (document.getElementById('batch-id')?.value == uid) {
                            document.getElementById('batch-id').value = '';
                            document.getElementById('batch-name').value = '';
                            document.getElementById('batch-open').value = '';
                            document.getElementById('batch-close').value = '';
                            document.getElementById('batch-quota').value = 0;
                            document.getElementById('batch-status').value = '0';
                        }

                        showToast('Batch berhasil dihapus.', 'success');
                    })
                    .catch(error => {
                        showToast(error.message, 'error');
                    });
            }


            function prepareCreateBatch() {
                document.getElementById('batch-id').value = '';
                document.getElementById('batch-name').value = '';
                document.getElementById('batch-open').value = '';
                document.getElementById('batch-close').value = '';
                document.getElementById('batch-quota').value = 0;
                document.getElementById('batch-status').value = '1';

                document.querySelectorAll('.batch-row').forEach(row => {
                    row.style.borderColor = '#e2e8f0';
                    row.style.background = '#f8fafc';
                });

                document.getElementById('batch-name').focus();

                showToast('Mode tambah gelombang baru. Isi data lalu klik Simpan.', 'success');
            }
    </script>
</body>

</html>