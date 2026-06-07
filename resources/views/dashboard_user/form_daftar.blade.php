<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAKTI Portal – Formulir Peserta Didik</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy:    #1a2a6c;
            --navy-light: #2e4a96;
            --blue:    #004AAD;
            --gold:    #f5c400;
            --gold-dark: #c9a200;
            --bg:      #eef1f7;
            --surface: #ffffff;
            --surface2:#f4f6fb;
            --border:  #dde3f0;
            --text:    #1a1f36;
            --muted:   #6b7399;
            --green:   #16a34a;
            --red:     #dc2626;
            --sidebar-w: 260px;
            --topbar-h:  68px;
            --radius:  12px;
        }

        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        /* ===================== SIDEBAR ===================== */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--navy);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: fixed;
            left: 0; top: 0; bottom: 0;
            z-index: 100;
            transition: transform 0.35s cubic-bezier(0.22,1,0.36,1);
            box-shadow: 4px 0 24px rgba(26,42,108,0.18);
        }

        .sidebar-brand {
            padding: 24px 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .sidebar-logos {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 6px;
        }

        .logo-circle {
            width: 44px; height: 44px;
            background: var(--gold);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(245,196,0,0.35);
            transition: transform 0.3s ease;
        }

        .logo-circle:hover { transform: rotate(-8deg) scale(1.05); }

        .logo-kanisius {
            width: 36px; height: 36px;
            background: rgba(255,255,255,0.12);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
            border: 1px solid rgba(255,255,255,0.15);
            transition: transform 0.3s ease;
        }

        .logo-kanisius:hover { transform: rotate(8deg) scale(1.05); }

        .brand-info { flex: 1; }

        .brand-name {
            color: #fff;
            font-size: 16px;
            font-weight: 800;
            letter-spacing: 0.5px;
            line-height: 1;
        }

        .brand-sub {
            color: rgba(255,255,255,0.45);
            font-size: 10px;
            font-weight: 500;
            margin-top: 3px;
            letter-spacing: 0.8px;
            text-transform: uppercase;
        }

        /* User badge */
        .sidebar-user {
            padding: 16px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .user-badge {
            background: rgba(255,255,255,0.07);
            border-radius: 10px;
            padding: 10px 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid rgba(255,255,255,0.1);
        }

        .user-avatar {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px;
            font-weight: 800;
            color: var(--navy);
            flex-shrink: 0;
        }

        .user-info { flex: 1; min-width: 0; }

        .user-name {
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            color: rgba(255,255,255,0.45);
            font-size: 10px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .user-dot {
            width: 8px; height: 8px;
            background: #22c55e;
            border-radius: 50%;
            flex-shrink: 0;
            box-shadow: 0 0 0 2px rgba(34,197,94,0.25);
            animation: pulse-dot 2s ease infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { box-shadow: 0 0 0 2px rgba(34,197,94,0.25); }
            50%       { box-shadow: 0 0 0 5px rgba(34,197,94,0.1); }
        }

        /* Nav */
        .sidebar-nav { flex: 1; padding: 12px 12px; overflow-y: auto; }

        .nav-section-label {
            color: rgba(255,255,255,0.3);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            padding: 12px 8px 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 8px;
            color: rgba(255,255,255,0.55);
            font-size: 13.5px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            margin-bottom: 2px;
            position: relative;
        }

        .nav-item:hover {
            background: rgba(255,255,255,0.07);
            color: rgba(255,255,255,0.9);
        }

        .nav-item.active {
            background: var(--blue);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0,74,173,0.35);
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: -12px; top: 50%;
            transform: translateY(-50%);
            width: 3px; height: 60%;
            background: var(--gold);
            border-radius: 0 2px 2px 0;
        }

        .nav-icon { font-size: 16px; width: 20px; text-align: center; flex-shrink: 0; }

        .nav-badge {
            margin-left: auto;
            background: var(--gold);
            color: var(--navy);
            font-size: 10px;
            font-weight: 800;
            padding: 2px 7px;
            border-radius: 99px;
        }

        /* Sidebar footer */
        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            color: rgba(255,255,255,0.45);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            background: none;
            border: none;
            width: 100%;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .logout-btn:hover {
            background: rgba(220,38,38,0.12);
            color: #fca5a5;
        }

        /* ===================== MAIN ===================== */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* TOPBAR */
        .topbar {
            height: var(--topbar-h);
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 32px;
            gap: 16px;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 1px 12px rgba(26,42,108,0.06);
        }

        .topbar-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 20px;
            color: var(--muted);
            padding: 6px;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .topbar-toggle:hover { background: var(--bg); }

        .topbar-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
        }

        .breadcrumb-item { color: var(--muted); font-weight: 500; }
        .breadcrumb-sep { color: var(--border); }
        .breadcrumb-item.current { color: var(--text); font-weight: 700; }

        .topbar-spacer { flex: 1; }

        .topbar-actions { display: flex; align-items: center; gap: 10px; }

        .topbar-icon-btn {
            width: 38px; height: 38px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: var(--surface);
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
            transition: all 0.2s;
            position: relative;
        }

        .topbar-icon-btn:hover { background: var(--bg); border-color: var(--blue); }

        .notif-dot {
            position: absolute;
            top: 7px; right: 7px;
            width: 7px; height: 7px;
            background: var(--red);
            border-radius: 50%;
            border: 1.5px solid #fff;
        }

        .topbar-user {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            border-radius: 10px;
            border: 1px solid var(--border);
            cursor: pointer;
            transition: all 0.2s;
        }

        .topbar-user:hover { background: var(--bg); }

        .topbar-avatar {
            width: 30px; height: 30px;
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px;
            font-weight: 800;
            color: var(--navy);
        }

        .topbar-uname {
            font-size: 13px;
            font-weight: 700;
            color: var(--text);
        }

        .topbar-urole {
            font-size: 11px;
            color: var(--muted);
        }

        /* ===================== PAGE CONTENT ===================== */
        .page-content {
            flex: 1;
            padding: 32px;
            max-width: 1100px;
            width: 100%;
            margin: 0 auto;
        }

        /* PAGE HEADER */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 28px;
            gap: 20px;
            flex-wrap: wrap;
            opacity: 0;
            animation: fadeUp 0.5s ease 0.1s forwards;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .page-title { font-size: 26px; font-weight: 800; color: var(--navy); }
        .page-subtitle { color: var(--muted); font-size: 14px; margin-top: 4px; }

        .header-actions { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
            letter-spacing: 0.2px;
        }

        .btn .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transform: scale(0);
            animation: rippleAnim 0.55s linear;
            pointer-events: none;
        }

        @keyframes rippleAnim { to { transform: scale(4); opacity: 0; } }

        .btn-outline {
            background: var(--surface);
            border: 1.5px solid var(--border);
            color: var(--text);
        }

        .btn-outline:hover {
            border-color: var(--blue);
            color: var(--blue);
            background: #eef4ff;
        }

        .btn-primary {
            background: var(--blue);
            color: #fff;
            box-shadow: 0 4px 16px rgba(0,74,173,0.3);
        }

        .btn-primary:hover {
            background: #003a8c;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,74,173,0.4);
        }

        .btn-gold {
            background: var(--gold);
            color: var(--navy);
            box-shadow: 0 4px 16px rgba(245,196,0,0.35);
        }

        .btn-gold:hover {
            background: var(--gold-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(245,196,0,0.45);
        }

        /* PROGRESS BAR */
        .progress-wrap {
            background: var(--surface);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            padding: 16px 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            opacity: 0;
            animation: fadeUp 0.5s ease 0.2s forwards;
        }

        .progress-steps {
            display: flex;
            align-items: center;
            gap: 0;
            flex: 1;
        }

        .step {
            display: flex;
            align-items: center;
            gap: 8px;
            flex: 1;
            position: relative;
        }

        .step:not(:last-child)::after {
            content: '';
            flex: 1;
            height: 2px;
            background: var(--border);
            margin: 0 8px;
            border-radius: 99px;
            transition: background 0.4s;
        }

        .step.done:not(:last-child)::after { background: var(--green); }
        .step.active:not(:last-child)::after { background: var(--border); }

        .step-num {
            width: 28px; height: 28px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px;
            font-weight: 800;
            flex-shrink: 0;
            transition: all 0.3s;
        }

        .step.done .step-num { background: var(--green); color: #fff; }
        .step.active .step-num { background: var(--blue); color: #fff; box-shadow: 0 0 0 4px rgba(0,74,173,0.15); }
        .step.pending .step-num { background: var(--border); color: var(--muted); }

        .step-label { font-size: 12px; font-weight: 600; color: var(--muted); white-space: nowrap; }
        .step.active .step-label { color: var(--blue); }
        .step.done .step-label { color: var(--green); }

        /* TABS */
        .tabs-wrap {
            display: flex;
            gap: 6px;
            margin-bottom: 20px;
            background: var(--surface);
            border-radius: var(--radius);
            padding: 6px;
            border: 1px solid var(--border);
            opacity: 0;
            animation: fadeUp 0.5s ease 0.25s forwards;
            width: fit-content;
        }

        .tab-btn {
            padding: 8px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            background: none;
            color: var(--muted);
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .tab-btn.active {
            background: var(--blue);
            color: #fff;
            box-shadow: 0 2px 8px rgba(0,74,173,0.25);
        }

        .tab-tag {
            background: var(--gold);
            color: var(--navy);
            font-size: 10px;
            font-weight: 800;
            padding: 1px 7px;
            border-radius: 99px;
        }

        /* FORM CARD */
        .form-card {
            background: var(--surface);
            border-radius: 16px;
            border: 1px solid var(--border);
            padding: 28px;
            margin-bottom: 20px;
            box-shadow: 0 2px 16px rgba(26,42,108,0.05);
            opacity: 0;
            animation: fadeUp 0.5s ease 0.3s forwards;
            position: relative;
        }

        /* Data Anak badge */
        .data-anak-badge {
            position: absolute;
            top: -1px;
            right: 24px;
            background: var(--gold);
            color: var(--navy);
            font-size: 12px;
            font-weight: 800;
            padding: 7px 18px;
            border-radius: 0 0 10px 10px;
            letter-spacing: 0.3px;
            box-shadow: 0 4px 12px rgba(245,196,0,0.3);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 28px;
        }

        .form-col { display: flex; flex-direction: column; gap: 20px; }

        .col-header {
            display: flex;
            align-items: center;
            gap: 8px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 4px;
        }

        .col-header-icon { font-size: 16px; }

        .col-header-title {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: var(--muted);
        }

        /* Field group */
        .field-group { display: flex; flex-direction: column; gap: 6px; }

        .field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

        .field-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            color: var(--muted);
        }

        .field-input {
            height: 44px;
            background: var(--surface2);
            border: 1.5px solid var(--border);
            border-radius: 9px;
            padding: 0 14px;
            font-size: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text);
            font-weight: 500;
            transition: all 0.2s;
            width: 100%;
        }

        .field-input:focus {
            outline: none;
            border-color: var(--blue);
            background: #eef4ff;
            box-shadow: 0 0 0 3px rgba(0,74,173,0.1);
        }

        .field-input.is-valid { border-color: var(--green); background: #f0fdf4; }
        .field-input.is-invalid { border-color: var(--red); background: #fff5f5; animation: shake 0.35s ease; }

        @keyframes shake {
            0%,100% { transform: translateX(0); }
            25%      { transform: translateX(-5px); }
            75%      { transform: translateX(5px); }
        }

        .field-select {
            height: 44px;
            background: var(--surface2);
            border: 1.5px solid var(--border);
            border-radius: 9px;
            padding: 0 14px;
            font-size: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text);
            font-weight: 500;
            transition: all 0.2s;
            width: 100%;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7399' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            cursor: pointer;
        }

        .field-select:focus {
            outline: none;
            border-color: var(--blue);
            background-color: #eef4ff;
            box-shadow: 0 0 0 3px rgba(0,74,173,0.1);
        }

        .field-input[type="date"] {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%236b7399' stroke-width='2'%3E%3Crect x='3' y='4' width='18' height='18' rx='2' ry='2'/%3E%3Cline x1='16' y1='2' x2='16' y2='6'/%3E%3Cline x1='8' y1='2' x2='8' y2='6'/%3E%3Cline x1='3' y1='10' x2='21' y2='10'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
        }

        .field-textarea {
            background: var(--surface2);
            border: 1.5px solid var(--border);
            border-radius: 9px;
            padding: 12px 14px;
            font-size: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text);
            font-weight: 500;
            transition: all 0.2s;
            width: 100%;
            resize: none;
            height: 90px;
        }

        .field-textarea:focus {
            outline: none;
            border-color: var(--blue);
            background: #eef4ff;
            box-shadow: 0 0 0 3px rgba(0,74,173,0.1);
        }

        /* Alamat header row */
        .alamat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .samakan-btn {
            font-size: 11px;
            font-weight: 700;
            color: var(--blue);
            background: none;
            border: none;
            cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif;
            padding: 4px 8px;
            border-radius: 6px;
            transition: background 0.2s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .samakan-btn:hover { background: #eef4ff; }

        /* Upload berkas */
        .upload-section { margin-top: 4px; }

        .upload-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 10px;
            display: block;
        }

        .upload-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }

        .upload-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--surface2);
            border: 1.5px solid var(--border);
            border-radius: 9px;
            padding: 10px 14px;
            transition: all 0.2s;
            cursor: pointer;
        }

        .upload-item:hover { border-color: var(--blue); background: #eef4ff; }

        .upload-item.uploaded {
            border-color: rgba(22,163,74,0.35);
            background: #f0fdf4;
        }

        .upload-left { display: flex; align-items: center; gap: 8px; }

        .upload-icon { font-size: 16px; }

        .upload-name { font-size: 13px; font-weight: 600; color: var(--text); }

        .upload-actions { display: flex; align-items: center; gap: 6px; }

        .upload-view-btn {
            font-size: 11px;
            font-weight: 700;
            color: var(--blue);
            background: rgba(0,74,173,0.08);
            border: none;
            border-radius: 6px;
            padding: 3px 9px;
            cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: background 0.2s;
        }

        .upload-view-btn:hover { background: rgba(0,74,173,0.15); }

        .upload-del-btn {
            font-size: 14px;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--muted);
            transition: color 0.2s;
            padding: 2px;
        }

        .upload-del-btn:hover { color: var(--red); }

        /* Hidden file input */
        .upload-file-input { display: none; }

        /* ===================== BOTTOM BAR ===================== */
        .bottom-bar {
            background: var(--surface);
            border-top: 1px solid var(--border);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            opacity: 0;
            animation: fadeUp 0.5s ease 0.4s forwards;
            position: sticky;
            bottom: 0;
        }

        .back-link {
            color: var(--muted);
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s;
        }

        .back-link:hover { color: var(--blue); }

        .bottom-actions { display: flex; gap: 10px; align-items: center; }

        .btn-draft {
            background: var(--surface);
            border: 1.5px solid var(--border);
            color: var(--text);
            display: flex; align-items: center; gap: 8px;
            padding: 11px 22px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: all 0.2s;
        }

        .btn-draft:hover { border-color: var(--blue); color: var(--blue); background: #eef4ff; }

        .btn-submit {
            background: var(--navy);
            color: #fff;
            display: flex; align-items: center; gap: 10px;
            padding: 12px 28px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif;
            border: none;
            letter-spacing: 0.5px;
            transition: all 0.2s;
            position: relative;
            overflow: hidden;
        }

        .btn-submit:hover {
            background: #111c50;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(26,42,108,0.35);
        }

        .btn-submit .arrow {
            font-size: 18px;
            transition: transform 0.25s;
        }

        .btn-submit:hover .arrow { transform: translateX(4px); }

        /* TOAST */
        #toast {
            position: fixed;
            bottom: 90px;
            left: 50%;
            transform: translateX(-50%) translateY(60px);
            background: var(--navy);
            color: white;
            padding: 12px 24px;
            border-radius: 40px;
            font-size: 13.5px;
            font-weight: 600;
            opacity: 0;
            pointer-events: none;
            transition: transform 0.4s cubic-bezier(0.22,1,0.36,1), opacity 0.4s;
            z-index: 9999;
            white-space: nowrap;
            box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        }

        #toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }

        /* OVERLAY for mobile sidebar */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 99;
            backdrop-filter: blur(2px);
        }

        .sidebar-overlay.show { display: block; }

        /* ===================== RESPONSIVE ===================== */
        @media (max-width: 1024px) {
            :root { --sidebar-w: 230px; }
            .page-content { padding: 24px; }
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main { margin-left: 0; }
            .topbar-toggle { display: flex; }
            .form-grid { grid-template-columns: 1fr; }
            .page-content { padding: 20px 16px; }
            .upload-grid { grid-template-columns: 1fr; }
            .field-row { grid-template-columns: 1fr; }
            .bottom-bar { padding: 14px 16px; }
            .progress-wrap { display: none; }
            .page-title { font-size: 20px; }
        }

        @media (max-width: 480px) {
            .header-actions { width: 100%; }
            .btn { font-size: 12px; padding: 9px 14px; }
            .tabs-wrap { width: 100%; overflow-x: auto; }
        }
    </style>
