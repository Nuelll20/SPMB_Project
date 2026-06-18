@php
    $fmtMoney = fn($value) => 'Rp ' . number_format((float) ($value ?? 0), 0, ',', '.');
    $fmtDate = function ($value) {
        if (!$value) return '-';
        try { return \Carbon\Carbon::parse($value)->format('d/m/Y'); } catch (\Throwable $e) { return $value; }
    };
    $maxChart = max(1, collect($chartData ?? [])->max('total') ?: 1);
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SAKTI Portal - Dashboard Kepala Sekolah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary: #053b70;
            --primary-2: #0b4d87;
            --deep: #062b54;
            --accent: #ffcc19;
            --muted: #8ea0b7;
            --text: #0f2a44;
            --soft: #f4f7fb;
            --line: #e8eef6;
            --green: #21c99a;
            --green-soft: #e9fbf5;
            --orange: #ffad32;
            --orange-soft: #fff7e8;
            --red: #ef4444;
            --red-soft: #fff1f2;
            --shadow: 0 22px 55px rgba(8, 33, 62, .10);
            --shadow-sm: 0 10px 26px rgba(8, 33, 62, .08);
            --radius: 28px;
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at 0 0, rgba(5, 59, 112, .07) 0, transparent 28%),
                radial-gradient(circle at 100% 100%, rgba(5, 59, 112, .08) 0, transparent 32%),
                #f8fafc;
            overflow-x: hidden;
        }
        body::before,
        body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }
        body::before {
            width: 420px;
            height: 420px;
            left: -160px;
            top: -90px;
            background: rgba(5, 59, 112, .05);
        }
        body::after {
            width: 520px;
            height: 520px;
            right: -220px;
            bottom: -230px;
            background: rgba(5, 59, 112, .055);
        }

        .shell {
            width: min(1180px, calc(100% - 42px));
            margin: 14px auto 48px;
            position: relative;
            z-index: 1;
        }

        .topbar {
            height: 70px;
            padding: 0 22px;
            border-radius: 0 0 24px 24px;
            background: rgba(255,255,255,.93);
            border: 1px solid rgba(232,238,246,.9);
            box-shadow: 0 16px 36px rgba(15, 42, 68, .13);
            display: flex;
            align-items: center;
            gap: 24px;
            backdrop-filter: blur(10px);
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 245px;
        }
        .brand-logo {
            width: 86px;
            height: 45px;
            border-radius: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            box-shadow: none;
            flex-shrink: 0;
        }
        .brand-logo img { width: 85px; height: auto; object-fit: contain; display: block; }
        .brand-title {
            font-family: 'Sora', sans-serif;
            font-size: 18px;
            color: var(--primary);
            font-weight: 800;
            line-height: 1;
            letter-spacing: -.03em;
        }
        .brand-sub {
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
            color: #9aa9bb;
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .02em;
        }
        .pill-mini {
            padding: 3px 7px;
            border-radius: 99px;
            background: #fff8d4;
            color: #9d7600;
            border: 1px solid #ffebb0;
            line-height: 1;
        }
        .topnav {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            flex: 1;
        }
        .topnav a,
        .topnav button {
            border: none;
            background: transparent;
            padding: 10px 12px;
            border-radius: 999px;
            color: #76869b;
            font-size: 12px;
            font-weight: 900;
            text-decoration: none;
            cursor: pointer;
        }
        .topnav .active { color: var(--primary); }
        .topnav i { margin-right: 6px; opacity: .75; }
        .userbox {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-left: auto;
        }
        .user-meta { text-align: right; line-height: 1.15; }
        .user-name { font-size: 12px; font-weight: 900; color: #0d2e56; }
        .user-branch { font-size: 9px; font-weight: 800; color: #93a4b8; }
        .logout {
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 14px;
            background: #fff4f4;
            color: #ff6363;
            cursor: pointer;
            font-size: 15px;
        }

        .hero-card {
            margin-top: 68px;
            background: rgba(255,255,255,.96);
            border: 1px solid var(--line);
            border-radius: 34px;
            box-shadow: var(--shadow);
            padding: 42px 38px 38px;
            min-height: 560px;
            position: relative;
        }
        .hero-header {
            display: flex;
            justify-content: space-between;
            gap: 22px;
            align-items: flex-start;
            border-bottom: 1px solid #eef3f9;
            padding-bottom: 24px;
            margin-bottom: 32px;
        }
        .eyebrow {
            color: #70839b;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .08em;
            text-transform: uppercase;
        }
        h1 {
            margin: 0 0 10px;
            font-family: 'Sora', sans-serif;
            color: var(--primary);
            font-size: clamp(28px, 4vw, 40px);
            line-height: 1;
            letter-spacing: -.06em;
        }
        .tabs {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .tab-btn {
            border: none;
            height: 30px;
            padding: 0 18px;
            border-radius: 999px;
            background: #f2f6fb;
            color: #8ca0b8;
            font-size: 10px;
            font-weight: 900;
            letter-spacing: .03em;
            text-transform: uppercase;
            cursor: pointer;
        }
        .tab-btn.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 10px 20px rgba(5, 59, 112, .20);
        }
        .brain-icon {
            font-size: 43px;
            color: var(--accent);
            margin-top: 8px;
        }
        .tab-panel { display: none; }
        .tab-panel.active { display: block; animation: fade .25s ease; }
        @keyframes fade { from { opacity: .2; transform: translateY(8px);} to { opacity: 1; transform: none; } }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 34px;
        }
        .ai-card {
            min-height: 330px;
            border-radius: 34px;
            background: linear-gradient(145deg, #053e75, #073665 68%, #082b55);
            color: white;
            padding: 36px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 48px rgba(5, 59, 112, .22);
        }
        .ai-card::after {
            content: '✦';
            position: absolute;
            right: 44px;
            top: 58px;
            color: rgba(255,255,255,.12);
            font-size: 105px;
            transform: rotate(-12deg);
        }
        .small-label {
            color: #b9d2ef;
            text-transform: uppercase;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .26em;
        }
        .seat-number {
            display: flex;
            align-items: flex-end;
            gap: 10px;
            margin: 12px 0 22px;
        }
        .seat-number strong {
            font-size: 64px;
            line-height: .88;
            color: var(--accent);
            font-family: 'Sora', sans-serif;
            letter-spacing: -.08em;
        }
        .seat-number span { font-size: 24px; font-weight: 900; color: #d8eaff; margin-bottom: 7px; }
        .progress-line {
            height: 14px;
            border-radius: 999px;
            padding: 2px;
            background: rgba(48, 94, 180, .60);
            border: 1px solid rgba(117, 158, 240, .35);
        }
        .progress-line div {
            height: 100%;
            border-radius: 999px;
            background: var(--accent);
            min-width: 8px;
        }
        .progress-meta {
            display: flex;
            justify-content: space-between;
            margin-top: 12px;
            color: #c4d8ef;
            font-size: 10px;
            font-weight: 900;
            letter-spacing: .09em;
            text-transform: uppercase;
        }
        .insight-box {
            margin-top: 28px;
            border-radius: 22px;
            background: rgba(9, 53, 102, .88);
            border: 1px solid rgba(255,255,255,.12);
            padding: 18px 18px 18px 64px;
            position: relative;
            color: #e8f3ff;
            font-size: 12px;
            line-height: 1.7;
            font-weight: 800;
        }
        .insight-box i {
            position: absolute;
            left: 20px;
            top: 20px;
            width: 30px;
            height: 30px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            background: var(--accent);
            color: var(--deep);
        }
        .insight-box b { color: var(--accent); }

        .chart-card, .white-panel {
            border-radius: 34px;
            background: white;
            border: 1px solid var(--line);
            box-shadow: var(--shadow-sm);
            padding: 34px;
        }
        .panel-title-row {
            display: flex;
            justify-content: space-between;
            gap: 14px;
            align-items: center;
            margin-bottom: 22px;
        }
        .panel-title {
            font-size: 17px;
            color: #183a5d;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: -.02em;
        }
        .chart-bars {
            display: flex;
            align-items: flex-end;
            gap: 16px;
            height: 246px;
            padding: 24px 8px 0;
        }
        .bar-wrap {
            flex: 1;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            align-items: center;
            gap: 10px;
        }
        .bar-bg {
            width: 100%;
            max-width: 56px;
            height: 100%;
            border-radius: 14px 14px 8px 8px;
            background: #f3f6fa;
            display: flex;
            align-items: flex-end;
            padding: 0;
            overflow: hidden;
        }
        .bar-fill {
            width: 100%;
            background: var(--primary);
            border-radius: 14px 14px 8px 8px;
            min-height: 8px;
        }
        .bar-label { font-size: 10px; color: #8ea0b7; font-weight: 900; }
        .bar-total { font-size: 11px; color: #193c61; font-weight: 900; }

        .metric-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-top: 28px;
        }
        .metric-card {
            background: #f8fbfe;
            border: 1px solid var(--line);
            border-radius: 22px;
            padding: 18px;
        }
        .metric-card .label { color: var(--muted); font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: .05em; }
        .metric-card .value { margin-top: 8px; font-size: 28px; font-weight: 900; color: var(--primary); font-family: 'Sora', sans-serif; }

        .action-strip {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-top: 22px;
            padding: 18px;
            border-radius: 24px;
            background: #f7faff;
            border: 1px solid var(--line);
        }
        .action-strip strong { display: block; font-size: 14px; color: #16395c; }
        .action-strip span { display: block; margin-top: 3px; font-size: 11px; color: var(--muted); font-weight: 700; }
        .btn-main {
            border: none;
            border-radius: 15px;
            background: var(--primary);
            color: white;
            padding: 14px 20px;
            font-size: 12px;
            font-weight: 900;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            cursor: pointer;
            box-shadow: 0 14px 26px rgba(5, 59, 112, .18);
            white-space: nowrap;
        }
        .btn-soft {
            border: 1px solid var(--line);
            border-radius: 15px;
            background: white;
            color: var(--primary);
            padding: 12px 16px;
            font-size: 12px;
            font-weight: 900;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .staff-layout {
            display: grid;
            grid-template-columns: 1.2fr .9fr;
            gap: 36px;
            align-items: start;
        }
        .staff-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 22px;
        }
        .active-pill {
            padding: 7px 12px;
            border-radius: 999px;
            color: #1f6cad;
            background: #e9f4ff;
            font-size: 10px;
            font-weight: 900;
        }
        .staff-list { display: grid; gap: 14px; }
        .staff-card {
            width: min(360px, 100%);
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 18px 22px;
            border-radius: 22px;
            border: 1px solid var(--line);
            background: white;
            box-shadow: var(--shadow-sm);
        }
        .avatar {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            background: #eef5ff;
            color: #2a6acb;
            font-weight: 900;
        }
        .staff-name { font-size: 14px; font-weight: 900; color: #183a5d; }
        .staff-email { margin-top: 3px; font-size: 10px; font-weight: 800; color: var(--muted); text-transform: uppercase; }
        .form-card {
            padding: 32px;
            border-radius: 32px;
            background: white;
            border: 1px solid var(--line);
            box-shadow: var(--shadow-sm);
        }
        .form-title { font-size: 19px; font-weight: 900; color: #15395d; letter-spacing: -.02em; }
        .form-sub { margin: 4px 0 24px; font-size: 11px; font-weight: 900; color: #8da0b6; text-transform: uppercase; letter-spacing: .08em; }
        .field { margin-bottom: 16px; }
        .field label { display: block; margin-bottom: 8px; font-size: 10px; font-weight: 900; color: #8da0b6; text-transform: uppercase; letter-spacing: .1em; }
        .field input, .field textarea {
            width: 100%;
            border: 1px solid transparent;
            outline: none;
            border-radius: 16px;
            background: #f5f8fb;
            padding: 15px 16px;
            color: #14395d;
            font-weight: 800;
            font-family: inherit;
        }
        .field input:focus, .field textarea:focus { border-color: #bdd5ef; background: white; }
        .field small { color: #ef4444; font-weight: 800; display: block; margin-top: 6px; }

        .invoice-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
        }
        .invoice-column h3 {
            margin: 0 0 6px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #173a5e;
            font-size: 16px;
        }
        .invoice-column h3 span {
            width: 28px;
            height: 28px;
            border-radius: 10px;
            display: grid;
            place-items: center;
            font-size: 12px;
        }
        .ico-orange { color: var(--orange); background: var(--orange-soft); }
        .ico-green { color: var(--green); background: var(--green-soft); }
        .invoice-column p { margin: 0 0 18px; color: #9aaabc; font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: .08em; }
        .invoice-list { display: grid; gap: 14px; }
        .invoice-filter-card {
            margin-bottom: 14px;
            border: 1px solid var(--line);
            border-radius: 22px;
            background: #f8fbff;
            padding: 14px;
        }
        .invoice-filter-card label {
            display: block;
            margin-bottom: 8px;
            color: #7890aa;
            font-size: 10px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .08em;
        }
        .invoice-filter-input {
            width: 100%;
            border: 1px solid #e3ecf7;
            border-radius: 16px;
            background: #fff;
            outline: none;
            padding: 13px 14px;
            color: #14395d;
            font-family: inherit;
            font-size: 12px;
            font-weight: 850;
        }
        .invoice-filter-input:focus { border-color: #bdd5ef; box-shadow: 0 0 0 4px rgba(5, 59, 112, .06); }
        .invoice-selection-hint {
            margin-top: 9px;
            color: #91a3b8;
            font-size: 10px;
            font-weight: 850;
            line-height: 1.55;
        }
        .invoice-card {
            border: 1px solid var(--line);
            border-radius: 24px;
            background: #fbfdff;
            padding: 18px;
        }
        .invoice-approval-card {
            cursor: pointer;
            transition: .18s ease;
        }
        .invoice-approval-card:hover {
            border-color: #bdd5ef;
            box-shadow: 0 14px 26px rgba(5, 59, 112, .08);
            transform: translateY(-1px);
        }
        .invoice-approval-card.selected {
            cursor: default;
            background: #fff;
            border-color: #a9c8ec;
            box-shadow: 0 18px 36px rgba(5, 59, 112, .10);
        }
        .invoice-approval-card:not(.selected) .invoice-details { display: none; }
        .invoice-select-chip {
            margin-top: 10px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 11px;
            border-radius: 999px;
            background: #eff6ff;
            color: var(--primary);
            border: 1px solid #d9e8f8;
            font-size: 10px;
            font-weight: 900;
            pointer-events: none;
        }
        .invoice-approval-card.selected .invoice-select-chip { display: none; }
        .invoice-hidden-by-filter { display: none !important; }
        .invoice-top { display: flex; justify-content: space-between; gap: 12px; align-items: start; }
        .invoice-no { color: var(--primary); font-size: 13px; font-weight: 900; }
        .invoice-name { margin-top: 3px; font-size: 12px; font-weight: 800; color: #54708d; }
        .invoice-amount { margin-top: 12px; font-family: 'Sora', sans-serif; color: #15395d; font-size: 19px; font-weight: 900; }
        .status-pill { padding: 6px 10px; border-radius: 999px; font-size: 9px; font-weight: 900; text-transform: uppercase; white-space: nowrap; }
        .pending { background: var(--orange-soft); color: #b36a00; }
        .valid { background: var(--green-soft); color: #10906c; }
        .invoice-actions { display: flex; gap: 10px; align-items: center; margin-top: 14px; flex-wrap: wrap; }
        .invoice-editor {
            margin-top: 16px;
            border: 1px solid #e8eef6;
            border-radius: 20px;
            background: #fff;
            overflow: hidden;
        }
        .invoice-editor-head,
        .invoice-editor-row {
            display: grid;
            grid-template-columns: minmax(0, 1.45fr) 78px 130px 130px 42px;
            gap: 8px;
            align-items: center;
        }
        .invoice-editor-head {
            background: #f2f6fb;
            color: #7890aa;
            padding: 10px 12px;
            font-size: 9px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .08em;
        }
        .invoice-editor-body { display: grid; gap: 0; }
        .invoice-editor-row {
            padding: 10px 12px;
            border-top: 1px solid #edf2f8;
        }
        .invoice-editor-input {
            width: 100%;
            border: 1px solid #e7eef7;
            border-radius: 12px;
            background: #f8fbff;
            padding: 10px 11px;
            color: #12395f;
            font-family: inherit;
            font-size: 11px;
            font-weight: 800;
            outline: none;
        }
        .invoice-editor-input:focus { border-color: #b8d2ee; background: #fff; }
        .invoice-editor-subtotal {
            color: #15395d;
            font-size: 11px;
            font-weight: 900;
            text-align: right;
        }
        .btn-icon-soft {
            width: 34px;
            height: 34px;
            border: 1px solid #e7eef7;
            border-radius: 12px;
            background: #fff;
            color: #e65353;
            cursor: pointer;
        }
        .btn-add-component {
            margin-top: 10px;
            border: 1px dashed #b8cbe2;
            background: #f8fbff;
            color: #0b4d87;
            padding: 10px 12px;
            border-radius: 14px;
            font-size: 11px;
            font-weight: 900;
            cursor: pointer;
        }
        .invoice-final-summary {
            margin-top: 12px;
            display: grid;
            gap: 8px;
            border-radius: 18px;
            background: #f7faff;
            padding: 12px;
        }
        .invoice-final-row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            color: #66809d;
            font-size: 11px;
            font-weight: 900;
        }
        .invoice-final-row strong { color: #15395d; }
        .invoice-final-row.total { color: #0d2e56; font-size: 13px; border-top: 1px solid #e6eef8; padding-top: 8px; }
        .invoice-final-note {
            margin-top: 12px;
            border-radius: 16px;
            background: #fff8e4;
            color: #9d6500;
            padding: 10px 12px;
            font-size: 10px;
            font-weight: 900;
            line-height: 1.5;
        }
        .empty-state {
            min-height: 120px;
            border-radius: 28px;
            border: 1px solid var(--line);
            background: #f8fbff;
            display: grid;
            place-items: center;
            text-align: center;
            color: #a7b7ca;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .1em;
            text-transform: uppercase;
        }
        .empty-state i { display: block; margin-bottom: 10px; font-size: 28px; opacity: .5; }

        .report-table-wrap {
            overflow: auto;
            border: 1px solid var(--line);
            border-radius: 24px;
            background: white;
            max-height: 440px;
        }
        table { width: 100%; border-collapse: collapse; min-width: 840px; }
        th, td { padding: 14px 16px; border-bottom: 1px solid #eef3f9; text-align: left; font-size: 12px; }
        th { background: #f8fbff; color: #6f8299; font-size: 10px; text-transform: uppercase; letter-spacing: .08em; }
        td { color: #244766; font-weight: 700; }

        .notice {
            margin-bottom: 20px;
            padding: 14px 16px;
            border-radius: 16px;
            font-size: 13px;
            font-weight: 800;
        }
        .notice.success { color: #0d7c5e; background: #e9fbf5; border: 1px solid #c5f3e4; }
        .notice.error { color: #b42318; background: #fff1f2; border: 1px solid #fecdd3; }
        .toast {
            position: fixed;
            right: 24px;
            bottom: 24px;
            z-index: 1000;
            display: none;
            padding: 14px 18px;
            border-radius: 16px;
            background: var(--primary);
            color: white;
            box-shadow: var(--shadow);
            font-weight: 900;
            font-size: 12px;
        }
        .toast.show { display: block; animation: fade .2s ease; }

        @media (max-width: 980px) {
            .topbar { height: auto; padding: 16px; flex-wrap: wrap; }
            .brand { min-width: 0; }
            .topnav { order: 3; width: 100%; justify-content: flex-start; overflow-x: auto; }
            .hero-card { margin-top: 28px; padding: 28px 20px; }
            .hero-header, .grid-2, .staff-layout, .invoice-grid, .metric-row { grid-template-columns: 1fr; flex-direction: column; }
            .metric-row { display: grid; grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 620px) {
            .shell { width: min(100% - 24px, 1180px); }
            .metric-row { grid-template-columns: 1fr; }
            .action-strip { flex-direction: column; align-items: stretch; }
            .btn-main, .btn-soft { width: 100%; }
            .invoice-editor-head { display: none; }
            .invoice-editor-row { grid-template-columns: 1fr; }
            .invoice-editor-subtotal { text-align: left; }
        }
    </style>
</head>
<body>
    <div class="shell">
        <header class="topbar">
            <div class="brand">
                <div class="brand-logo">
                    <img src="{{ asset('img/E-Kanisius 1.png') }}" alt="Logo SAKTI">
                </div>
                <div>
                    <div class="brand-title">SAKTI PORTAL</div>
                    <div class="brand-sub"><span class="pill-mini">KEPSEK</span><span>UID-001</span></div>
                </div>
            </div>

            <nav class="topnav">
                <button type="button" class="active" onclick="switchTab('terkini')"><i class=""></i>Dashboard</button>
                <button type="button" onclick="scrollToStudentReport()"><i class=""></i>Laporan</button>
                 <button type="button" onclick="switchTab('staf')"><i class=""></i>Atur staf admin</button>
                <button type="button" onclick="switchTab('invoice')"><i class=""></i>Invoice & TTD</button>
            </nav>

            <div class="userbox">
                <div class="user-meta">
                    <div class="user-name">Kepsek JOG-WRO</div>
                    <div class="user-branch">JOG-WRO</div>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
                <button type="button" class="logout" onclick="document.getElementById('logout-form').submit()" title="Logout">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </button>
            </div>
        </header>

        <main class="hero-card">
            <div class="hero-header">
                <div>
                    <h1>Executive Dashboard</h1>
                    <div class="tabs">
                        <span class="eyebrow">JOG-WRO • ANALYTICS</span>
                        <button type="button" class="tab-btn active" data-tab="terkini" onclick="switchTab('terkini')">Terkini</button>
                        <button type="button" class="tab-btn" data-tab="staf" onclick="switchTab('staf')">Staf SPMB</button>
                        <button type="button" class="tab-btn" data-tab="invoice" onclick="switchTab('invoice')">Invoice & TTD</button>
                    </div>
                </div>
                <div class="brain-icon"><i class="fa-solid fa-brain"></i></div>
            </div>

            @if(session('success'))
                <div class="notice success"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="notice error"><i class="fa-solid fa-triangle-exclamation"></i> Periksa kembali input yang belum sesuai.</div>
            @endif

            <section class="tab-panel active" id="tab-terkini">
                <div class="grid-2">
                    <div class="ai-card">
                        <div class="small-label">Prediksi Keterisian (AI Engine)</div>
                        <div class="seat-number">
                            <strong>{{ $metrics['total'] ?? 0 }}</strong>
                            <span>/ {{ $metrics['quota'] ?: 0 }} Kursi</span>
                        </div>
                        <div class="progress-line"><div style="width: {{ $metrics['percentage'] ?? 0 }}%"></div></div>
                        <div class="progress-meta">
                            <span>Progress Terkini</span>
                            <span>{{ $metrics['percentage'] ?? 0 }}% Tercapai</span>
                        </div>
                        <div class="insight-box">
                            <i class="fa-solid fa-lightbulb"></i>
                            Insight Sistem: Berdasarkan data masuk, masih tersedia <b>{{ $metrics['remaining_quota'] ?? 0 }} kursi</b> pada batch aktif. Pantau antrian invoice dan laporan data siswa secara berkala.
                        </div>
                    </div>

                    <div class="chart-card">
                        <div class="panel-title-row">
                            <div class="panel-title">Tren Pendaftaran Harian</div>
                            <i class="fa-solid fa-chart-column" style="color:#d3deeb"></i>
                        </div>
                        <div class="chart-bars">
                            @foreach($chartData as $bar)
                                @php $height = max(8, round(((int) $bar['total'] / $maxChart) * 100)); @endphp
                                <div class="bar-wrap">
                                    <div class="bar-total">{{ $bar['total'] }}</div>
                                    <div class="bar-bg"><div class="bar-fill" style="height: {{ $height }}%"></div></div>
                                    <div class="bar-label">{{ $bar['label'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="metric-row">
                    <div class="metric-card"><div class="label">Total Masuk</div><div class="value">{{ $metrics['total'] }}</div></div>
                    <div class="metric-card"><div class="label">Diterima</div><div class="value">{{ $metrics['approved'] }}</div></div>
                    <div class="metric-card"><div class="label">Proses</div><div class="value">{{ $metrics['pending'] }}</div></div>
                    <div class="metric-card"><div class="label">Invoice Menunggu TTD</div><div class="value">{{ $metrics['pending_invoices'] }}</div></div>
                </div>

                <div class="action-strip">
                    <div>
                        <strong>Cetak laporan masuk data siswa</strong>
                        <span>Berisi nomor registrasi, identitas siswa, orang tua, batch, status pendaftaran, dan status invoice.</span>
                    </div>
                    <a class="btn-main" href="{{ route('kepsek.laporan.siswa') }}"><i class="fa-solid fa-print"></i> Cetak Laporan</a>
                </div>

                <div class="white-panel" id="student-report-preview" style="margin-top:24px; padding:0; overflow:hidden;">
                    <div style="padding:22px 24px; display:flex; justify-content:space-between; align-items:center; gap:14px;">
                        <div>
                            <div class="panel-title">Data Siswa Masuk Terbaru</div>
                            <div style="font-size:11px;color:var(--muted);font-weight:800;margin-top:5px;">Ringkasan cepat untuk kepala sekolah</div>
                        </div>
                        <a class="btn-soft" href="{{ route('kepsek.laporan.siswa') }}"><i class="fa-solid fa-file-lines"></i> Buka Laporan</a>
                    </div>
                    <div class="report-table-wrap" style="border-radius:0;border-left:0;border-right:0;border-bottom:0;max-height:320px;">
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Registrasi</th>
                                    <th>Nama Siswa</th>
                                    <th>Orang Tua</th>
                                    <th>Batch</th>
                                    <th>Status</th>
                                    <th>Invoice</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($studentReportRows->take(8) as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $row->no_pendaftaran ?? '-' }}</td>
                                        <td>{{ $row->nama_siswa ?? '-' }}</td>
                                        <td>{{ $row->nama_ortu ?? '-' }}</td>
                                        <td>{{ $row->nama_batch ?? '-' }}</td>
                                        <td>{{ strtoupper($row->status_pendaftaran ?? 'pending') }}</td>
                                        <td>{{ $row->nomor_tagihan ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7" style="text-align:center;color:#9aacbf;">Belum ada data siswa masuk.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section class="tab-panel" id="tab-staf">
                <div class="staff-layout">
                    <div>
                        <div class="staff-head">
                            <div>
                                <div class="panel-title">Daftar Admin SPMB Cabang</div>
                                <div style="font-size:11px;color:var(--muted);font-weight:800;margin-top:6px;">Akun admin yang dapat mengelola pendaftaran dan verifikasi berkas.</div>
                            </div>
                            <span class="active-pill">{{ $staffList->count() }} Staf Aktif</span>
                        </div>
                        <div class="staff-list">
                            @forelse($staffList as $staff)
                                <div class="staff-card">
                                    <div class="avatar">{{ $staff->initial }}</div>
                                    <div>
                                        <div class="staff-name">{{ $staff->nama_staf }}</div>
                                        <div class="staff-email">{{ $staff->email }}</div>
                                    </div>
                                </div>
                            @empty
                                <div class="empty-state"><div><i class="fa-regular fa-user"></i>Belum ada staf admin.</div></div>
                            @endforelse
                        </div>
                    </div>

                    <form class="form-card" action="{{ route('kepsek.staf.store') }}" method="POST">
                        @csrf
                        <div class="form-title">Otentikasi Staf Baru</div>
                        <div class="form-sub">Registrasi akses keamanan</div>

                        <div class="field">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama staf...">
                            @error('nama')<small>{{ $message }}</small>@enderror
                        </div>
                        <div class="field">
                            <label>Email Akses</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="admin.unit@spmb.local">
                            @error('email')<small>{{ $message }}</small>@enderror
                        </div>
                        <div class="field">
                            <label>Password Default</label>
                            <input type="text" name="password" value="{{ old('password', 'Admin12345') }}" placeholder="Password default">
                            @error('password')<small>{{ $message }}</small>@enderror
                        </div>

                        <button class="btn-main" type="submit" style="width:100%; margin-top:4px;"><i class="fa-solid fa-bolt"></i> Terbitkan Akses</button>
                    </form>
                </div>
            </section>

            <section class="tab-panel" id="tab-invoice">
                <div class="invoice-grid">
                    <div class="invoice-column">
                        <h3><span class="ico-orange"><i class="fa-regular fa-clock"></i></span> Antrian Persetujuan</h3>
                        <p>Menunggu tanda tangan Anda</p>
                        <div class="invoice-filter-card">
                            <label>Pilih siswa approved dari Admin</label>
                            <input type="text" id="invoiceSearchInput" class="invoice-filter-input" placeholder="Cari nama siswa, no invoice, no registrasi, atau NIK..." oninput="filterPendingInvoices(this.value)">
                            <div class="invoice-selection-hint">Invoice tidak dibuka semua. Pilih salah satu nama siswa untuk membuka editor invoice final.</div>
                        </div>
                        <div class="invoice-list" id="pendingInvoiceList">
                            @forelse($pendingInvoices as $invoice)
                                @php
                                    $komponenKepsek = collect($invoice->komponen_tagihan ?? []);
                                    if ($komponenKepsek->isEmpty()) {
                                        $komponenKepsek = collect([
                                            (object) ['nama_komponen' => 'Biaya Formulir & Administrasi Pendaftaran', 'qty' => 1, 'nominal' => 250000, 'subtotal' => 250000],
                                            (object) ['nama_komponen' => 'Uang Pangkal / Uang Gedung', 'qty' => 1, 'nominal' => 2500000, 'subtotal' => 2500000],
                                        ]);
                                    }
                                @endphp
                                <div class="invoice-card invoice-approval-card" id="invoice-card-{{ $invoice->uid }}" data-invoice-card="{{ $invoice->uid }}" data-invoice-search="{{ strtolower(($invoice->nama_siswa ?? '') . ' ' . ($invoice->nama_ortu ?? '') . ' ' . ($invoice->nomor_tagihan ?? '') . ' ' . ($invoice->no_pendaftaran ?? '') . ' ' . ($invoice->nik ?? '')) }}" onclick="openInvoiceEditor({{ $invoice->uid }})">
                                    <div class="invoice-top">
                                        <div>
                                            <div class="invoice-no">{{ $invoice->nomor_tagihan ?? '-' }}</div>
                                            <div class="invoice-name">{{ $invoice->nama_siswa ?? '-' }} • {{ $invoice->nama_ortu ?? '-' }}</div>
                                        </div>
                                        <span class="status-pill pending">Menunggu Final</span>
                                    </div>
                                    <div class="invoice-select-chip"><i class="fa-solid fa-pen-to-square"></i> Klik nama siswa ini untuk edit invoice final</div>

                                    <div class="invoice-details" onclick="event.stopPropagation()">
                                    <div class="invoice-final-note">
                                        Data ini berasal dari input admin SPMB. Kepala sekolah dapat koreksi nominal/komponen terlebih dahulu, lalu klik <b>Submit Final & TTD</b>. Setelah final, admin tidak bisa edit lagi dan invoice orang tua otomatis memakai versi terbaru ini.
                                    </div>

                                    <div class="invoice-editor">
                                        <div class="invoice-editor-head">
                                            <span>Komponen</span>
                                            <span>Qty</span>
                                            <span>Nominal</span>
                                            <span>Subtotal</span>
                                            <span></span>
                                        </div>
                                        <div class="invoice-editor-body" id="invoice-items-{{ $invoice->uid }}">
                                            @foreach($komponenKepsek as $item)
                                                @php
                                                    $qty = (float) ($item->qty ?? 1);
                                                    $nominal = (float) ($item->nominal ?? 0);
                                                    $subtotal = (float) ($item->subtotal ?? ($qty * $nominal));
                                                @endphp
                                                <div class="invoice-editor-row" data-invoice-row>
                                                    <input type="text" class="invoice-editor-input js-item-name" value="{{ $item->nama_komponen ?? '-' }}" oninput="recalculateInvoice({{ $invoice->uid }})">
                                                    <input type="number" min="1" step="1" class="invoice-editor-input js-item-qty" value="{{ $qty }}" oninput="recalculateInvoice({{ $invoice->uid }})">
                                                    <input type="number" min="0" step="1000" class="invoice-editor-input js-item-nominal" value="{{ $nominal }}" oninput="recalculateInvoice({{ $invoice->uid }})">
                                                    <div class="invoice-editor-subtotal js-row-subtotal">{{ $fmtMoney($subtotal) }}</div>
                                                    <button type="button" class="btn-icon-soft" onclick="removeInvoiceRow(this, {{ $invoice->uid }})" title="Hapus komponen"><i class="fa-solid fa-trash"></i></button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <button type="button" class="btn-add-component" onclick="addInvoiceRow({{ $invoice->uid }})">
                                        <i class="fa-solid fa-plus"></i> Tambah Komponen
                                    </button>

                                    <div class="field" style="margin-top:14px;margin-bottom:0;">
                                        <label>Diskon / Koreksi Kepsek (Rp)</label>
                                        <input type="number" min="0" step="1000" id="diskon-{{ $invoice->uid }}" value="{{ $invoice->diskon_tagihan ?? 0 }}" oninput="recalculateInvoice({{ $invoice->uid }})">
                                    </div>

                                    <div class="invoice-final-summary">
                                        <div class="invoice-final-row"><span>Subtotal</span><strong id="subtotal-{{ $invoice->uid }}">{{ $fmtMoney($invoice->subtotal_tagihan ?? $invoice->total_tagihan ?? 0) }}</strong></div>
                                        <div class="invoice-final-row"><span>Diskon</span><strong id="diskon-text-{{ $invoice->uid }}">{{ $fmtMoney($invoice->diskon_tagihan ?? 0) }}</strong></div>
                                        <div class="invoice-final-row total"><span>Total Final</span><strong id="total-{{ $invoice->uid }}">{{ $fmtMoney($invoice->total_tagihan ?? 0) }}</strong></div>
                                    </div>

                                    <div class="field" style="margin-top:14px;margin-bottom:0;">
                                        <label>Catatan Kepsek</label>
                                        <textarea rows="2" id="catatan-{{ $invoice->uid }}" placeholder="Opsional, contoh: disetujui untuk diterbitkan.">{{ $invoice->catatan_kepsek ?? '' }}</textarea>
                                    </div>
                                    <div class="invoice-actions">
                                        <button type="button" class="btn-main" data-url="{{ route('kepsek.invoice.approve', $invoice->uid) }}" onclick="approveInvoice(this, {{ $invoice->uid }})">
                                            <i class="fa-solid fa-signature"></i> Submit Final & TTD
                                        </button>
                                    </div>
                                    </div>
                                </div>
                            @empty
                                <div class="empty-state"><div><i class="fa-regular fa-circle-check"></i>Semua invoice sudah diproses</div></div>
                            @endforelse
                        </div>
                    </div>

                    <div class="invoice-column">
                        <h3><span class="ico-green"><i class="fa-solid fa-download"></i></span> Invoice Terbit</h3>
                        <p>Sudah dapat diunduh orang tua</p>
                        <div class="invoice-list" id="issuedInvoiceList">
                            @forelse($issuedInvoices as $invoice)
                                <div class="invoice-card">
                                    <div class="invoice-top">
                                        <div>
                                            <div class="invoice-no">{{ $invoice->nomor_tagihan ?? '-' }}</div>
                                            <div class="invoice-name">{{ $invoice->nama_siswa ?? '-' }} • {{ $invoice->nama_ortu ?? '-' }}</div>
                                        </div>
                                        <span class="status-pill valid">Terbit</span>
                                    </div>
                                    <div class="invoice-amount">{{ $fmtMoney($invoice->total_tagihan ?? 0) }}</div>
                                    <div style="margin-top:10px;color:#91a3b8;font-size:11px;font-weight:800;">
                                        TTD: {{ $invoice->disetujui_oleh ?? 'Kepala Sekolah' }} • {{ $fmtDate($invoice->tanggal_tagihan ?? null) }}
                                    </div>
                                </div>
                            @empty
                                <div class="empty-state"><div><i class="fa-regular fa-file-lines"></i>Belum ada invoice terbit</div></div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <div class="toast" id="toast">Berhasil</div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function switchTab(tab) {
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.toggle('active', btn.dataset.tab === tab));
            document.querySelectorAll('.tab-panel').forEach(panel => panel.classList.toggle('active', panel.id === `tab-${tab}`));
        }

        function showToast(message) {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 2600);
        }

        function scrollToStudentReport() {
            switchTab('terkini');
            const reportPreview = document.getElementById('student-report-preview');
            if (reportPreview) {
                reportPreview.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        function openInvoiceEditor(uid) {
            document.querySelectorAll('[data-invoice-card]').forEach(card => {
                const isSelected = card.dataset.invoiceCard === String(uid);
                card.classList.toggle('selected', isSelected);
            });

            const selectedCard = document.getElementById(`invoice-card-${uid}`);
            if (selectedCard) {
                recalculateInvoice(uid);
                selectedCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }

        function filterPendingInvoices(keyword) {
            const normalizedKeyword = (keyword || '').toLowerCase().trim();
            let visibleCount = 0;

            document.querySelectorAll('[data-invoice-card]').forEach(card => {
                const haystack = (card.dataset.invoiceSearch || '').toLowerCase();
                const isVisible = normalizedKeyword === '' || haystack.includes(normalizedKeyword);
                card.classList.toggle('invoice-hidden-by-filter', !isVisible);
                if (isVisible) visibleCount += 1;
            });

            return visibleCount;
        }

        function formatRupiah(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(Number(value || 0));
        }

        function createInvoiceRow(uid) {
            const row = document.createElement('div');
            row.className = 'invoice-editor-row';
            row.setAttribute('data-invoice-row', '');
            row.innerHTML = `
                <input type="text" class="invoice-editor-input js-item-name" value="Komponen biaya baru" oninput="recalculateInvoice(${uid})">
                <input type="number" min="1" step="1" class="invoice-editor-input js-item-qty" value="1" oninput="recalculateInvoice(${uid})">
                <input type="number" min="0" step="1000" class="invoice-editor-input js-item-nominal" value="0" oninput="recalculateInvoice(${uid})">
                <div class="invoice-editor-subtotal js-row-subtotal">${formatRupiah(0)}</div>
                <button type="button" class="btn-icon-soft" onclick="removeInvoiceRow(this, ${uid})" title="Hapus komponen"><i class="fa-solid fa-trash"></i></button>
            `;
            return row;
        }

        function addInvoiceRow(uid) {
            const body = document.getElementById(`invoice-items-${uid}`);
            if (!body) return;
            body.appendChild(createInvoiceRow(uid));
            recalculateInvoice(uid);
        }

        function removeInvoiceRow(button, uid) {
            const body = document.getElementById(`invoice-items-${uid}`);
            const rows = body ? body.querySelectorAll('[data-invoice-row]') : [];
            if (rows.length <= 1) {
                showToast('Minimal harus ada satu komponen invoice.');
                return;
            }
            button.closest('[data-invoice-row]')?.remove();
            recalculateInvoice(uid);
        }

        function collectInvoiceItems(uid) {
            const rows = document.querySelectorAll(`#invoice-items-${uid} [data-invoice-row]`);
            const items = [];

            rows.forEach(row => {
                const nama = row.querySelector('.js-item-name')?.value.trim() || '';
                const qty = parseFloat(row.querySelector('.js-item-qty')?.value || '0') || 0;
                const nominal = parseFloat(row.querySelector('.js-item-nominal')?.value || '0') || 0;
                const subtotal = qty * nominal;

                const subtotalEl = row.querySelector('.js-row-subtotal');
                if (subtotalEl) subtotalEl.textContent = formatRupiah(subtotal);

                if (nama !== '') {
                    items.push({ nama_komponen: nama, qty, nominal });
                }
            });

            return items;
        }

        function recalculateInvoice(uid) {
            const items = collectInvoiceItems(uid);
            const subtotal = items.reduce((sum, item) => sum + ((Number(item.qty) || 0) * (Number(item.nominal) || 0)), 0);
            const diskon = parseFloat(document.getElementById(`diskon-${uid}`)?.value || '0') || 0;
            const total = Math.max(0, subtotal - diskon);

            const subtotalText = document.getElementById(`subtotal-${uid}`);
            const diskonText = document.getElementById(`diskon-text-${uid}`);
            const totalText = document.getElementById(`total-${uid}`);

            if (subtotalText) subtotalText.textContent = formatRupiah(subtotal);
            if (diskonText) diskonText.textContent = formatRupiah(diskon);
            if (totalText) totalText.textContent = formatRupiah(total);

            return { items, diskon, subtotal, total };
        }

        async function approveInvoice(button, uid) {
            const catatan = document.getElementById(`catatan-${uid}`)?.value || '';
            const invoiceData = recalculateInvoice(uid);

            if (!invoiceData.items.length) {
                showToast('Minimal harus ada satu komponen invoice.');
                return;
            }

            button.disabled = true;
            button.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memfinalkan...';

            try {
                const response = await fetch(button.dataset.url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        catatan_kepsek: catatan,
                        diskon: invoiceData.diskon,
                        items: invoiceData.items
                    })
                });

                const result = await response.json();
                if (!response.ok || !result.success) throw new Error(result.message || 'Gagal menyetujui invoice.');

                const card = document.getElementById(`invoice-card-${uid}`);
                if (card) card.remove();
                showToast(result.message || 'Invoice final berhasil disetujui.');

                setTimeout(() => window.location.href = '{{ route('kepsek.dashboard', ['tab' => 'invoice']) }}', 900);
            } catch (error) {
                showToast(error.message);
                button.disabled = false;
                button.innerHTML = '<i class="fa-solid fa-signature"></i> Submit Final & TTD';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const params = new URLSearchParams(window.location.search);
            const tab = params.get('tab');
            if (['terkini', 'staf', 'invoice'].includes(tab)) switchTab(tab);

            document.querySelectorAll('[data-invoice-card]').forEach(card => {
                recalculateInvoice(card.dataset.invoiceCard);
            });
        });
    </script>
</body>
</html>
