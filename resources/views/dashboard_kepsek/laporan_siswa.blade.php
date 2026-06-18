@php
    $fmtMoney = fn($value) => 'Rp ' . number_format((float) ($value ?? 0), 0, ',', '.');
    $fmtDate = function ($value) {
        if (!$value) return '-';
        try { return \Carbon\Carbon::parse($value)->format('d/m/Y'); } catch (\Throwable $e) { return $value; }
    };
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Siswa Masuk - SAKTI Portal</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 10mm;
        }

        * { box-sizing: border-box; }

        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #102a43;
            margin: 0;
            background: #eef3f8;
        }

        .print-actions {
            width: min(1120px, calc(100% - 32px));
            margin: 18px auto 0;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .print-actions button,
        .print-actions a {
            border: none;
            border-radius: 10px;
            padding: 11px 16px;
            background: #053b70;
            color: white;
            font-weight: 800;
            cursor: pointer;
            text-decoration: none;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .print-actions a { background: #5f738b; }

        .page {
            width: min(1120px, calc(100% - 32px));
            margin: 14px auto 26px;
            background: #fff;
            padding: 24px 26px 28px;
            border-radius: 18px;
            box-shadow: 0 20px 40px rgba(15, 42, 68, .10);
        }

        .header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
            border-bottom: 3px solid #053b70;
            padding-bottom: 16px;
            margin-bottom: 16px;
        }

        .brand {
            display: flex;
            gap: 14px;
            align-items: center;
            min-width: 0;
        }

        .logo {
            width: 156px;
            height: 54px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            flex: 0 0 156px;
        }

        .logo img {
            max-width: 100%;
            max-height: 54px;
            object-fit: contain;
            display: block;
        }

        h1 {
            margin: 0;
            color: #053b70;
            font-size: 23px;
            line-height: 1.15;
            letter-spacing: -.03em;
        }

        .subtitle {
            margin-top: 5px;
            color: #5f738b;
            font-size: 11.5px;
            font-weight: 700;
            line-height: 1.45;
        }

        .meta {
            text-align: right;
            font-size: 11.5px;
            line-height: 1.65;
            color: #52677f;
            flex: 0 0 285px;
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
            margin-bottom: 16px;
        }

        .summary-card {
            border: 1px solid #dbe6f1;
            border-radius: 12px;
            padding: 10px 12px;
            background: #f8fbff;
        }

        .summary-card span {
            display: block;
            color: #6c7f95;
            font-size: 9.5px;
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: .06em;
        }

        .summary-card strong {
            display: block;
            margin-top: 4px;
            color: #053b70;
            font-size: 20px;
            line-height: 1;
        }

        .table-wrap {
            width: 100%;
            overflow: visible;
        }

        table.report-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .report-table th,
        .report-table td {
            border: 1px solid #dbe6f1;
            padding: 8px 8px;
            vertical-align: top;
            font-size: 10px;
            line-height: 1.35;
            overflow-wrap: break-word;
            word-break: normal;
            hyphens: auto;
        }

        .report-table th {
            background: #053b70;
            color: white;
            text-transform: uppercase;
            letter-spacing: .035em;
            font-size: 8.6px;
            line-height: 1.25;
        }

        .report-table tr:nth-child(even) td { background: #f8fbff; }

        .center { text-align: center; }
        .status { font-weight: 900; text-transform: uppercase; color: #053b70; }
        .money { font-weight: 800; white-space: nowrap; }
        .cell-main { font-weight: 800; color: #092f59; }
        .cell-sub { margin-top: 3px; color: #52677f; font-size: 9.2px; line-height: 1.35; }
        .address { margin-top: 5px; color: #102a43; font-size: 9.4px; line-height: 1.38; }
        .label { font-weight: 800; color: #5f738b; }
        .code { overflow-wrap: anywhere; word-break: break-word; }
        small { color: #6d8097; font-size: 8.8px; }

        .footer {
            margin-top: 26px;
            display: flex;
            justify-content: flex-end;
            gap: 42px;
            font-size: 12px;
        }

        .signature {
            width: 240px;
            text-align: center;
        }

        .signature .space { height: 58px; }

        @media print {
            body {
                background: white;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .print-actions { display: none; }

            .page {
                width: 100%;
                max-width: none;
                margin: 0;
                padding: 0;
                border-radius: 0;
                box-shadow: none;
            }

            .header { margin-bottom: 14px; }
            .summary { margin-bottom: 14px; }
            .report-table th,
            .report-table td { padding: 6px 6px; font-size: 9.4px; }
            .report-table th { font-size: 8px; }
            .cell-sub { font-size: 8.6px; }
            .address { font-size: 8.8px; }
        }
    </style>
</head>
<body>
    <div class="print-actions">
        <a href="{{ route('kepsek.dashboard') }}">Kembali</a>
        <button type="button" onclick="window.print()">Cetak / Simpan PDF</button>
    </div>

    <main class="page">
        <section class="header">
            <div class="brand">
                <div class="logo">
                    <img src="{{ asset('img/E-Kanisius 1.png') }}" alt="Logo Kanisius">
                </div>
                <div>
                    <h1>Laporan Data Siswa Masuk</h1>
                    <div class="subtitle">SAKTI Portal • Cabang JOG-WRO • Sistem Penerimaan Murid Baru</div>
                </div>
            </div>
            <div class="meta">
                <div><strong>Tanggal Cetak:</strong> {{ now()->format('d/m/Y H:i') }}</div>
                <div><strong>Dicetak Oleh:</strong> {{ session('email') ?? 'Kepala Sekolah' }}</div>
                <div><strong>Role:</strong> Kepala Sekolah</div>
            </div>
        </section>

        <section class="summary">
            <div class="summary-card"><span>Total Masuk</span><strong>{{ $metrics['total'] ?? 0 }}</strong></div>
            <div class="summary-card"><span>Diterima</span><strong>{{ $metrics['approved'] ?? 0 }}</strong></div>
            <div class="summary-card"><span>Ditolak</span><strong>{{ $metrics['rejected'] ?? 0 }}</strong></div>
            <div class="summary-card"><span>Proses</span><strong>{{ $metrics['pending'] ?? 0 }}</strong></div>
            <div class="summary-card"><span>Sisa Kuota</span><strong>{{ $metrics['remaining_quota'] ?? 0 }}</strong></div>
        </section>

        <div class="table-wrap">
            <table class="report-table">
                <colgroup>
                    <col style="width:4%;">
                    <col style="width:13%;">
                    <col style="width:18%;">
                    <col style="width:24%;">
                    <col style="width:12%;">
                    <col style="width:8%;">
                    <col style="width:12%;">
                    <col style="width:9%;">
                </colgroup>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Registrasi</th>
                        <th>Identitas Siswa</th>
                        <th>Orang Tua & Alamat</th>
                        <th>Batch</th>
                        <th>Status</th>
                        <th>Invoice</th>
                        <th>Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rows as $row)
                        <tr>
                            <td class="center">{{ $loop->iteration }}</td>
                            <td><span class="code">{{ $row->no_pendaftaran ?? '-' }}</span></td>
                            <td>
                                <div class="cell-main">{{ $row->nama_siswa ?? '-' }}</div>
                                <div class="cell-sub"><span class="label">NIK:</span> <span class="code">{{ $row->nik ?? '-' }}</span></div>
                                <div class="cell-sub"><span class="label">TTL:</span> {{ trim(($row->tempat_lahir ?? '-') . ' / ' . $fmtDate($row->tanggal_lahir ?? null), ' /') }}</div>
                            </td>
                            <td>
                                <div class="cell-main">{{ $row->nama_ortu ?? '-' }}</div>
                                <div class="cell-sub"><span class="label">No. Telp:</span> {{ $row->no_telp ?? '-' }}</div>
                                <div class="address"><span class="label">Alamat:</span> {{ $row->alamat ?? '-' }}</div>
                            </td>
                            <td>{{ $row->nama_batch ?? '-' }}</td>
                            <td class="status">{{ $row->status_pendaftaran ?? 'pending' }}</td>
                            <td>
                                <span class="code">{{ $row->nomor_tagihan ?? '-' }}</span>
                                <br><small>{{ $row->status_tagihan ?? '-' }}</small>
                            </td>
                            <td class="money">{{ $fmtMoney($row->total_tagihan ?? 0) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center;padding:24px;">Belum ada data siswa masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <section class="footer">
            <div class="signature">
                <div>Mengetahui,</div>
                <strong>Kepala Sekolah</strong>
                <div class="space"></div>
                <strong>________________________</strong>
            </div>
        </section>
    </main>
</body>
</html>
