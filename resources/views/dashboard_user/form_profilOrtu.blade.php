<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remix: SAKTI - Sistem Admisi Kanisius Terintegrasi</title>

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
            --red: #dc2626;
            --radius: 14px;
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
            padding-bottom: 48px;
        }

        .container {
            max-width: 1152px;
            width: 100%;
            margin: 24px auto 0 auto;
            padding: 0 16px;
        }

        /* ===================== TOPBAR / NAVBAR ===================== */
        .topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            border-radius: 18px;
            box-shadow: 0 2px 16px rgba(26, 42, 108, 0.07);
            margin-bottom: 24px;
        }

        .topbar-brand {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .brand-logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .brand-logo-fallback {
            width: 40px;
            height: 40px;
            background: var(--navy);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .brand-name {
            font-size: 16px;
            font-weight: 900;
            color: var(--navy);
            letter-spacing: 0.5px;
        }

        .brand-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 2px;
        }

        .brand-role {
            font-size: 10px;
            font-weight: 700;
            color: var(--gold-dark);
            background: #fff8e7;
            padding: 2px 8px;
            border-radius: 99px;
            border: 1px solid #fce8bd;
            text-transform: uppercase;
        }

        .brand-uid {
            font-family: monospace;
            font-size: 10px;
            color: var(--muted);
        }

        /* Nav links */
        .topbar-nav {
            display: flex;
            align-items: center;
            gap: 32px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
            color: var(--muted);
            text-decoration: none;
            transition: all 0.2s;
            padding: 6px 14px;
            border-radius: 99px;
        }

        .nav-link:hover {
            color: var(--navy);
            background: #f0f4ff;
        }

        .nav-link.active {
            color: var(--navy);
            font-weight: 800;
            background: #f0f4ff;
            padding: 6px 14px;
            border-radius: 99px;
            box-shadow: 0 2px 8px rgba(26, 42, 108, 0.15);
        }

        .nav-dot {
            width: 8px;
            height: 8px;
            background: var(--gold);
            border-radius: 50%;
            flex-shrink: 0;
            order: -1;
        }

        /* Topbar right */
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar-username {
            text-align: right;
            line-height: 1.2;
        }

        .topbar-uname {
            font-size: 14px;
            font-weight: 700;
            color: var(--navy);
        }

        .topbar-urole {
            font-size: 11px;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .topbar-logout {
            width: 42px;
            height: 42px;
            background: #fff0f0;
            border: none;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .topbar-logout:hover {
            background: #ffe0e0;
        }

        .topbar-logout i {
            color: var(--red);
            font-size: 16px;
        }

        /* ===================== MAIN CARD CONTENT ===================== */
        .main-card {
            background: var(--surface);
            border-radius: 40px;
            border: 1px solid #f3f4f6;
            padding: 48px 24px;
            max-width: 896px;
            width: 100%;
            margin: 0 auto;
            text-align: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .avatar-container {
            background: #f0f5fa;
            width: 64px;
            height: 64px;
            border-radius: 20px;
            margin: 0 auto 16px auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-container i {
            color: var(--navy);
            font-size: 24px;
        }

        .main-title {
            color: var(--navy);
            font-size: 30px;
            font-weight: 900;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .main-subtitle {
            color: var(--muted);
            font-size: 14px;
            max-width: 448px;
            margin: 0 auto 40px auto;
            line-height: 1.6;
        }

        /* Form & Grid CSS Manual */
        .form-container {
            text-align: left;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        /* Indikator Tanda Bintang Merah untuk Required Field */
        .form-group.required .form-label::after {
            content: " *";
            color: var(--red);
        }

        .form-label {
            font-size: 11px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .select-wrapper {
            position: relative;
            width: 100%;
            display: block;
        }

        .form-control {
            width: 100%;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 14px 16px;
            font-size: 14px;
            font-weight: 600;
            color: var(--navy);
            outline: none;
            transition: border-color 0.2s;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        /* State jika input divalidasi kosong saat submit */
        .form-control.input-error {
            border-color: var(--red);
            background: #fff5f5;
        }

        .form-control:focus {
            border-color: var(--navy);
        }

        select.form-control {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            cursor: pointer;
            padding-right: 44px;
            position: relative;
        }

        .select-icon {
            position: absolute;
            top: 50%;
            right: 16px;
            transform: translateY(-50%);
            pointer-events: none;
            color: var(--navy);
            font-size: 12px;
            line-height: 1;
            z-index: 1;
        }

        textarea.form-control {
            resize: none;
            height: 96px;
            font-family: inherit;
        }

        /* Counter Section */
        .counter-section {
            text-align: center;
            padding-top: 16px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .btn-group {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }

        .anak-btn {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
            background: var(--surface);
            border: 1px solid var(--border);
            color: var(--muted);
        }

        .anak-btn:hover {
            border-color: var(--navy);
            color: var(--navy);
        }

        .anak-btn.active {
            background: var(--navy);
            color: var(--gold);
            border: none;
        }

        /* Submit Action */
        .submit-container {
            padding-top: 24px;
            display: flex;
            justify-content: center;
        }

        /* Mengganti tag <a> menjadi <button type="submit"> murni */
        .btn-submit {
            background: var(--navy);
            color: var(--surface);
            font-weight: bold;
            font-size: 14px;
            padding: 16px 32px;
            border-radius: 24px;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 10px 15px -3px rgba(26, 42, 108, 0.3);
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-submit:hover {
            background: #111c44;
            transform: translateY(-1px);
        }

        .btn-submit i {
            font-size: 12px;
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

        /* ===================== RESPONSIVE (MEDIA QUERIES) ===================== */
        @media (max-width: 768px) {
            .topbar {
                flex-direction: column;
                padding: 20px;
                text-align: center;
            }

            .topbar-brand {
                flex-direction: column;
                gap: 8px;
            }

            .topbar-username {
                text-align: center;
            }

            .topbar-right {
                width: 100%;
                justify-content: center;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .main-card {
                padding: 32px 16px;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <header class="topbar">
            <div class="topbar-brand">
                <div class="brand-logo-container">
                    <img src="{{ asset('img/E-Kanisius 1.png') }}" alt="E-Kanisius Logo"
                        style="width: 85px; height: auto; object-fit: contain; flex-shrink: 0;"
                        onerror="this.style.display='none'; document.getElementById('fallback-logo').style.display='flex';">

                    <div id="fallback-logo" class="brand-logo-fallback" style="display: none;">⛵</div>
                </div>

                 <div class="brand-text">
                <div class="brand-name">PORTAL SAKTI</div>
                <div class="brand-meta">
                    <span class="brand-role">Parent</span>
                    <span class="brand-uid">UID-Jzp4Z3bwwoNY7IhFuiPNdTsN9w63</span>
                </div>
            </div>
        </div>
            <nav class="topbar-nav">
                <a class="nav-link active" href="#">
                    <span>Dashboard</span>
                    <span class="nav-dot"></span>
                </a>
                <a class="nav-link" href="#">
                    <span>Riwayat</span>
                </a>
                <a class="nav-link" href="#">
                    <span>Pusat Bantuan</span>
                </a>
            </nav>

            <div class="topbar-right">
                <div class="topbar-username">
                    <div class="topbar-uname">Ignatius Arya</div>
                    <div class="topbar-urole">Cabang Global</div>
                </div>

                <button class="topbar-logout" title="Keluar" onclick="showToast('🚪 Sedang keluar...')">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </button>
            </div>
        </header>

        <main class="main-card">
            <div class="avatar-container">
                <i class="fa-regular fa-user"></i>
            </div>

            <h2 class="main-title">Profil Orang Tua</h2>
            <p class="main-subtitle">
                Lengkapi data pribadi Ayah/Bunda sebelum melanjutkan pendaftaran anak.
            </p>

            <!-- FORM VALIDATION MURNI -->
            <form id="formProfilOrtu" action="{{ route('profil.ortu.store') }}" method="POST" class="form-container" novalidate>
                @csrf
                <div class="form-grid">
                    <!-- Ditambahkan class required pada form-group untuk indikator CSS bintang -->
                    <div class="form-group required">
                        <label class="form-label">Pendidikan Terakhir</label>
                        <div class="select-wrapper">
                            <select name="pendidikan" class="form-control" required>
                                <option value="SMA">SMA / Sederajat</option>
                                <option value="SMA">D3 / Diploma</option>
                                <option value="S1" selected>S1 / Sarjana</option>
                                <option value="S2">S2 / Magister</option>
                                <option value="S2">S3 / Doktor</option>
                            </select>
                            <div class="select-icon">
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>

                    <div class="form-group required">
                        <label class="form-label">Rentang Penghasilan</label>
                        <div class="select-wrapper">
                            <select name="penghasilan" class="form-control" required>
                                <option value="" selected disabled>Pilih Rentang Gaji</option>
                                <option value="1">&lt; Rp 5.000.000</option>
                                <option value="2">Rp 5.000.000 - Rp 10.000.000</option>
                                <option value="3">&gt; Rp 10.000.000</option>
                            </select>
                            <div class="select-icon">
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>
                </div>
   <div class="form-group required">
                    <label class="form-label">Nomor Telepon</label>
                    <textarea name="nomor_telepon" class="form-control" placeholder="Masukkan nomor telepon..." required></textarea>
                </div>
                <div class="form-group required">
                    <label class="form-label">Alamat Domisili Sesuai KTP</label>
                    <textarea name="alamat" class="form-control" placeholder="Masukkan alamat lengkap..." required></textarea>
                </div>

                <div class="form-grid">
                    <div class="form-group required">
                        <label class="form-label">Unit Sekolah Tujuan</label>
                        <div class="select-wrapper">
                            <select name="unit_sekolah" class="form-control" required>
                                <option value="TK Wirobrajan" selected>TK Wirobrajan</option>
                                <option value="SD Kanisius">SD Kanisius Hati Kudus</option>
                            </select>
                            <div class="select-icon">
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="counter-section">
                    <label class="form-label">Jumlah Anak Yang Akan Didaftarkan</label>
                    <div class="btn-group">
                        <button type="button" class="anak-btn active" data-val="1">1</button>
                        <button type="button" class="anak-btn" data-val="2">2</button>
                        <button type="button" class="anak-btn" data-val="3">3</button>
                        <button type="button" class="anak-btn" data-val="4">4</button>
                        <button type="button" class="anak-btn" data-val="5">5</button>
                    </div>
                </div>

                <!-- PERBAIKAN: Berubah menjadi Button type="submit" asli -->
                <div class="submit-container">
                    <button type="submit" class="btn-submit">
                        <span>Simpan Profil & Mulai Form Siswa</span>
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>
            </form>
        </main>
    </div>

    <!-- STRUCTURE CUSTOM POP-UP MODAL -->
    <div id="errorModal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-icon">
                <i class="fa-solid fa-circle-exclamation"></i>
            </div>
            <h3 class="modal-title">Data Belum Lengkap</h3>
            <p class="modal-desc">Mohon periksa kembali. Seluruh bidang data bertanda bintang (*) wajib diisi sebelum melanjutkan.</p>
            <button type="button" id="closeModalBtn" class="modal-btn-close">Mengerti</button>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Logika Seleksi Tombol Jumlah Anak
            const buttons = document.querySelectorAll(".anak-btn");
            buttons.forEach(btn => {
                btn.addEventListener("click", function () {
                    buttons.forEach(b => b.classList.remove("active"));
                    this.classList.add("active");
                });
            });

            // ELEMEN VALIDASI CUSTOM POP-UP
            const form = document.getElementById("formProfilOrtu");
            const modal = document.getElementById("errorModal");
            const closeModalBtn = document.getElementById("closeModalBtn");

            form.addEventListener("submit", function (event) {
                let isFormValid = true;
                
                // Ambil seluruh elemen input/select/textarea yang memiliki atribut required
                const requiredFields = form.querySelectorAll("[required]");

                requiredFields.forEach(field => {
                    // Validasi jika value kosong atau belum memilih opsi valid
                    if (!field.value || field.value.trim() === "") {
                        isFormValid = false;
                        field.classList.add("input-error"); // Tambah border merah murni CSS
                    } else {
                        field.classList.remove("input-error");
                    }
                });

                // Jika ada data yang kosong, gagalkan pemindahan halaman dan munculkan Pop-up
                if (!isFormValid) {
                    event.preventDefault(); // Menghentikan redirect/action form
                    modal.classList.add("show"); // Menampilkan pop-up modal di tengah
                }
            });

            // Menutup pop-up ketika tombol 'Mengerti' diklik
            closeModalBtn.addEventListener("click", function () {
                modal.classList.remove("show");
            });

            // Menghilangkan highlight merah secara realtime saat user mulai mengisi input kembali
            form.querySelectorAll("[required]").forEach(field => {
                field.addEventListener("input", function() {
                    if (this.value && this.value.trim() !== "") {
                        this.classList.remove("input-error");
                    }
                });
                field.addEventListener("change", function() {
                    if (this.value) {
                        this.classList.remove("input-error");
                    }
                });
            });
        });
    </script>
</body>

</html>