</head>
<body>

<!-- Sidebar overlay (mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<!-- ===================== SIDEBAR ===================== -->
<aside class="sidebar" id="sidebar">

    <!-- Brand -->
    <div class="sidebar-brand">
        <div class="sidebar-logos">
            <!-- Logo SAKTI (topi wisuda) -->
            <div class="logo-circle" title="SAKTI">🎓</div>
            <!-- Logo Kapal Kanisius -->
            <div class="logo-kanisius" title="E-Kanisius">⛵</div>
            <div class="brand-info">
                <div class="brand-name">SAKTI PORTAL</div>
                <div class="brand-sub">E-Kanisius</div>
            </div>
        </div>
        <div style="font-family:'DM Mono',monospace; font-size:9px; color:rgba(255,255,255,0.25); letter-spacing:0.5px; padding-left:2px;">
            UID-jzp4Z3bwwoNY7IhFuiPNdTs83
        </div>
    </div>

    <!-- User badge -->
    <div class="sidebar-user">
        <div class="user-badge">
            <div class="user-avatar">IA</div>
            <div class="user-info">
                <div class="user-name">Ignatius Arya</div>
                <div class="user-role">Cabang Global · Parent</div>
            </div>
            <div class="user-dot"></div>
        </div>
    </div>

    <!-- Nav -->
    <nav class="sidebar-nav">
        <div class="nav-section-label">Menu Utama</div>

        <a class="nav-item" href="#" onclick="setActive(this)">
            <span class="nav-icon">📊</span> Dashboard
        </a>
        <a class="nav-item active" href="#" onclick="setActive(this)">
            <span class="nav-icon">📋</span> Formulir Peserta Didik
            <span class="nav-badge">1</span>
        </a>
        <a class="nav-item" href="#" onclick="setActive(this)">
            <span class="nav-icon">🕐</span> Riwayat
        </a>
        <a class="nav-item" href="#" onclick="setActive(this)">
            <span class="nav-icon">📁</span> Dokumen Saya
        </a>

        <div class="nav-section-label" style="margin-top:8px;">Lainnya</div>

        <a class="nav-item" href="#" onclick="setActive(this)">
            <span class="nav-icon">💬</span> Pusat Bantuan
        </a>
        <a class="nav-item" href="#" onclick="setActive(this)">
            <span class="nav-icon">⚙️</span> Pengaturan
        </a>
    </nav>

    <div class="sidebar-footer">
        <button class="logout-btn">
            <span>🚪</span> Keluar
        </button>
    </div>
</aside>

<!-- ===================== MAIN ===================== -->
<div class="main">

    <!-- TOPBAR -->
    <header class="topbar">
        <button class="topbar-toggle" onclick="toggleSidebar()">☰</button>
        <div class="topbar-breadcrumb">
            <span class="breadcrumb-item">Dashboard</span>
            <span class="breadcrumb-sep">›</span>
            <span class="breadcrumb-item current">Formulir Peserta Didik</span>
        </div>
        <div class="topbar-spacer"></div>
        <div class="topbar-actions">
            <button class="topbar-icon-btn" title="Notifikasi" onclick="showToast('🔔 Tidak ada notifikasi baru')">
                🔔
                <span class="notif-dot"></span>
            </button>
            <button class="topbar-icon-btn" title="Bantuan" onclick="showToast('💬 Menghubungkan ke pusat bantuan...')">❓</button>
            <div class="topbar-user">
                <div class="topbar-avatar">IA</div>
                <div>
                    <div class="topbar-uname">Ignatius Arya</div>
                    <div class="topbar-urole">Parent · Cabang Global</div>
                </div>
            </div>
        </div>
    </header>

    <!-- PAGE CONTENT -->
    <div class="page-content">

        <!-- PAGE HEADER -->
        <div class="page-header">
            <div>
                <h1 class="page-title">Formulir Peserta Didik</h1>
                <p class="page-subtitle">Unit Tujuan: <strong>• 1 Calon Murid</strong></p>
            </div>
            <div class="header-actions">
                <button class="btn btn-outline" onclick="addAnak(); addRipple(this, event)">
                    ＋ TAMBAH ANAK
                </button>
                <button class="btn btn-gold" onclick="fillWithOCR(); addRipple(this, event)">
                    ✨ FILL WITH AI (OCR)
                </button>
            </div>
        </div>

        <!-- PROGRESS STEPS -->
        <div class="progress-wrap">
            <div class="progress-steps">
                <div class="step done">
                    <div class="step-num">✓</div>
                    <span class="step-label">Profil Ortu</span>
                </div>
                <div class="step active">
                    <div class="step-num">2</div>
                    <span class="step-label">Data Peserta</span>
                </div>
                <div class="step pending">
                    <div class="step-num">3</div>
                    <span class="step-label">Dokumen</span>
                </div>
                <div class="step pending">
                    <div class="step-num">4</div>
                    <span class="step-label">Review</span>
                </div>
            </div>
        </div>

        <!-- TABS -->
        <div class="tabs-wrap">
            <button class="tab-btn active" onclick="switchTab(this, 0)">
                Data Anak 1 <span class="tab-tag">AKTIF</span>
            </button>
        </div>

        <!-- FORM CARD -->
        <div class="form-card" id="formCard">
            <div class="data-anak-badge">DATA ANAK 1</div>

            <div class="form-grid">

                <!-- LEFT: IDENTITAS DASAR -->
                <div class="form-col">
                    <div class="col-header">
                        <span class="col-header-icon">👤</span>
                        <span class="col-header-title">Identitas Dasar</span>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Nama Lengkap</label>
                        <input type="text" class="field-input" id="namaLengkap"
                            placeholder="Masukkan nama lengkap"
                            value="Benedictus Kanisius"
                            oninput="validateField(this, v => v.trim().length >= 3)">
                    </div>

                    <div class="field-group">
                        <label class="field-label">NIK (Nomor Induk Kependudukan)</label>
                        <input type="text" class="field-input" id="nik"
                            placeholder="16 digit NIK"
                            value="3374012305180001"
                            maxlength="16"
                            oninput="validateField(this, v => /^\d{16}$/.test(v)); formatNIK(this)">
                    </div>

                    <div class="field-row">
                        <div class="field-group">
                            <label class="field-label">Tanggal Lahir</label>
                            <input type="date" class="field-input" id="tanggalLahir"
                                value="2018-05-12"
                                onchange="validateField(this, v => v !== '')">
                        </div>
                        <div class="field-group">
                            <label class="field-label">Gol. Darah</label>
                            <select class="field-select" id="golDarah" onchange="validateField(this, v => v !== '')">
                                <option value="">Pilih</option>
                                <option value="A" selected>A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- RIGHT: INFORMASI LANJUTAN -->
                <div class="form-col">
                    <div class="col-header">
                        <span class="col-header-icon">📋</span>
                        <span class="col-header-title">Informasi Lanjutan</span>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Agama</label>
                        <select class="field-select" id="agama" onchange="validateField(this, v => v !== '')">
                            <option value="">Pilih Agama</option>
                            <option value="kristen" selected>Kristen</option>
                            <option value="katolik">Katolik</option>
                            <option value="islam">Islam</option>
                            <option value="buddha">Buddha</option>
                            <option value="hindu">Hindu</option>
                            <option value="konghucu">Konghucu</option>
                        </select>
                    </div>

                    <div class="field-group">
                        <div class="alamat-header">
                            <label class="field-label">Alamat Domisili Anak</label>
                            <button class="samakan-btn" onclick="samakan()">SAMAKAN DENGAN ALAMAT ORTU</button>
                        </div>
                        <textarea class="field-textarea" id="alamat"
                            placeholder="Masukkan alamat lengkap...">Jl. Purbayan No. 1, Surakarta</textarea>
                    </div>

                    <!-- Upload Berkas -->
                    <div class="upload-section">
                        <span class="upload-label">📎 Upload Berkas Fisik</span>
                        <div class="upload-grid">

                            <label class="upload-item uploaded" id="upload-kk">
                                <div class="upload-left">
                                    <span class="upload-icon">✅</span>
                                    <span class="upload-name">Kartu Keluarga</span>
                                </div>
                                <div class="upload-actions">
                                    <button class="upload-view-btn" onclick="viewDoc(event,'Kartu Keluarga')">LIHAT</button>
                                    <button class="upload-del-btn" onclick="deleteDoc(event,'upload-kk')">🔄</button>
                                </div>
                                <input type="file" class="upload-file-input" accept="image/*,.pdf" onchange="uploadFile(this,'upload-kk')">
                            </label>

                            <label class="upload-item uploaded" id="upload-akte">
                                <div class="upload-left">
                                    <span class="upload-icon">✅</span>
                                    <span class="upload-name">Akte Kelahiran</span>
                                </div>
                                <div class="upload-actions">
                                    <button class="upload-view-btn" onclick="viewDoc(event,'Akte Kelahiran')">LIHAT</button>
                                    <button class="upload-del-btn" onclick="deleteDoc(event,'upload-akte')">🔄</button>
                                </div>
                                <input type="file" class="upload-file-input" accept="image/*,.pdf" onchange="uploadFile(this,'upload-akte')">
                            </label>

                            <label class="upload-item uploaded" id="upload-ktp">
                                <div class="upload-left">
                                    <span class="upload-icon">✅</span>
                                    <span class="upload-name">E-KTP Orang Tua</span>
                                </div>
                                <div class="upload-actions">
                                    <button class="upload-view-btn" onclick="viewDoc(event,'E-KTP Orang Tua')">LIHAT</button>
                                    <button class="upload-del-btn" onclick="deleteDoc(event,'upload-ktp')">🔄</button>
                                </div>
                                <input type="file" class="upload-file-input" accept="image/*,.pdf" onchange="uploadFile(this,'upload-ktp')">
                            </label>

                            <label class="upload-item uploaded" id="upload-foto">
                                <div class="upload-left">
                                    <span class="upload-icon">✅</span>
                                    <span class="upload-name">Pas Foto (3x4)</span>
                                </div>
                                <div class="upload-actions">
                                    <button class="upload-view-btn" onclick="viewDoc(event,'Pas Foto 3x4')">LIHAT</button>
                                    <button class="upload-del-btn" onclick="deleteDoc(event,'upload-foto')">🔄</button>
                                </div>
                                <input type="file" class="upload-file-input" accept="image/*" onchange="uploadFile(this,'upload-foto')">
                            </label>

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div><!-- /page-content -->

    <!-- BOTTOM BAR -->
    <div class="bottom-bar">
        <a href="#" class="back-link" onclick="showToast('↩ Kembali ke Profil Ortu')">← Kembali ke Profil Ortu</a>
        <div class="bottom-actions">
            <button class="btn-draft" onclick="saveDraft(); addRipple(this, event)">
                💾 SIMPAN DRAFT
            </button>
            <button class="btn-submit" id="submitBtn" onclick="submitForm(); addRipple(this, event)">
                SUBMIT SEKARANG <span class="arrow">›</span>
            </button>
        </div>
    </div>

</div><!-- /main -->

<!-- Toast -->
<div id="toast"></div>

<script>
/* ============================================================
   SIDEBAR TOGGLE
============================================================ */
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    sidebar.classList.toggle('open');
    overlay.classList.toggle('show');
}

