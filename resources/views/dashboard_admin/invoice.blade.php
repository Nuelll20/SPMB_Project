<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAKTI PORTAL - Admin - Invoice Management</title>
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
            --green-bg: #dcfce7;
            --red: #dc2626;
            --orange: #f59e0b;
            --orange-bg: #fef3c7;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 24px 0 48px 0;
        }
        .container { max-width: 1100px; width: 100%; margin: 0 auto; padding: 0 16px; display: flex; flex-direction: column; gap: 40px; }   

        /* ==================== 1. PANEL WORKSPACE EDIT ADMIN ==================== */
        .admin-panel-card {
            background: var(--surface);
            border-radius: 22px;
            border: 1px solid var(--border);
            padding: 36px;
            box-shadow: 0 10px 30px rgba(26, 42, 108, 0.05);
            display: flex;
            flex-direction: column;
            gap: 24px;
        }
        .panel-title { font-size: 18px; font-weight: 900; color: var(--navy); display: flex; align-items: center; gap: 10px; border-bottom: 2px solid var(--border); padding-bottom: 12px; }
        .badge-admin { background: #fee2e2; color: var(--red); font-size: 10px; font-weight: 800; padding: 3px 10px; border-radius: 99px; text-transform: uppercase; }

        .meta-input-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group label { font-size: 11px; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px; }
        .admin-input { width: 100%; background: var(--surface2); border: 1px solid var(--border); padding: 12px 16px; font-family: inherit; font-size: 13.5px; font-weight: 600; color: var(--text); border-radius: 10px; outline: none; transition: all 0.2s; }
        .admin-input:focus { border-color: var(--blue); background: var(--surface); box-shadow: 0 0 0 3px rgba(0,74,173,0.08); }

        /* Tabel Editor Admin */
        .edit-table { width: 100%; border-collapse: collapse; }
        .edit-table th { font-size: 11px; font-weight: 800; text-transform: uppercase; color: var(--muted); padding: 10px 12px; text-align: left; border-bottom: 2px solid var(--border); }
        .edit-table td { padding: 10px 6px; border-bottom: 1px solid var(--border); }
        
        .btn-add-row-action { background: var(--surface2); border: 1.5px dashed var(--blue); color: var(--blue); padding: 12px; border-radius: 12px; font-size: 13px; font-weight: 800; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; width: 100%; transition: all 0.2s; margin-top: -8px; }
        .btn-add-row-action:hover { background: rgba(0, 74, 173, 0.05); border-style: solid; }
        .btn-delete-row-action { background: none; border: none; color: var(--muted); cursor: pointer; font-size: 14px; padding: 8px; transition: color 0.2s; }
        .btn-delete-row-action:hover { color: var(--red); }

        .admin-summary-area { display: flex; justify-content: space-between; gap: 20px; align-items: center; background: var(--surface2); padding: 16px 24px; border-radius: 14px; border: 1px solid var(--border); }
        
        .admin-actions-right { display: flex; align-items: center; gap: 12px; }
        .btn-action-back { background: var(--surface); border: 1.5px solid var(--border); color: var(--text); padding: 14px 28px; border-radius: 50px; font-weight: 700; font-size: 13.5px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s ease; cursor: pointer; }
        .btn-action-back:hover { border-color: var(--navy); color: var(--navy); background: rgba(26, 42, 108, 0.02); }

        .btn-action-save { background: var(--navy); color: white; border: none; padding: 14px 32px; border-radius: 50px; font-weight: 800; font-size: 13.5px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 14px rgba(26, 42, 108, 0.2); }
        .btn-action-save:hover { background: #111c50; }

        /* Divider Penanda Preview */
        .preview-title-divider { font-size: 13px; font-weight: 900; color: var(--muted); text-transform: uppercase; letter-spacing: 2px; text-align: center; display: flex; align-items: center; justify-content: center; gap: 16px; margin: 10px 0 -10px 0; }
        .preview-title-divider::before, .preview-title-divider::after { content: ''; flex: 1; height: 1px; background: var(--border); }

        /* ==================== 2. LIVE PREVIEW AREA DOKUMEN CETAK OVENTIK ==================== */
        .print-document-wrapper { max-width: 800px; width: 100%; margin: 0 auto; display: flex; flex-direction: column; gap: 32px; }
        
        .page { background: var(--surface); padding: 60px; position: relative; overflow: hidden; box-shadow: 0 4px 30px rgba(0,0,0,0.03); border-radius: 12px; border: 1px solid var(--border); min-height: 1050px; }
        .page-break { page-break-after: always; break-after: page; }
        
        /* Watermark System */
        .watermark { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-35deg); font-size: 90px; font-weight: 900; color: rgba(26, 42, 108, 0.03); pointer-events: none; white-space: nowrap; user-select: none; z-index: 1; letter-spacing: 8px; }

        /* Authentic Header */
        .authentic-header { display: flex; align-items: center; justify-content: space-between; border-bottom: 3px solid var(--navy); padding-bottom: 16px; margin-bottom: 32px; position: relative; z-index: 2; }
        .header-left { display: flex; align-items: center; gap: 16px; }
        .header-logo-box { width: 54px; height: 54px; background: var(--navy); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #ffffff; font-size: 24px; }
        .header-title-block h2 { font-size: 19px; font-weight: 900; color: var(--navy); letter-spacing: -0.5px; }
        .header-title-block p { font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: 1px; margin-top: 2px; }
        .header-right-meta { text-align: right; font-family: 'DM Mono', monospace; font-size: 11px; color: var(--muted); line-height: 1.5; }
        .header-right-meta strong { color: var(--navy); }

        /* Layout Konten Dokumen */
        .content-block { position: relative; z-index: 2; display: flex; flex-direction: column; gap: 24px; }
        .invoice-title-row { display: flex; justify-content: space-between; align-items: center; }
        .invoice-title-row h1 { font-size: 24px; font-weight: 900; color: var(--navy); letter-spacing: 0.5px; }
        
        .bill-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; background: var(--surface2); padding: 16px 20px; border-radius: 10px; border: 1px solid var(--border); }
        .bill-node h4 { font-size: 10px; font-weight: 800; color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
        .bill-node p { font-size: 14px; font-weight: 700; color: var(--navy); }

        .invoice-table { width: 100%; border-collapse: collapse; margin: 8px 0; }
        .invoice-table th { font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--muted); padding: 10px 12px; border-bottom: 2px solid var(--border); text-align: left; }
        .invoice-table td { padding: 14px 12px; font-size: 13.5px; font-weight: 600; color: var(--text); border-bottom: 1px solid var(--border); }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .summary-wrapper { display: flex; justify-content: flex-end; }
        .summary-table { width: 280px; font-size: 13.5px; font-weight: 600; color: var(--text); }
        .summary-table td { padding: 6px 0; }
        .summary-table tr.grand-total { font-size: 16px; font-weight: 900; color: var(--navy); border-top: 1px solid var(--border); }
        .summary-table tr.grand-total td { padding-top: 10px; }

        /* Badge Status Dokumen Dinamis */
        .status-badge-document { padding: 14px; border-radius: 10px; font-size: 13px; font-weight: 800; display: flex; align-items: center; gap: 8px; transition: all 0.2s; }
        .status-badge-document.pending-mode { background: var(--orange-bg); color: var(--orange); border: 1px solid rgba(245,158,11,0.15); }
        .status-badge-document.valid-mode { background: var(--green-bg); color: var(--green); border: 1px solid rgba(22,163,74,0.15); }

        /* Lembar 2 Catatan & Instruksi */
        .note-section h3 { font-size: 16px; font-weight: 800; color: var(--navy); margin-bottom: 12px; display: flex; align-items: center; gap: 8px; }
        .va-box { background: var(--surface2); border-left: 4px solid var(--blue); padding: 16px 20px; border-radius: 0 10px 10px 0; margin-bottom: 24px; border-top: 1px solid var(--border); border-right: 1px solid var(--border); border-bottom: 1px solid var(--border); }
        .va-number { font-family: 'DM Mono', monospace; font-size: 20px; font-weight: 700; color: var(--blue); margin-top: 4px; letter-spacing: 1px; }
        .step-list { display: flex; flex-direction: column; gap: 14px; padding-left: 20px; font-size: 13.5px; line-height: 1.6; font-weight: 500; color: #475569; }
        
        /* ==================== POP-UP MODAL OVERLAY BRIDGING SYSTEM ==================== */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(26, 42, 108, 0.4); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; z-index: 10000; opacity: 0; pointer-events: none; transition: opacity 0.3s ease; }
        .modal-overlay.show { opacity: 1; pointer-events: auto; }
        .modal-box { background: var(--surface); padding: 36px 32px; border-radius: 24px; max-width: 440px; width: 90%; text-align: center; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15); border: 1px solid var(--border); transform: scale(0.9); transition: transform 0.3s ease; }
        .modal-overlay.show .modal-box { transform: scale(1); }
        .modal-icon { width: 58px; height: 56px; background: #fff5f5; color: var(--red); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 20px auto; }
        .modal-title { font-size: 19px; font-weight: 800; color: var(--navy); margin-bottom: 10px; letter-spacing: -0.3px; }
        .modal-desc { font-size: 13.5px; color: var(--muted); line-height: 1.6; margin-bottom: 28px; font-weight: 500; }

        /* REVISI: Master UI Tombol Pop-up Konfirmasi Keluar Workspace */
        .modal-btn-group { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .modal-btn { padding: 13px 24px; border-radius: 12px; font-size: 14px; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; cursor: pointer; border: none; transition: all 0.2s ease; }
        
        .modal-btn-cancel { background: var(--surface2); color: var(--navy); border: 1px solid var(--border); }
        .modal-btn-cancel:hover { background: #e2e8f0; border-color: #cbd5e1; }
        
        .modal-btn-confirm { background: var(--red); color: #ffffff; box-shadow: 0 4px 14px rgba(220, 38, 38, 0.25); }
        .modal-btn-confirm:hover { background: #bd1c1c; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(220, 38, 38, 0.35); }

        /* Toast System */
        #toast { position: fixed; bottom: 30px; right: 30px; background: var(--navy); color: white; padding: 14px 28px; border-radius: 12px; font-size: 13.5px; font-weight: 600; opacity: 0; pointer-events: none; transform: translateX(30px); transition: transform 0.4s cubic-bezier(0.22, 1, 0.36, 1), opacity 0.4s; z-index: 9999; box-shadow: 0 10px 25px -5px rgba(26, 42, 108, 0.3); display: flex; align-items: center; gap: 10px; }
        #toast.show { opacity: 1; transform: translateX(0); }

        /* ==================== SCREEN PRINT MEDIA SETUP ==================== */
        @media print {
            body { background: white; padding: 0; color: black; }
            .admin-panel-card, .preview-title-divider, #toast, .modal-overlay { display: none !important; }
            .print-document-wrapper { max-width: 100%; margin: 0; }
            .page { box-shadow: none; border: none; padding: 0; min-height: auto; }
            * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; } 
        }
    </style>
</head>

<body>

    <div class="container">
        
        <div class="admin-panel-card">
            <div class="panel-title">
                <i class="fa-solid fa-sliders"></i> Manajemen Invoice & Kuitansi Pembayaran
                <span class="badge-admin">Workspace Kerja</span>
            </div>

            <div class="meta-input-grid">
                <div class="form-group">
                    <label>Nama Calon Siswa</label>
                    <input type="text" id="inNamaSiswa" class="admin-input" value="Budi Santoso" oninput="executeMirroringLoop()" disabled>
                </div>
                <div class="form-group">
                    <label>Nomor Registrasi / No. Nota</label>
                    <input type="text" id="inNoReg" class="admin-input" value="REG-17811967-DYNAMIC" oninput="executeMirroringLoop()" disabled>
                </div>
                <div class="form-group">
                    <label>Nama Orang Tua / Wali</label>
                    <input type="text" id="inNamaWali" class="admin-input" value="Ortu Demo Account" oninput="executeMirroringLoop()" disabled>
                </div>
            </div>

            <table class="edit-table">
                <thead>
                    <tr>
                        <th>Deskripsi Komponen Komitmen Biaya Sekolah</th>
                        <th style="width: 90px; text-align: center;">Qty</th>
                        <th style="width: 180px; text-align: right;">Harga Satuan (Rp)</th>
                        <th style="width: 60px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="adminTableBody">
                    <tr class="admin-item-row">
                        <td><input type="text" class="admin-input in-item-nama" value="Biaya Formulir & Administrasi Pendaftaran Gelombang Utama" oninput="executeMirroringLoop()"></td>
                        <td><input type="number" class="admin-input text-center-input in-item-qty" value="1" oninput="executeMirroringLoop()"></td>
                        <td><input type="number" class="admin-input text-right-input in-item-harga" value="250000" oninput="executeMirroringLoop()"></td>
                        <td style="text-align: center;"><button type="button" class="btn-delete-row-action" onclick="deleteAdminRow(this)"><i class="fa-solid fa-trash-can"></i></button></td>
                    </tr>
                    <tr class="admin-item-row">
                        <td><input type="text" class="admin-input in-item-nama" value="Uang Pangkal / Uang Gedung (Sesuai Komitmen Awal)" oninput="executeMirroringLoop()"></td>
                        <td><input type="number" class="admin-input text-center-input in-item-qty" value="1" oninput="executeMirroringLoop()"></td>
                        <td><input type="number" class="admin-input text-right-input in-item-harga" value="2500000" oninput="executeMirroringLoop()"></td>
                        <td style="text-align: center;"><button type="button" class="btn-delete-row-action" onclick="deleteAdminRow(this)"><i class="fa-solid fa-trash-can"></i></button></td>
                    </tr>
                </tbody>
            </table>

            <button type="button" class="btn-add-row-action" onclick="addAdminRow()">
                <i class="fa-solid fa-circle-plus"></i> Sisipkan Komponen Biaya Baru
            </button>

            <div class="meta-input-grid" style="margin-top: 8px;">
                <div class="form-group">
                    <label>Potongan / Diskon Tambahan (Rp)</label>
                    <input type="number" id="inDiskon" class="admin-input" value="0" oninput="executeMirroringLoop()">
                </div>
                <div class="form-group">
                    <label>Petugas Admin Verifikator</label>
                    <input type="text" id="inAdminPembuat" class="admin-input" value="Admin JOG-WRO" oninput="executeMirroringLoop()">
                </div>
                <div class="form-group">
                    <label>Validasi Status Pembayaran</label>
                    <select id="inStatus" class="admin-input" onchange="executeMirroringLoop()" style="cursor: pointer;">
                        <option value="pending" selected>PENDING (Belum Valid)</option>
                        <option value="valid">VALID / LUNAS (Terbitkan Kuitansi)</option>
                    </select>
                </div>
            </div>

            <div class="admin-summary-area">
                <span style="font-size: 13.5px; font-weight: 700; color: var(--muted);"><i class="fa-solid fa-circle-info"></i> Seluruh perubahan di atas langsung dirender ke dokumen di bawah secara real-time.</span>
                <div class="admin-actions-right">
                    <button type="button" class="btn-action-back" onclick="triggerConfirmBack()">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </button>
                    <button type="button" class="btn-action-save" onclick="simulateSaveAndPrint()"><i class="fa-solid fa-print"></i> Simpan & Cetak PDF Dokumen</button>
                </div>
            </div>
        </div>

        <div class="preview-title-divider">LIVE PREVIEW HASIL JADI DOKUMEN CETAK SAKTI</div>

        <div class="print-document-wrapper">
            
            <div class="page page-break">
                <div class="watermark">SAKTI OFFICIAL</div>

                <header class="authentic-header">
                    <div class="header-left">
                         <img src="{{ asset('img/E-Kanisius 1.png') }}" alt="E-Kanisius Logo" 
                         style="width:85px; height:auto; object-fit:contain; flex-shrink:0;" 
                         onerror="this.style.display='none'; document.getElementById('fallback-logo').style.display='flex';">
                        <div class="header-title-block">
                            <h2>YAYASAN KANISIUS</h2>
                            <p>Sistem Admisi Terintegrasi</p>
                        </div>
                    </div>
                    <div class="header-right-meta">
                        <p>Dokumen Digital Otentik</p>
                        <p>Secured ID: <strong style="font-family: 'DM Mono', monospace;">SAKTI-DOC-2026</strong></p>
                    </div>
                </header>

                <div class="content-block">
                    <div class="invoice-title-row">
                        <h1>KUITANSI PEMBAYARAN</h1>
                        <span style="font-family: 'DM Mono', monospace; font-size: 13.5px; font-weight: 700; color: var(--navy);" id="viewNoReg">NO: -</span>
                    </div>

                    <div class="bill-info-grid">
                        <div class="bill-node">
                            <h4>Diterima Dari (Wali Murid)</h4>
                            <p id="viewNamaWali">-</p>
                        </div>
                        <div class="bill-node">
                            <h4>Nama Calon Siswa</h4>
                            <p id="viewNamaSiswa">-</p>
                        </div>
                    </div>

                    <table class="invoice-table">
                        <thead>
                            <tr>
                                <th>Komponen Deskripsi Rincian Komitmen Biaya</th>
                                <th class="text-center" style="width: 70px;">Qty</th>
                                <th class="text-right" style="width: 160px;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="viewInvoiceTableBody">
                        </tbody>
                    </table>

                    <div class="summary-wrapper">
                        <table class="summary-table">
                            <tr>
                                <td>Subtotal Keseluruhan</td>
                                <td class="text-right" id="viewSubtotal">Rp 0</td>
                            </tr>
                            <tr>
                                <td>Potongan / Diskon</td>
                                <td class="text-right" id="viewDiskon" style="color: var(--red);">- Rp 0</td>
                            </tr>
                            <tr class="grand-total">
                                <td>Total Bayar</td>
                                <td class="text-right" id="viewTotalAkhir">Rp 0</td>
                            </tr>
                        </table>
                    </div>

                    <div id="viewStatusBadge" class="status-badge-document pending-mode">
                    </div>
                </div>
            </div>

            <div class="page">
                <div class="watermark">SAKTI SYSTEM</div>

                <header class="authentic-header">
                    <div class="header-left">
                        <div class="header-logo-box" style="background: var(--blue);"><i class="fa-solid fa-circle-info"></i></div>
                        <div class="header-title-block">
                            <h2>YAYASAN KANISIUS</h2>
                            <p>Panduan Administrasi & Metode Pembayaran</p>
                        </div>
                    </div>
                    <div class="header-right-meta">
                        <p>Lembar Lampiran 2</p>
                        <p>Ref: <span id="viewNoRegRef" style="font-weight: 700; color: var(--navy);">-</span></p>
                    </div>
                </header>

                <div class="content-block note-section">
                    <h3><i class="fa-solid fa-money-check-dollar" style="color: var(--blue);"></i> Rekening Virtual Account (VA)</h3>
                    
                    <div class="va-box">
                        <p style="font-size: 12px; font-weight: 800; color: var(--muted); text-transform: uppercase;">Bank CIMB Niaga (Kode Bank: 022)</p>
                        <div class="va-number">9888 3471 2345 6789</div>
                        <p style="font-size: 12.5px; font-weight: 600; color: #334155; margin-top: 6px;">Atas Nama: <strong style="color: var(--navy); text-transform: uppercase;" id="viewVaName">SAKTI KANISIUS - BUDI SANTOSO</strong></p>
                    </div>

                    <h3><i class="fa-solid fa-list-check" style="color: var(--blue);"></i> Petunjuk Tatacara Transfer Resmi</h3>
                    
                    <ol class="step-list">
                        <li>Buka aplikasi <strong>Mobile Banking</strong>, Internet Banking, atau datangi mesin ATM terdekat.</li>
                        <li>Pilih menu <strong>Transfer</strong>, kemudian pilih opsi <strong>Transfer ke Bank Lain / CIMB Niaga</strong>.</li>
                        <li>Masukkan Kode Bank <strong>022</strong> diikuti Nomor Virtual Account: <strong>9888347123456789</strong>.</li>
                        <li>Pastikan pada layar konfirmasi tujuan muncul nama penerima yang valid: <strong id="viewVaNameStep" style="text-transform: uppercase;">-</strong>.</li>
                        <li>Masukkan nominal transfer sama persis dengan angka tagihan lembar ke-1: <strong id="viewTotalStep">-</strong>.</li>
                        <li>Simpan lembar PDF resmi ini sebagai bukti pembayaran digital otentik yang sah dari portal admisi.</li>
                    </ol>

                    <div style="margin-top: 50px; border-top: 1px solid var(--border); padding-top: 20px; font-size: 12px; color: var(--muted); line-height: 1.5; font-weight: 500;">
                        <p>* Dokumen ini dibuat otomatis oleh komputer <strong>Sistem Admisi Kanisius Terintegrasi (SAKTI)</strong>. Diverifikasi sah oleh petugas resmi: <strong id="viewAdminSign" style="color: var(--navy);">-</strong> pada tanggal 16/06/2026.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div id="confirmBackModal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-icon" style="background: #fff5f5; color: var(--red);"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <h3 class="modal-title">Tinggalkan Halaman?</h3>
            <p class="modal-desc">Seluruh perubahan komponen invoice yang Anda ketik manual akan dibuang dan hilang dari memori workspace kerja.</p>
            <div class="modal-btn-group">
                <button type="button" onclick="closeConfirmBackModal()" class="modal-btn modal-btn-cancel">Batal</button>
                <button type="button" onclick="executeBackNavigation()" class="modal-btn modal-btn-confirm">Ya, Keluar</button>
            </div>
        </div>
    </div>

    <div id="toast"></div>

    <script>
        // 1. CORE LOGIC JAVASCRIPT: REAL-TIME MIRRORING & LOOPING KOMPONEN BIAYA
        function executeMirroringLoop() {
            const namaSiswa = document.getElementById('inNamaSiswa').value || 'Tanpa Nama';
            const noReg = document.getElementById('inNoReg').value || 'REG-MOCK-EMPTY';
            const namaWali = document.getElementById('inNamaWali').value || 'Tanpa Wali';
            const diskon = parseFloat(document.getElementById('inDiskon').value) || 0;
            const adminPembuat = document.getElementById('inAdminPembuat').value || 'Panitia Admisi';
            const status = document.getElementById('inStatus').value;

            document.getElementById('viewNamaSiswa').textContent = namaSiswa;
            document.getElementById('viewNoReg').textContent = 'NO: ' + noReg;
            document.getElementById('viewNoRegRef').textContent = noReg;
            document.getElementById('viewNamaWali').textContent = namaWali;
            document.getElementById('viewVaName').textContent = 'SAKTI KANISIUS - ' + namaSiswa;
            document.getElementById('viewVaNameStep').textContent = 'SAKTI KANISIUS - ' + namaSiswa;
            document.getElementById('viewAdminSign').textContent = adminPembuat;

            let subtotal = 0;
            const adminRows = document.querySelectorAll('.admin-item-row');
            const documentTableBody = document.getElementById('viewInvoiceTableBody');
            
            documentTableBody.innerHTML = ''; 

            adminRows.forEach(row => {
                const namaKomponen = row.querySelector('.in-item-nama').value || 'Komponen Biaya Baru';
                const qty = parseFloat(row.querySelector('.in-item-qty').value) || 0;
                const harga = parseFloat(row.querySelector('.in-item-harga').value) || 0;
                
                const rowTotal = qty * harga;
                subtotal += rowTotal;

                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${namaKomponen}</td>
                    <td class="text-center">${qty}</td>
                    <td class="text-right">Rp ${rowTotal.toLocaleString('id-ID')}</td>
                `;
                documentTableBody.appendChild(tr);
            });

            const totalAkhir = subtotal - diskon;

            document.getElementById('viewSubtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
            document.getElementById('viewDiskon').textContent = '- Rp ' + diskon.toLocaleString('id-ID');
            document.getElementById('viewTotalAkhir').textContent = 'Rp ' + totalAkhir.toLocaleString('id-ID');
            document.getElementById('viewTotalStep').textContent = 'Rp ' + totalAkhir.toLocaleString('id-ID');

            const statusBadge = document.getElementById('viewStatusBadge');
            if(status === 'valid') {
                statusBadge.className = 'status-badge-document valid-mode';
                statusBadge.innerHTML = `<i class="fa-solid fa-circle-check" style="font-size: 16px;"></i> STATUS PEMBAYARAN: SAH / LUNAS TERVERIFIKASI ADMIN SAKTI`;
            } else {
                statusBadge.className = 'status-badge-document pending-mode';
                statusBadge.innerHTML = `<i class="fa-solid fa-wallet" style="font-size: 16px;"></i> STATUS PEMBAYARAN: PENDING / MENUNGGU KONFIRMASI TRANSFER`;
            }
        }

        /* ============================================================
            ROW MANAGEMENT & ACTION PANEL UTILITIES
        ============================================================ */
        function addAdminRow() {
            const tbody = document.getElementById('adminTableBody');
            const tr = document.createElement('tr');
            tr.className = 'admin-item-row';
            tr.innerHTML = `
                <td><input type="text" class="admin-input in-item-nama" value="" placeholder="Masukkan nama komponen biaya baru..." oninput="executeMirroringLoop()"></td>
                <td><input type="number" class="admin-input text-center-input in-item-qty" value="1" oninput="executeMirroringLoop()"></td>
                <td><input type="number" class="admin-input text-right-input in-item-harga" value="0" oninput="executeMirroringLoop()"></td>
                <td style="text-align: center;"><button type="button" class="btn-delete-row-action" onclick="deleteAdminRow(this)"><i class="fa-solid fa-trash-can"></i></button></td>
            `;
            tbody.appendChild(tr);
            executeMirroringLoop();
            showToast('➕ Baris komponen biaya baru berhasil disisipkan.');
        }

        function deleteAdminRow(button) {
            const rows = document.querySelectorAll('.admin-item-row');
            if(rows.length === 1) {
                alert('Gagal Hapus: Kuitansi harus menyisakan minimal 1 komponen biaya!');
                return;
            }
            button.closest('.admin-item-row').remove();
            executeMirroringLoop();
            showToast('🗑️ Komponen biaya dihapus dari daftar.');
        }

        function showToast(msg) {
            const t = document.getElementById('toast');
            t.innerHTML = msg;
            t.classList.add('show');
            clearTimeout(t._timer);
            t._timer = setTimeout(() => t.classList.remove('show'), 2500);
        }

        function simulateSaveAndPrint() {
            const rowsCount = document.querySelectorAll('.admin-item-row').length;
            const status = document.getElementById('inStatus').value;
            const namaSiswa = document.getElementById('inNamaSiswa').value || 'Siswa';
            
            showToast('<i class="fa-solid fa-floppy-disk"></i> <strong>Sakti DB Guard:</strong> Menyimpan data invoice ke database...');
            
            setTimeout(() => {
                if(status === 'valid') {
                    alert(`[SIMULASI SUKSES SAVE]\nData invoice ${namaSiswa} sebanyak ${rowsCount} komponen berhasil disimpan ke database db_spmb!\n\nOrang tua sekarang dapat melihat kuitansi LUNAS ini di dashboard mereka.\n\nKlik OK untuk mencetak dokumen fisik resmi.`);
                } else {
                    alert(`[SIMULASI SUKSES SAVE DRAFT]\nInvoice ${namaSiswa} disimpan dengan status PENDING.\n\nKlik OK untuk mencetak/menyimpan dokumen pratinjau.`);
                }
                window.print();
            }, 600);
        }

        /* ============================================================
            PROTOTYPE BACK-NAVIGATION SEAMLESS BRIDGING
        ============================================================ */
        const backModal = document.getElementById('confirmBackModal');

        function triggerConfirmBack() {
            backModal.classList.add('show');
        }

        function closeConfirmBackModal() {
            backModal.classList.remove('show');
        }

        function executeBackNavigation() {
            backModal.classList.remove('show');
            
            // Evaluasi lingkungan eksekusi (Laravel Server vs Standalone Local Prototype File)
            if (typeof window.laravelRouteInverse !== 'undefined' || window.location.protocol.startsWith('http')) {
                // Di-redirect aman ke file routing asli Laravel dashboard_admin.admin
                window.location.href = "{{ route('admin') }}";
            } else {
                // Sandboxed alert info untuk kebutuhan pamer demo tanpa server lokal
                alert("Redirecting via Blade Syntax to Dashboard Admin!\nURL Target: {{ route('admin') }}");
            }
        }

        document.addEventListener("DOMContentLoaded", () => {
            executeMirroringLoop();
        });
    </script>
</body>

</html>