<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SAKTI PORTAL – Dashboard Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Sora:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* ===== CSS VARIABLES ===== */
        :root {
            --primary:       #0f2a5e;
            --primary-light: #1a3d8f;
            --accent:        #f5a623;
            --green:         #22c55e;
            --green-bg:      #f0fdf4;
            --green-border:  #bbf7d0;
            --red:           #ef4444;
            --red-bg:        #fff1f2;
            --red-border:    #fecdd3;
            --orange:        #f97316;
            --orange-bg:     #fff7ed;
            --orange-border: #fed7aa;
            --blue:          #3b82f6;
            --blue-bg:       #eff6ff;
            --blue-border:   #bfdbfe;
            --gray-50:       #f8fafc;
            --gray-100:      #f1f5f9;
            --gray-200:      #e2e8f0;
            --gray-300:      #cbd5e1;
            --gray-400:      #94a3b8;
            --gray-500:      #64748b;
            --gray-600:      #475569;
            --gray-700:      #334155;
            --gray-800:      #1e293b;
            --shadow-sm:     0 1px 3px rgba(0,0,0,.08);
            --shadow-md:     0 4px 16px rgba(0,0,0,.10);
            --shadow-lg:     0 8px 32px rgba(0,0,0,.12);
            --radius:        16px;
            --radius-sm:     10px;
            --transition:    all .22s cubic-bezier(.4,0,.2,1);
        }

        /* ===== RESET ===== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { font-size: 15px; scroll-behavior: smooth; }
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
            position: fixed; inset: 0; pointer-events: none; z-index: 0;
            overflow: hidden;
        }
        .bg-decor::before {
            content: '';
            position: absolute;
            width: 700px; height: 700px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(59,130,246,.09) 0%, transparent 70%);
            top: -200px; left: -200px;
        }
        .bg-decor::after {
            content: '';
            position: absolute;
            width: 500px; height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(245,166,35,.07) 0%, transparent 70%);
            bottom: -100px; right: -100px;
        }

        /* ===== NAVBAR ===== */
        .navbar {
            position: sticky; top: 0; z-index: 100;
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
            width: 44px; height: 44px;
            background: var(--primary);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            color: var(--accent);
            font-size: 18px;
            flex-shrink: 0;
        }
        .brand-text { line-height: 1.2; }
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
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--green);
            animation: pulse-dot 2s infinite;
        }
        @keyframes pulse-dot {
            0%,100% { opacity:1; transform:scale(1); }
            50% { opacity:.5; transform:scale(.8); }
        }
        .brand-uid {
            font-size: .65rem;
            color: var(--gray-400);
            font-weight: 500;
        }

        /* Nav links */
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
        .nav-link:hover { background: var(--gray-100); color: var(--primary); }
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

        /* User info */
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
        .nav-user:hover { background: var(--gray-100); }
        .nav-user-text { text-align: right; }
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
            width: 36px; height: 36px;
            border-radius: 10px;
            background: var(--red-bg);
            border: none;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            color: var(--red);
            font-size: .9rem;
            transition: var(--transition);
        }
        .nav-logout:hover { background: var(--red); color: #fff; }

        /* ===== MAIN CONTENT ===== */
        main {
            position: relative; z-index: 1;
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
            top: 0; left: 0; right: 0;
            height: 3px;
            border-radius: var(--radius) var(--radius) 0 0;
        }
        .stat-card.blue::after  { background: var(--blue); }
        .stat-card.green::after { background: var(--green); }
        .stat-card.red::after   { background: var(--red); }
        .stat-card.orange::after{ background: var(--orange); }

        .stat-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
        .stat-card.blue  { background: var(--blue-bg);   border-color: var(--blue-border); }
        .stat-card.green { background: var(--green-bg);  border-color: var(--green-border); }
        .stat-card.red   { background: var(--red-bg);    border-color: var(--red-border); }
        .stat-card.orange{ background: var(--orange-bg); border-color: var(--orange-border); }

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
        .stat-card.blue  .stat-label { color: var(--blue); }
        .stat-card.green .stat-label { color: var(--green); }
        .stat-card.red   .stat-label { color: var(--red); }
        .stat-card.orange .stat-label { color: var(--orange); }

        .stat-icon {
            width: 36px; height: 36px;
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
        }
        .stat-card.blue   .stat-icon { background: rgba(59,130,246,.15);  color: var(--blue); }
        .stat-card.green  .stat-icon { background: rgba(34,197,94,.15);   color: var(--green); }
        .stat-card.red    .stat-icon { background: rgba(239,68,68,.15);   color: var(--red); }
        .stat-card.orange .stat-icon { background: rgba(249,115,22,.15);  color: var(--orange); }

        .stat-number {
            font-family: 'Sora', sans-serif;
            font-size: 2.6rem;
            font-weight: 700;
            line-height: 1;
        }
        .stat-card.blue   .stat-number { color: var(--blue); }
        .stat-card.green  .stat-number { color: var(--green); }
        .stat-card.red    .stat-number { color: var(--red); }
        .stat-card.orange .stat-number { color: var(--orange); }

        /* ===== VERIFICATION SECTION ===== */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 12px;
        }
        .section-title-wrap { display: flex; align-items: center; gap: 14px; }
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
        .section-sub span { color: var(--primary); font-weight: 700; }

        /* Batch button */
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
        .btn-batch:hover { background: var(--primary-light); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(15,42,94,.25); }

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
            left: 14px; top: 50%;
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
        .search-input:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(59,130,246,.12); }
        .search-input::placeholder { color: var(--gray-400); }

        /* Filter tabs */
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
        .filter-tab:hover { color: var(--primary); }
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
        .table-container { overflow-x: auto; }

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
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: var(--gray-50); }
        td {
            padding: 14px 18px;
            font-size: .85rem;
            color: var(--gray-700);
            vertical-align: middle;
        }

        .td-name { font-weight: 700; color: var(--primary); }
        .td-id { font-size: .75rem; color: var(--gray-400); font-weight: 500; }

        /* Status badge */
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
        .badge-dot { width: 5px; height: 5px; border-radius: 50%; }
        .badge-draft    { background: var(--gray-100); color: var(--gray-500); }
        .badge-draft .badge-dot { background: var(--gray-400); }
        .badge-proses   { background: var(--orange-bg); color: var(--orange); }
        .badge-proses .badge-dot { background: var(--orange); animation: pulse-dot 1.5s infinite; }
        .badge-approved { background: var(--green-bg); color: var(--green); }
        .badge-approved .badge-dot { background: var(--green); }
        .badge-rejected { background: var(--red-bg); color: var(--red); }
        .badge-rejected .badge-dot { background: var(--red); }

        /* Action buttons */
        .actions { display: flex; align-items: center; gap: 6px; }
        .btn-action {
            width: 32px; height: 32px;
            border-radius: 8px;
            border: 1.5px solid var(--gray-200);
            background: #fff;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            font-size: .8rem;
            color: var(--gray-500);
            transition: var(--transition);
        }
        .btn-action:hover { border-color: var(--blue); color: var(--blue); background: var(--blue-bg); }
        .btn-action.approve:hover { border-color: var(--green); color: var(--green); background: var(--green-bg); }
        .btn-action.reject:hover  { border-color: var(--red);   color: var(--red);   background: var(--red-bg); }

        /* ===== EMPTY STATE ===== */
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

        /* ===== PAGINATION ===== */
        .pagination-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px;
            border-top: 1.5px solid var(--gray-100);
            gap: 12px;
            flex-wrap: wrap;
        }
        .pagination-info { font-size: .78rem; color: var(--gray-500); font-weight: 500; }
        .pagination-btns { display: flex; gap: 4px; }
        .page-btn {
            width: 32px; height: 32px;
            border-radius: 8px;
            border: 1.5px solid var(--gray-200);
            background: #fff;
            font-size: .78rem;
            font-weight: 600;
            color: var(--gray-600);
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: var(--transition);
        }
        .page-btn:hover { border-color: var(--primary); color: var(--primary); }
        .page-btn.active { background: var(--primary); border-color: var(--primary); color: #fff; }
        .page-btn:disabled { opacity: .4; cursor: not-allowed; }

        /* ===== MODALS ===== */
        .modal-backdrop {
            position: fixed; inset: 0;
            background: rgba(15,42,94,.45);
            backdrop-filter: blur(6px);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            animation: fadeIn .2s ease;
        }
        .modal-backdrop.open { display: flex; }
        @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }

        .modal {
            background: #fff;
            border-radius: 20px;
            box-shadow: var(--shadow-lg);
            width: 100%;
            max-width: 520px;
            animation: slideUp .25s cubic-bezier(.4,0,.2,1);
        }
        @keyframes slideUp {
            from { opacity:0; transform:translateY(24px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .modal-header {
            padding: 24px 28px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .modal-title {
            font-family: 'Sora', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary);
        }
        .modal-close {
            width: 32px; height: 32px;
            border-radius: 8px;
            border: none;
            background: var(--gray-100);
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            color: var(--gray-500);
            font-size: .85rem;
            transition: var(--transition);
        }
        .modal-close:hover { background: var(--red-bg); color: var(--red); }
        .modal-body { padding: 20px 28px; }
        .modal-footer {
            padding: 0 28px 24px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        /* Form */
        .form-group { margin-bottom: 16px; }
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
        .form-control:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(59,130,246,.1); }

        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

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
        .btn-secondary { background: var(--gray-100); color: var(--gray-600); }
        .btn-secondary:hover { background: var(--gray-200); }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: var(--primary-light); box-shadow: 0 4px 12px rgba(15,42,94,.25); }
        .btn-success { background: var(--green); color: #fff; }
        .btn-success:hover { filter: brightness(1.1); }
        .btn-danger { background: var(--red); color: #fff; }
        .btn-danger:hover { filter: brightness(1.1); }

        /* Detail rows */
        .detail-row {
            display: flex;
            align-items: flex-start;
            padding: 10px 0;
            border-bottom: 1px solid var(--gray-100);
            gap: 12px;
        }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { font-size: .75rem; font-weight: 700; color: var(--gray-400); width: 130px; flex-shrink: 0; padding-top: 1px; }
        .detail-value { font-size: .875rem; color: var(--gray-800); font-weight: 600; }

        /* Toast */
        .toast-container {
            position: fixed;
            bottom: 24px; right: 24px;
            z-index: 2000;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .toast {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fff;
            border-radius: 12px;
            padding: 14px 18px;
            box-shadow: var(--shadow-lg);
            border-left: 4px solid;
            min-width: 280px;
            animation: slideInRight .3s cubic-bezier(.4,0,.2,1);
            font-size: .85rem;
            font-weight: 600;
        }
        @keyframes slideInRight {
            from { opacity:0; transform:translateX(40px); }
            to   { opacity:1; transform:translateX(0); }
        }
        .toast.success { border-color: var(--green); }
        .toast.success i { color: var(--green); }
        .toast.error { border-color: var(--red); }
        .toast.error i { color: var(--red); }
        .toast.info { border-color: var(--blue); }
        .toast.info i { color: var(--blue); }

        /* Riwayat page */
        .page-section { display: none; }
        .page-section.active { display: block; }

        /* Help page */
        .help-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }
        .help-card {
            background: #fff;
            border: 1.5px solid var(--gray-200);
            border-radius: var(--radius);
            padding: 24px;
            box-shadow: var(--shadow-sm);
        }
        .help-card h3 {
            font-size: .95rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 10px;
            display: flex; align-items: center; gap: 8px;
        }
        .help-card p { font-size: .85rem; color: var(--gray-600); line-height: 1.6; }

        /* Footer */
        footer {
            text-align: center;
            padding: 18px;
            font-size: .72rem;
            color: var(--gray-400);
            font-weight: 500;
            letter-spacing: .5px;
            border-top: 1px solid var(--gray-200);
            position: relative; z-index: 1;
        }

        /* Spinner */
        @keyframes spin { to { transform: rotate(360deg); } }
        .spin { animation: spin 1s linear infinite; display: inline-block; }

        /* Responsive */
        @media (max-width: 900px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .help-grid  { grid-template-columns: 1fr; }
        }
        @media (max-width: 600px) {
            .stats-grid { grid-template-columns: 1fr; }
            .nav-links  { display: none; }
            .form-row   { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<div class="page-wrapper">
    <div class="bg-decor"></div>

    <!-- ===== NAVBAR ===== -->
    <nav class="navbar">
        <div class="navbar-inner">
            <a href="#" class="brand" onclick="switchPage('dashboard')">
                <div class="brand-logo"><i class="fas fa-shield-halved"></i></div>
                <div class="brand-text">
                    <div class="brand-name">SAKTI PORTAL</div>
                    <div class="brand-meta">
                        <span class="dot"></span>
                        <span>ADMIN</span>
                        <span class="brand-uid">UID-MOCK-admin-001</span>
                    </div>
                </div>
            </a>

            <nav class="nav-links">
                <button class="nav-link active" id="nav-dashboard" onclick="switchPage('dashboard')">
                    <i class="fas fa-grip-vertical"></i> Dashboard
                    <span class="nav-badge" id="badge-pending">1</span>
                </button>
                <button class="nav-link" id="nav-riwayat" onclick="switchPage('riwayat')">
                    <i class="fas fa-clock-rotate-left"></i> Riwayat
                </button>
                <button class="nav-link" id="nav-bantuan" onclick="switchPage('bantuan')">
                    <i class="fas fa-circle-info"></i> Pusat Bantuan
                </button>
            </nav>

            <div class="nav-user" onclick="openModal('modal-profile')">
                <div class="nav-user-text">
                    <div class="nav-username">Admin JOG-WRO</div>
                    <div class="nav-branch">JOG-WRO</div>
                </div>
                <i class="fas fa-chevron-down" style="color:var(--gray-400);font-size:.75rem;"></i>
            </div>
            <button class="nav-logout" onclick="handleLogout()" title="Logout">
                <i class="fas fa-arrow-right-from-bracket"></i>
            </button>
        </div>
    </nav>

    <main>
        <!-- ===== DASHBOARD PAGE ===== -->
        <section class="page-section active" id="page-dashboard">
            <!-- Stat cards -->
            <div class="stats-grid">
                <div class="stat-card blue" onclick="filterTab('semua')" style="cursor:pointer" title="Lihat semua pendaftar">
                    <div class="stat-header">
                        <span class="stat-label">Total Pendaftar</span>
                        <div class="stat-icon"><i class="fas fa-users"></i></div>
                    </div>
                    <div class="stat-number" id="count-total">1</div>
                </div>
                <div class="stat-card green" onclick="filterTab('approved')" style="cursor:pointer" title="Lihat pendaftar diterima">
                    <div class="stat-header">
                        <span class="stat-label">Diterima</span>
                        <div class="stat-icon"><i class="fas fa-circle-check"></i></div>
                    </div>
                    <div class="stat-number" id="count-approved">0</div>
                </div>
                <div class="stat-card red" onclick="filterTab('rejected')" style="cursor:pointer" title="Lihat pendaftar ditolak">
                    <div class="stat-header">
                        <span class="stat-label">Ditolak</span>
                        <div class="stat-icon"><i class="fas fa-circle-xmark"></i></div>
                    </div>
                    <div class="stat-number" id="count-rejected">0</div>
                </div>
                <div class="stat-card orange" onclick="filterTab('proses')" style="cursor:pointer" title="Lihat proses seleksi">
                    <div class="stat-header">
                        <span class="stat-label">Proses Seleksi</span>
                        <div class="stat-icon"><i class="fas fa-rotate spin"></i></div>
                    </div>
                    <div class="stat-number" id="count-proses">1</div>
                </div>
            </div>

            <!-- Section header -->
            <div class="section-header">
                <div class="section-title-wrap">
                    <div>
                        <div class="section-title">Pusat Verifikasi</div>
                        <div class="section-sub">CABANG PENGELOLAAN: <span>JOG-WRO</span></div>
                    </div>
                </div>
                <button class="btn-batch" onclick="openModal('modal-batch')">
                    <i class="fas fa-gear"></i> KELOLA BATCH &amp; KUOTA
                </button>
            </div>

            <!-- Toolbar -->
            <div class="toolbar">
                <div class="search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" class="search-input" id="searchInput"
                           placeholder="Cari Nama, ID, atau NIK..." oninput="handleSearch(this.value)">
                </div>
                <div class="filter-tabs">
                    <button class="filter-tab" id="tab-semua"    onclick="filterTab('semua')">SEMUA</button>
                    <button class="filter-tab" id="tab-proses"   onclick="filterTab('proses')">PROSES</button>
                    <button class="filter-tab" id="tab-approved" onclick="filterTab('approved')">APPROVED</button>
                    <button class="filter-tab" id="tab-rejected" onclick="filterTab('rejected')">REJECTED</button>
                    <button class="filter-tab active" id="tab-draft" onclick="filterTab('draft')">DRAFT</button>
                </div>
            </div>

            <!-- Table -->
            <div class="table-card">
                <div class="table-container">
                    <table id="mainTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Pendaftar</th>
                                <th>NIK</th>
                                <th>Cabang</th>
                                <th>Batch</th>
                                <th>Status</th>
                                <th>Tgl. Daftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody"></tbody>
                    </table>
                </div>

                <div id="emptyState" class="empty-state" style="display:none">
                    <div class="empty-icon"><i class="fas fa-clipboard-list"></i></div>
                    <p>Tidak ada pendaftar ditemukan.</p>
                </div>

                <div class="pagination-bar" id="paginationBar">
                    <div class="pagination-info" id="pageInfo">Menampilkan 0 data</div>
                    <div class="pagination-btns" id="pageBtns"></div>
                </div>
            </div>
        </section>

        <!-- ===== RIWAYAT PAGE ===== -->
        <section class="page-section" id="page-riwayat">
            <div class="section-header">
                <div>
                    <div class="section-title">Riwayat Aktivitas</div>
                    <div class="section-sub">Log aktivitas admin cabang <span>JOG-WRO</span></div>
                </div>
                <button class="btn btn-secondary" onclick="clearHistory()"><i class="fas fa-trash"></i> Bersihkan</button>
            </div>
            <div class="table-card">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Aksi</th>
                                <th>Target</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="historyBody">
                            <tr>
                                <td colspan="4" style="text-align:center;padding:48px;color:var(--gray-400);">
                                    <i class="fas fa-clock-rotate-left" style="font-size:1.8rem;margin-bottom:10px;display:block;opacity:.4"></i>
                                    Belum ada riwayat aktivitas.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- ===== BANTUAN PAGE ===== -->
        <section class="page-section" id="page-bantuan">
            <div class="section-header">
                <div>
                    <div class="section-title">Pusat Bantuan</div>
                    <div class="section-sub">Panduan penggunaan SAKTI PORTAL</div>
                </div>
            </div>
            <div class="help-grid">
                <div class="help-card">
                    <h3><i class="fas fa-users" style="color:var(--blue)"></i> Kelola Pendaftar</h3>
                    <p>Gunakan filter tab (SEMUA, PROSES, APPROVED, REJECTED, DRAFT) untuk melihat daftar pendaftar berdasarkan status. Klik ikon <b>mata</b> untuk melihat detail, <b>centang</b> untuk menyetujui, atau <b>silang</b> untuk menolak.</p>
                </div>
                <div class="help-card">
                    <h3><i class="fas fa-gear" style="color:var(--orange)"></i> Batch &amp; Kuota</h3>
                    <p>Klik tombol <b>KELOLA BATCH &amp; KUOTA</b> untuk mengatur periode penerimaan dan batas kuota peserta per batch. Pastikan batch aktif sebelum memproses pendaftar baru.</p>
                </div>
                <div class="help-card">
                    <h3><i class="fas fa-magnifying-glass" style="color:var(--green)"></i> Pencarian</h3>
                    <p>Gunakan kolom pencarian untuk mencari pendaftar berdasarkan Nama, ID, atau NIK. Pencarian dilakukan secara real-time tanpa perlu menekan Enter.</p>
                </div>
                <div class="help-card">
                    <h3><i class="fas fa-circle-info" style="color:var(--primary)"></i> Kontak Support</h3>
                    <p>Untuk bantuan teknis, hubungi tim IT Yayasan Kanisius melalui email <b>support@kanisius.id</b> atau WhatsApp <b>+62 811-0000-0000</b> pada hari kerja pukul 08.00–17.00 WIB.</p>
                </div>
            </div>
        </section>
    </main>

    <footer>YAYASAN KANISIUS &copy; 2026 &nbsp;&middot;&nbsp; ADMISI TERINTEGRASI</footer>
</div>

<!-- ===== MODALS ===== -->

<!-- Detail Modal -->
<div class="modal-backdrop" id="modal-detail">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title"><i class="fas fa-id-card" style="color:var(--blue);margin-right:8px"></i>Detail Pendaftar</div>
            <button class="modal-close" onclick="closeModal('modal-detail')"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body" id="detail-body"></div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('modal-detail')">Tutup</button>
            <button class="btn btn-danger"  id="detail-btn-reject"  onclick="quickAction('reject')"><i class="fas fa-times"></i> Tolak</button>
            <button class="btn btn-success" id="detail-btn-approve" onclick="quickAction('approve')"><i class="fas fa-check"></i> Setujui</button>
        </div>
    </div>
</div>

<!-- Approve Confirm Modal -->
<div class="modal-backdrop" id="modal-approve">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title"><i class="fas fa-circle-check" style="color:var(--green);margin-right:8px"></i>Konfirmasi Penerimaan</div>
            <button class="modal-close" onclick="closeModal('modal-approve')"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <p style="margin-bottom:12px;color:var(--gray-600);">Anda akan menyetujui pendaftar:</p>
            <div style="background:var(--green-bg);border:1.5px solid var(--green-border);border-radius:10px;padding:14px 18px;margin-bottom:16px;">
                <div style="font-weight:700;color:var(--primary)" id="approve-name"></div>
                <div style="font-size:.8rem;color:var(--gray-500)" id="approve-nik"></div>
            </div>
            <div class="form-group">
                <label class="form-label">Catatan Penerimaan (opsional)</label>
                <textarea class="form-control" id="approve-note" rows="3" placeholder="Tambahkan catatan..."></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('modal-approve')">Batal</button>
            <button class="btn btn-success" onclick="confirmApprove()"><i class="fas fa-check"></i> Ya, Setujui</button>
        </div>
    </div>
</div>

<!-- Reject Confirm Modal -->
<div class="modal-backdrop" id="modal-reject">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title"><i class="fas fa-circle-xmark" style="color:var(--red);margin-right:8px"></i>Konfirmasi Penolakan</div>
            <button class="modal-close" onclick="closeModal('modal-reject')"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <p style="margin-bottom:12px;color:var(--gray-600);">Anda akan menolak pendaftar:</p>
            <div style="background:var(--red-bg);border:1.5px solid var(--red-border);border-radius:10px;padding:14px 18px;margin-bottom:16px;">
                <div style="font-weight:700;color:var(--primary)" id="reject-name"></div>
                <div style="font-size:.8rem;color:var(--gray-500)" id="reject-nik"></div>
            </div>
            <div class="form-group">
                <label class="form-label">Alasan Penolakan <span style="color:var(--red)">*</span></label>
                <select class="form-control" id="reject-reason">
                    <option value="">-- Pilih alasan --</option>
                    <option>Dokumen tidak lengkap</option>
                    <option>Data tidak sesuai</option>
                    <option>Tidak memenuhi syarat usia</option>
                    <option>Kuota penuh</option>
                    <option>Lainnya</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Catatan tambahan</label>
                <textarea class="form-control" id="reject-note" rows="2" placeholder="Keterangan tambahan..."></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('modal-reject')">Batal</button>
            <button class="btn btn-danger" onclick="confirmReject()"><i class="fas fa-times"></i> Ya, Tolak</button>
        </div>
    </div>
</div>

<!-- Batch & Kuota Modal -->
<div class="modal-backdrop" id="modal-batch">
    <div class="modal" style="max-width:560px">
        <div class="modal-header">
            <div class="modal-title"><i class="fas fa-gear" style="color:var(--orange);margin-right:8px"></i>Kelola Batch &amp; Kuota</div>
            <button class="modal-close" onclick="closeModal('modal-batch')"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label class="form-label">Nama Batch</label>
                <input type="text" class="form-control" id="batch-name" value="Batch 2026 – JOG-WRO">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Tanggal Buka</label>
                    <input type="date" class="form-control" id="batch-open" value="2026-01-15">
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Tutup</label>
                    <input type="date" class="form-control" id="batch-close" value="2026-12-31">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Kuota Total</label>
                    <input type="number" class="form-control" id="batch-quota" value="50" min="1">
                </div>
                <div class="form-group">
                    <label class="form-label">Status Batch</label>
                    <select class="form-control" id="batch-status">
                        <option value="active" selected>Aktif</option>
                        <option value="closed">Tutup</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('modal-batch')">Batal</button>
            <button class="btn btn-primary" onclick="saveBatch()"><i class="fas fa-save"></i> Simpan</button>
        </div>
    </div>
</div>

<!-- Add Pendaftar Modal -->
<div class="modal-backdrop" id="modal-add">
    <div class="modal" style="max-width:540px">
        <div class="modal-header">
            <div class="modal-title"><i class="fas fa-user-plus" style="color:var(--blue);margin-right:8px"></i>Tambah Pendaftar</div>
            <button class="modal-close" onclick="closeModal('modal-add')"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap <span style="color:var(--red)">*</span></label>
                    <input type="text" class="form-control" id="add-name" placeholder="Nama lengkap">
                </div>
                <div class="form-group">
                    <label class="form-label">NIK <span style="color:var(--red)">*</span></label>
                    <input type="text" class="form-control" id="add-nik" placeholder="16 digit NIK" maxlength="16">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="add-dob">
                </div>
                <div class="form-group">
                    <label class="form-label">Jenis Kelamin</label>
                    <select class="form-control" id="add-gender">
                        <option>Laki-laki</option>
                        <option>Perempuan</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" id="add-email" placeholder="email@contoh.com">
            </div>
            <div class="form-group">
                <label class="form-label">No. Telepon</label>
                <input type="text" class="form-control" id="add-phone" placeholder="08xx-xxxx-xxxx">
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('modal-add')">Batal</button>
            <button class="btn btn-primary" onclick="addPendaftar()"><i class="fas fa-save"></i> Simpan</button>
        </div>
    </div>
</div>

<!-- Profile Modal -->
<div class="modal-backdrop" id="modal-profile">
    <div class="modal" style="max-width:400px">
        <div class="modal-header">
            <div class="modal-title"><i class="fas fa-user-circle" style="color:var(--primary);margin-right:8px"></i>Profil Admin</div>
            <button class="modal-close" onclick="closeModal('modal-profile')"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
            <div style="text-align:center;margin-bottom:20px">
                <div style="width:72px;height:72px;border-radius:50%;background:var(--primary);color:var(--accent);font-size:1.8rem;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;font-family:'Sora',sans-serif;font-weight:700">A</div>
                <div style="font-weight:700;font-size:1rem;color:var(--primary)">Admin JOG-WRO</div>
                <div style="font-size:.8rem;color:var(--gray-500)">UID-MOCK-admin-001</div>
            </div>
            <div class="detail-row"><div class="detail-label">Cabang</div><div class="detail-value">JOG-WRO</div></div>
            <div class="detail-row"><div class="detail-label">Role</div><div class="detail-value">Administrator</div></div>
            <div class="detail-row"><div class="detail-label">Terakhir Login</div><div class="detail-value" id="last-login"></div></div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('modal-profile')">Tutup</button>
            <button class="btn btn-danger" onclick="handleLogout()"><i class="fas fa-arrow-right-from-bracket"></i> Logout</button>
        </div>
    </div>
</div>

<!-- Toast container -->
<div class="toast-container" id="toastContainer"></div>

<!-- ===== JAVASCRIPT ===== -->
<script>
/* ===========================
   DATA STORE
=========================== */
let state = {
    pendaftar: [
        {
            id: 'PDR-0001',
            name: 'Budi Santoso',
            nik: '3471234567890001',
            cabang: 'JOG-WRO',
            batch: 'Batch 2026',
            status: 'draft',
            dob: '2000-04-15',
            gender: 'Laki-laki',
            email: 'budi.santoso@email.com',
            phone: '0812-3456-7890',
            registeredAt: '2026-06-07',
        }
    ],
    activeFilter: 'draft',
    searchQuery: '',
    currentPage: 1,
    perPage: 8,
    selectedId: null,
    history: [],
    batch: {
        name: 'Batch 2026 – JOG-WRO',
        open: '2026-01-15',
        close: '2026-12-31',
        quota: 50,
        status: 'active'
    }
};

/* ===========================
   INIT
=========================== */
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('last-login').textContent = new Date().toLocaleString('id-ID');
    render();
});

/* ===========================
   NAVIGATION
=========================== */
function switchPage(page) {
    document.querySelectorAll('.page-section').forEach(s => s.classList.remove('active'));
    document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
    document.getElementById('page-' + page).classList.add('active');
    document.getElementById('nav-' + page).classList.add('active');
}

/* ===========================
   MODAL
=========================== */
function openModal(id) {
    document.getElementById(id).classList.add('open');
}
function closeModal(id) {
    document.getElementById(id).classList.remove('open');
}
// Close on backdrop click
document.querySelectorAll('.modal-backdrop').forEach(bd => {
    bd.addEventListener('click', e => {
        if (e.target === bd) bd.classList.remove('open');
    });
});

/* ===========================
   RENDER TABLE
=========================== */
function getFiltered() {
    let data = state.pendaftar;
    if (state.activeFilter !== 'semua') {
        data = data.filter(p => p.status === state.activeFilter);
    }
    if (state.searchQuery) {
        const q = state.searchQuery.toLowerCase();
        data = data.filter(p =>
            p.name.toLowerCase().includes(q) ||
            p.id.toLowerCase().includes(q) ||
            p.nik.includes(q)
        );
    }
    return data;
}

function render() {
    updateCounts();
    const filtered = getFiltered();
    const total = filtered.length;
    const totalPages = Math.max(1, Math.ceil(total / state.perPage));
    if (state.currentPage > totalPages) state.currentPage = totalPages;
    const start = (state.currentPage - 1) * state.perPage;
    const pageData = filtered.slice(start, start + state.perPage);

    const tbody = document.getElementById('tableBody');
    const empty = document.getElementById('emptyState');

    if (pageData.length === 0) {
        tbody.innerHTML = '';
        empty.style.display = '';
    } else {
        empty.style.display = 'none';
        tbody.innerHTML = pageData.map((p, i) => `
            <tr>
                <td style="color:var(--gray-400);font-size:.8rem">${start + i + 1}</td>
                <td>
                    <div class="td-name">${escHtml(p.name)}</div>
                    <div class="td-id">${escHtml(p.id)}</div>
                </td>
                <td style="font-family:monospace;font-size:.82rem">${escHtml(p.nik)}</td>
                <td>${escHtml(p.cabang)}</td>
                <td>${escHtml(p.batch)}</td>
                <td>${statusBadge(p.status)}</td>
                <td style="font-size:.8rem;color:var(--gray-500)">${formatDate(p.registeredAt)}</td>
                <td>
                    <div class="actions">
                        <button class="btn-action" onclick="viewDetail('${p.id}')" title="Lihat Detail"><i class="fas fa-eye"></i></button>
                        <button class="btn-action approve" onclick="openApprove('${p.id}')" title="Setujui" ${p.status==='approved'?'disabled style="opacity:.4;cursor:not-allowed"':''}><i class="fas fa-check"></i></button>
                        <button class="btn-action reject"  onclick="openReject('${p.id}')"  title="Tolak"   ${p.status==='rejected'?'disabled style="opacity:.4;cursor:not-allowed"':''}><i class="fas fa-times"></i></button>
                    </div>
                </td>
            </tr>
        `).join('');
    }

    // Pagination info
    document.getElementById('pageInfo').textContent =
        total === 0 ? 'Tidak ada data' :
        `Menampilkan ${start+1}–${Math.min(start+state.perPage, total)} dari ${total} data`;

    renderPagination(totalPages);
}

function renderPagination(total) {
    const el = document.getElementById('pageBtns');
    if (total <= 1) { el.innerHTML = ''; return; }
    let html = `<button class="page-btn" onclick="goPage(${state.currentPage-1})" ${state.currentPage===1?'disabled':''}><i class="fas fa-chevron-left"></i></button>`;
    for (let i = 1; i <= total; i++) {
        html += `<button class="page-btn ${i===state.currentPage?'active':''}" onclick="goPage(${i})">${i}</button>`;
    }
    html += `<button class="page-btn" onclick="goPage(${state.currentPage+1})" ${state.currentPage===total?'disabled':''}><i class="fas fa-chevron-right"></i></button>`;
    el.innerHTML = html;
}

function goPage(p) {
    const filtered = getFiltered();
    const total = Math.max(1, Math.ceil(filtered.length / state.perPage));
    if (p < 1 || p > total) return;
    state.currentPage = p;
    render();
}

function updateCounts() {
    const all = state.pendaftar;
    document.getElementById('count-total').textContent    = all.length;
    document.getElementById('count-approved').textContent = all.filter(x=>x.status==='approved').length;
    document.getElementById('count-rejected').textContent = all.filter(x=>x.status==='rejected').length;
    document.getElementById('count-proses').textContent   = all.filter(x=>x.status==='proses').length;
    const pending = all.filter(x=>['draft','proses'].includes(x.status)).length;
    const badge = document.getElementById('badge-pending');
    badge.textContent = pending;
    badge.style.display = pending > 0 ? '' : 'none';
}

/* ===========================
   FILTER & SEARCH
=========================== */
function filterTab(tab) {
    state.activeFilter = tab;
    state.currentPage = 1;
    document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
    const el = document.getElementById('tab-' + tab);
    if (el) el.classList.add('active');
    switchPage('dashboard');
    render();
}

function handleSearch(q) {
    state.searchQuery = q;
    state.currentPage = 1;
    render();
}

/* ===========================
   DETAIL VIEW
=========================== */
function viewDetail(id) {
    const p = state.pendaftar.find(x => x.id === id);
    if (!p) return;
    state.selectedId = id;
    document.getElementById('detail-body').innerHTML = `
        <div class="detail-row"><div class="detail-label">ID</div><div class="detail-value">${escHtml(p.id)}</div></div>
        <div class="detail-row"><div class="detail-label">Nama</div><div class="detail-value">${escHtml(p.name)}</div></div>
        <div class="detail-row"><div class="detail-label">NIK</div><div class="detail-value" style="font-family:monospace">${escHtml(p.nik)}</div></div>
        <div class="detail-row"><div class="detail-label">Tgl. Lahir</div><div class="detail-value">${formatDate(p.dob)}</div></div>
        <div class="detail-row"><div class="detail-label">Jenis Kelamin</div><div class="detail-value">${escHtml(p.gender)}</div></div>
        <div class="detail-row"><div class="detail-label">Email</div><div class="detail-value">${escHtml(p.email)}</div></div>
        <div class="detail-row"><div class="detail-label">Telepon</div><div class="detail-value">${escHtml(p.phone)}</div></div>
        <div class="detail-row"><div class="detail-label">Cabang</div><div class="detail-value">${escHtml(p.cabang)}</div></div>
        <div class="detail-row"><div class="detail-label">Batch</div><div class="detail-value">${escHtml(p.batch)}</div></div>
        <div class="detail-row"><div class="detail-label">Tgl. Daftar</div><div class="detail-value">${formatDate(p.registeredAt)}</div></div>
        <div class="detail-row"><div class="detail-label">Status</div><div class="detail-value">${statusBadge(p.status)}</div></div>
    `;
    const approved = p.status === 'approved';
    const rejected = p.status === 'rejected';
    document.getElementById('detail-btn-approve').disabled = approved;
    document.getElementById('detail-btn-reject').disabled  = rejected;
    openModal('modal-detail');
}

function quickAction(type) {
    const id = state.selectedId;
    if (!id) return;
    closeModal('modal-detail');
    if (type === 'approve') openApprove(id);
    else openReject(id);
}

/* ===========================
   APPROVE / REJECT
=========================== */
function openApprove(id) {
    const p = state.pendaftar.find(x => x.id === id);
    if (!p) return;
    state.selectedId = id;
    document.getElementById('approve-name').textContent = p.name;
    document.getElementById('approve-nik').textContent  = 'NIK: ' + p.nik;
    document.getElementById('approve-note').value = '';
    openModal('modal-approve');
}

function confirmApprove() {
    const p = state.pendaftar.find(x => x.id === state.selectedId);
    if (!p) return;
    p.status = 'approved';
    addHistory('Menyetujui', p.name, 'approved');
    closeModal('modal-approve');
    render();
    toast('success', `<i class="fas fa-circle-check"></i> ${p.name} berhasil disetujui.`);
}

function openReject(id) {
    const p = state.pendaftar.find(x => x.id === id);
    if (!p) return;
    state.selectedId = id;
    document.getElementById('reject-name').textContent = p.name;
    document.getElementById('reject-nik').textContent  = 'NIK: ' + p.nik;
    document.getElementById('reject-reason').value = '';
    document.getElementById('reject-note').value   = '';
    openModal('modal-reject');
}

function confirmReject() {
    const reason = document.getElementById('reject-reason').value;
    if (!reason) { toast('error', '<i class="fas fa-triangle-exclamation"></i> Pilih alasan penolakan terlebih dahulu.'); return; }
    const p = state.pendaftar.find(x => x.id === state.selectedId);
    if (!p) return;
    p.status = 'rejected';
    addHistory('Menolak', p.name, 'rejected');
    closeModal('modal-reject');
    render();
    toast('error', `<i class="fas fa-circle-xmark"></i> ${p.name} telah ditolak.`);
}

/* ===========================
   ADD PENDAFTAR
=========================== */
function addPendaftar() {
    const name  = document.getElementById('add-name').value.trim();
    const nik   = document.getElementById('add-nik').value.trim();
    const dob   = document.getElementById('add-dob').value;
    const gender= document.getElementById('add-gender').value;
    const email = document.getElementById('add-email').value.trim();
    const phone = document.getElementById('add-phone').value.trim();

    if (!name || !nik) { toast('error', '<i class="fas fa-triangle-exclamation"></i> Nama dan NIK wajib diisi.'); return; }
    if (nik.length !== 16 || !/^\d+$/.test(nik)) { toast('error', '<i class="fas fa-triangle-exclamation"></i> NIK harus 16 digit angka.'); return; }

    const newId = 'PDR-' + String(state.pendaftar.length + 1).padStart(4, '0');
    state.pendaftar.push({
        id: newId, name, nik, dob, gender, email, phone,
        cabang: 'JOG-WRO',
        batch: state.batch.name,
        status: 'draft',
        registeredAt: new Date().toISOString().slice(0, 10)
    });
    addHistory('Menambah', name, 'draft');
    closeModal('modal-add');
    // Clear form
    ['add-name','add-nik','add-dob','add-email','add-phone'].forEach(id => document.getElementById(id).value = '');
    filterTab('draft');
    toast('info', `<i class="fas fa-user-plus"></i> ${name} berhasil ditambahkan.`);
}

/* ===========================
   BATCH
=========================== */
function saveBatch() {
    state.batch = {
        name:   document.getElementById('batch-name').value,
        open:   document.getElementById('batch-open').value,
        close:  document.getElementById('batch-close').value,
        quota:  parseInt(document.getElementById('batch-quota').value),
        status: document.getElementById('batch-status').value,
    };
    addHistory('Mengubah batch', state.batch.name, 'info');
    closeModal('modal-batch');
    toast('info', '<i class="fas fa-save"></i> Pengaturan batch berhasil disimpan.');
}

/* ===========================
   HISTORY
=========================== */
function addHistory(action, target, type) {
    const now = new Date().toLocaleString('id-ID');
    state.history.unshift({ time: now, action, target, type });
    renderHistory();
}

function renderHistory() {
    const tbody = document.getElementById('historyBody');
    if (state.history.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" style="text-align:center;padding:48px;color:var(--gray-400)"><i class="fas fa-clock-rotate-left" style="font-size:1.8rem;margin-bottom:10px;display:block;opacity:.4"></i>Belum ada riwayat aktivitas.</td></tr>';
        return;
    }
    tbody.innerHTML = state.history.map(h => `
        <tr>
            <td style="font-size:.78rem;color:var(--gray-500)">${h.time}</td>
            <td style="font-weight:600">${escHtml(h.action)}</td>
            <td>${escHtml(h.target)}</td>
            <td>${statusBadge(h.type)}</td>
        </tr>
    `).join('');
}

function clearHistory() {
    if (!confirm('Hapus semua riwayat aktivitas?')) return;
    state.history = [];
    renderHistory();
    toast('info', '<i class="fas fa-trash"></i> Riwayat telah dihapus.');
}

/* ===========================
   LOGOUT
=========================== */
function handleLogout() {
    if (!confirm('Anda yakin ingin logout?')) return;
    closeModal('modal-profile');
    toast('info', '<i class="fas fa-arrow-right-from-bracket"></i> Sedang logout...');
    setTimeout(() => {
        // In Laravel, this would be: window.location.href = '/logout';
        // For demo purposes:
        alert('Logout berhasil! (Redirect ke halaman login)');
    }, 1200);
}

/* ===========================
   UTILITIES
=========================== */
function statusBadge(status) {
    const map = {
        draft:    ['badge-draft',    '<i class="fas fa-file"></i>', 'DRAFT'],
        proses:   ['badge-proses',   '<i class="fas fa-rotate"></i>', 'PROSES'],
        approved: ['badge-approved', '<i class="fas fa-check"></i>', 'APPROVED'],
        rejected: ['badge-rejected', '<i class="fas fa-times"></i>', 'REJECTED'],
        info:     ['badge-draft',    '<i class="fas fa-circle-info"></i>', 'INFO'],
    };
    const [cls, icon, label] = map[status] || map.draft;
    return `<span class="badge ${cls}"><span class="badge-dot"></span>${label}</span>`;
}

function formatDate(d) {
    if (!d) return '-';
    try {
        return new Date(d).toLocaleDateString('id-ID', { day:'2-digit', month:'short', year:'numeric' });
    } catch { return d; }
}

function escHtml(str) {
    return String(str).replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]));
}

function toast(type, html) {
    const el = document.createElement('div');
    el.className = `toast ${type}`;
    el.innerHTML = html;
    document.getElementById('toastContainer').appendChild(el);
    setTimeout(() => el.remove(), 4000);
}

// Expose add pendaftar button in nav area (FAB-style)
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-backdrop.open').forEach(m => m.classList.remove('open'));
    }
});
</script>
</body>
</html>