function closeSidebar() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('sidebarOverlay').classList.remove('show');
}

/* ============================================================
   NAV ACTIVE STATE
============================================================ */
function setActive(el) {
    document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
    el.classList.add('active');
}

/* ============================================================
   RIPPLE EFFECT
============================================================ */
function addRipple(btn, e) {
    if (!e) return;
    const rect   = btn.getBoundingClientRect();
    const x      = e.clientX - rect.left;
    const y      = e.clientY - rect.top;
    const ripple = document.createElement('span');
    ripple.className = 'ripple';
    ripple.style.cssText = `left:${x}px;top:${y}px;width:${rect.width}px;height:${rect.width}px;margin-left:-${rect.width/2}px;margin-top:-${rect.width/2}px;`;
    btn.appendChild(ripple);
    setTimeout(() => ripple.remove(), 600);
}

/* ============================================================
   TOAST
============================================================ */
function showToast(msg, dur = 3000) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), dur);
}

/* ============================================================
   FIELD VALIDATION
============================================================ */
function validateField(el, rule) {
    const ok = rule(el.value);
    el.classList.toggle('is-valid',   ok);
    el.classList.toggle('is-invalid', !ok && el.value.length > 0);
}

/* ============================================================
   NIK FORMAT (digit only)
============================================================ */
function formatNIK(el) {
    el.value = el.value.replace(/\D/g, '').slice(0, 16);
}

/* ============================================================
   SAMAKAN ALAMAT
============================================================ */
function samakan() {
    const textarea = document.getElementById('alamat');
    const ortuAddr = 'Jl. Purbayan No. 1, Surakarta';
    textarea.style.transition = 'background 0.3s';
    textarea.style.background = '#dde4f0';
    textarea.value = ortuAddr;
    setTimeout(() => textarea.style.background = '', 600);
    showToast('✅ Alamat disalin dari data orang tua');
}

/* ============================================================
   TAMBAH ANAK (add tab)
============================================================ */
let anakCount = 1;

function addAnak() {
    anakCount++;
    const tabs = document.querySelector('.tabs-wrap');

    // Remove old active tag
    document.querySelectorAll('.tab-btn .tab-tag').forEach(t => t.remove());

    const btn = document.createElement('button');
    btn.className = 'tab-btn';
    btn.innerHTML = `Data Anak ${anakCount} <span class="tab-tag">AKTIF</span>`;
    btn.onclick = function() { switchTab(this, anakCount - 1); };
    tabs.appendChild(btn);

    switchTab(btn, anakCount - 1);
    document.getElementById('formCard').querySelector('.data-anak-badge').textContent = `DATA ANAK ${anakCount}`;
    showToast(`✅ Data Anak ${anakCount} ditambahkan`);
}

function switchTab(btn, idx) {
    document.querySelectorAll('.tab-btn').forEach(b => {
        b.classList.remove('active');
        const tag = b.querySelector('.tab-tag');
        if (tag) tag.remove();
    });
    btn.classList.add('active');
    const tag = document.createElement('span');
    tag.className = 'tab-tag';
    tag.textContent = 'AKTIF';
    btn.appendChild(tag);
    document.getElementById('formCard').querySelector('.data-anak-badge').textContent = `DATA ANAK ${idx + 1}`;
}

/* ============================================================
   FILL WITH AI (OCR)
============================================================ */
function fillWithOCR() {
    showToast('🤖 AI sedang membaca dokumen...');
    const btn = document.querySelector('.btn-gold');
    btn.disabled = true;
    btn.textContent = '⏳ Memproses...';

    const fields = [
        { id: 'namaLengkap', val: 'Benedictus Kanisius' },
        { id: 'nik',         val: '3374012305180001' },
        { id: 'tanggalLahir',val: '2018-05-12' },
    ];

    fields.forEach((f, i) => {
        setTimeout(() => {
            const el = document.getElementById(f.id);
            el.style.transition = 'background 0.3s, border-color 0.3s';
            el.style.background = '#fff9db';
            el.style.borderColor = 'var(--gold)';
            el.value = f.val;
            setTimeout(() => {
                el.style.background = '';
                el.style.borderColor = '';
                el.classList.add('is-valid');
            }, 700);
        }, i * 400);
    });

    setTimeout(() => {
        btn.disabled = false;
        btn.innerHTML = '✨ FILL WITH AI (OCR)';
        showToast('✅ Data berhasil diisi oleh AI OCR!');
    }, fields.length * 400 + 800);
}

/* ============================================================
   UPLOAD FILE
============================================================ */
function uploadFile(input, itemId) {
    const item = document.getElementById(itemId);
    if (input.files && input.files[0]) {
        const name = input.files[0].name.slice(0, 18) + (input.files[0].name.length > 18 ? '…' : '');
        item.classList.add('uploaded');
        item.querySelector('.upload-icon').textContent = '✅';
        showToast(`📎 "${name}" berhasil diupload`);
    }
}

function viewDoc(e, name) {
    e.preventDefault();
    showToast(`👁 Membuka ${name}...`);
}

function deleteDoc(e, itemId) {
    e.preventDefault();
    const item = document.getElementById(itemId);
    item.classList.remove('uploaded');
    item.querySelector('.upload-icon').textContent = '📄';
    showToast('🗑 File dihapus');
}

/* ============================================================
   SAVE DRAFT
============================================================ */
function saveDraft() {
    const btn = document.querySelector('.btn-draft');
    btn.textContent = '⏳ Menyimpan...';
    btn.disabled = true;

    setTimeout(() => {
        btn.innerHTML = '✅ Draft Tersimpan';
        showToast('💾 Draft berhasil disimpan!');
        setTimeout(() => {
            btn.innerHTML = '💾 SIMPAN DRAFT';
            btn.disabled = false;
        }, 2000);
    }, 1200);
}

/* ============================================================
   SUBMIT FORM
============================================================ */
function submitForm() {
    const required = ['namaLengkap', 'nik', 'tanggalLahir'];
    let hasError = false;

    required.forEach(id => {
        const el = document.getElementById(id);
        if (!el.value.trim()) {
            el.classList.add('is-invalid');
            el.style.animation = 'none';
            requestAnimationFrame(() => el.style.animation = '');
            hasError = true;
        }
    });

    if (hasError) {
        showToast('⚠️ Lengkapi semua field wajib terlebih dahulu.');
        return;
    }

    const btn = document.getElementById('submitBtn');
    btn.innerHTML = '⏳ Memproses... <span class="arrow">›</span>';
    btn.disabled = true;

    setTimeout(() => {
        btn.innerHTML = '✅ Berhasil Disubmit! <span class="arrow">›</span>';
        showToast('🎉 Formulir berhasil disubmit! Menunggu verifikasi.', 4000);

        // Progress step update
        const steps = document.querySelectorAll('.step');
        if (steps[1]) {
            steps[1].classList.remove('active');
            steps[1].classList.add('done');
            steps[1].querySelector('.step-num').textContent = '✓';
        }
        if (steps[2]) {
            steps[2].classList.remove('pending');
            steps[2].classList.add('active');
        }
    }, 1800);
}

/* ============================================================
   KEYBOARD SHORTCUT: Ctrl+S → save draft
============================================================ */
document.addEventListener('keydown', (e) => {
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        saveDraft();
    }
});

/* ============================================================
   ANIMATE FORM ITEMS on scroll
============================================================ */
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, { threshold: 0.1 });

document.querySelectorAll('.form-card, .progress-wrap, .tabs-wrap').forEach(el => {
    observer.observe(el);
});
</script>

</body>
</html>