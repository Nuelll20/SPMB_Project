<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remix: SAKTI - Sistem Admisi Kanisius Terintegrasi</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Custom Colors berdasarkan Gambar */
        background-color: #F4F7FA;

        .bg-sakti-blue {
            background-color: #002B5B;
        }

        .text-sakti-blue {
            color: #002B5B;
        }

        .border-sakti-blue {
            border-color: #002B5B;
        }

        .bg-sakti-light {
            background-color: #E8F0FE;
        }

        .text-sakti-orange {
            color: #E5A93C;
        }

        .anak-btn {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            background: white;
            border: 1px solid #e5e7eb;
            color: #9ca3af;
            font-weight: bold;
            cursor: pointer;
        }

        .anak-btn.active {
            background: #002B5B;
            color: #E5A93C;
            border: none;
        }
    </style>
</head>


<body class="bg-[#F4F7FA] font-sans antialiased text-gray-700 min-h-screen pb-12">



    <div class="max-w-6xl mx-auto px-4 mt-6">
        <header
            class="bg-white rounded-3xl p-4 shadow-sm flex flex-col md:flex-row justify-between items-center border border-gray-100 mb-8">

            <div class="flex items-center space-x-4">
                <div class="bg-sakti-blue text-white p-3 rounded-2xl flex items-center justify-center shadow-md">
                    <i class="fa-solid fa-building-columns text-xl"></i>
                </div>
                <div>
                    <h1 class="text-sakti-blue font-black text-lg tracking-wider">SAKTI PORTAL</h1>
                    <div class="flex items-center space-x-2 mt-0.5">
                        <span
                            class="bg-[#FFF8E7] text-sakti-orange text-[10px] font-bold px-2 py-0.5 rounded-full border border-[#FCE8BD] flex items-center space-x-1">
                            <i class="fa-solid fa-shield-halved text-[9px]"></i> <span>PARENT</span>
                        </span>
                    </div>
                </div>
            </div>

            <nav class="flex items-center space-x-8 my-4 md:my-0 font-semibold text-sm">
                <a href="#" class="text-sakti-blue flex items-center space-x-2 relative py-1">
                    <i class="fa-solid fa-table-cells-large"></i>
                    <span>Dashboard</span>
                    <span
                        class="absolute bottom-0 left-1/2 -translate-x-1/2 w-1.5 h-1.5 bg-sakti-orange rounded-full"></span>
                </a>
                <a href="#" class="text-gray-400 hover:text-sakti-blue flex items-center space-x-2 transition">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span>Riwayat</span>
                </a>
                <a href="#" class="text-gray-400 hover:text-sakti-blue flex items-center space-x-2 transition">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>Pusat Bantuan</span>
                </a>
            </nav>

            <div class="flex items-center space-x-4">
                <div class="text-right">
                    <p class="font-bold text-sakti-blue text-sm">Profil Orang Tua+</p>
                    <p class="text-[11px] text-gray-400 font-medium tracking-wider">CABANG GLOBAL</p>
                </div>
                <button
                    class="bg-[#FFF0F0] text-[#FF4D4D] p-3 rounded-2xl hover:bg-[#FFE0E0] transition flex items-center justify-center">
                    <i class="fa-solid fa-arrow-right-from-bracket text-md"></i>
                </button>
            </div>
        </header>

        <main
            class="bg-white rounded-[40px] shadow-sm border border-gray-50 px-6 py-12 md:px-20 text-center max-w-4xl mx-auto">

            <div class="bg-[#F0F5FA] w-16 h-16 rounded-3xl mx-auto flex items-center justify-center mb-4">
                <i class="fa-regular fa-user text-sakti-blue text-2xl"></i>
            </div>

            <h2 class="text-sakti-blue text-3xl font-black tracking-wide mb-2">Profil Orang Tua</h2>
            <p class="text-gray-400 text-sm max-w-md mx-auto leading-relaxed mb-10">
                Lengkapi data pribadi Ayah/Bunda sebelum melanjutkan pendaftaran anak.
            </p>

            <form action="{{ route('profil.ortu.store') }}" method="POST" class="text-left space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">Pendidikan
                            Terakhir</label>
                        <div class="relative">
                            <select name="pendidikan"
                                class="w-full bg-white border border-gray-200 rounded-2xl px-4 py-3.5 text-sm font-semibold text-sakti-blue focus:outline-none focus:border-sakti-blue appearance-none cursor-pointer shadow-sm">
                                <option value="SMA">SMA / Sederajat</option>
                                <option value="SMA">D3 / Diploma</option>
                                <option value="S1" selected>S1 / Sarjana</option>
                                <option value="S2">S2 / Magister</option>
                                <option value="S2">S3 / Doktor</option>

                            </select>
                            <div
                                class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-sakti-blue text-xs">
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">Rentang
                            Penghasilan</label>
                        <div class="relative">
                            <select name="penghasilan"
                                class="w-full bg-white border border-gray-200 rounded-2xl px-4 py-3.5 text-sm font-semibold text-sakti-blue focus:outline-none focus:border-sakti-blue appearance-none cursor-pointer shadow-sm">
                                <option value="" selected disabled>Pilih Rentang Gaji</option>
                                <option value="1">
                                    < Rp 5.000.000</option>
                                <option value="2">Rp 5.000.000 - Rp 10.000.000</option>
                                <option value="3">> Rp 10.000.000</option>
                            </select>
                            <div
                                class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-sakti-blue text-xs">
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">

                    <label class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">Alamat Domisili
                        Sesuai KTP</label>
                    <textarea name="alamat" rows="3"
                        class="w-full bg-white border border-gray-200 rounded-2xl px-4 py-3.5 text-sm font-semibold text-sakti-blue focus:outline-none focus:border-sakti-blue shadow-sm resize-none"
                        placeholder="Masukkan alamat lengkap..."></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">Wilayah
                            Pendaftaran</label>
                        <div class="relative">
                            <select name="wilayah"
                                class="w-full bg-white border border-gray-200 rounded-2xl px-4 py-3.5 text-sm font-semibold text-sakti-blue focus:outline-none focus:border-sakti-blue appearance-none cursor-pointer shadow-sm">
                                <option value="Yogyakarta" selected>Yogyakarta</option>
                                <option value="Jakarta">Jakarta</option>
                                <option value="Jawa Tengah">Jawa Tengah</option>
                            </select>
                            <div
                                class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-sakti-blue text-xs">
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">Unit Sekolah
                            Tujuan</label>
                        <div class="relative">
                            <select name="unit_sekolah"
                                class="w-full bg-white border border-gray-200 rounded-2xl px-4 py-3.5 text-sm font-semibold text-sakti-blue focus:outline-none focus:border-sakti-blue appearance-none cursor-pointer shadow-sm">
                                <option value="TK Wirobrajan" selected>TK Wirobrajan</option>
                                <option value="SD Kanisius">SD Kanisius Hati Kudus</option>

                            </select>
                            <div
                                class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-sakti-blue text-xs">
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 pt-4 text-center">
                    <label class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">Jumlah Anak Yang
                        Akan Didaftarkan</label>
                    <div class="flex justify-center items-center space-x-2">
                        <button type="button" class="anak-btn active">1</button>
                        <button type="button" class="anak-btn">2</button>
                        <button type="button" class="anak-btn">3</button>
                        <button type="button" class="anak-btn">4</button>
                        <button type="button" class="anak-btn">5</button>
                    </div>
                </div>
                <div class="pt-6 flex justify-center">
                    <a href="{{ route('form.daftar') }}"
                        class="bg-[#002B5B] hover:bg-[#001F42] text-white font-bold text-sm px-8 py-4 rounded-3xl inline-flex items-center space-x-3 shadow-lg transition">
                        <span>Simpan Profil & Mulai Form Siswa</span>
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </a>
                </div>
            </form>
        </main>
    </div>

</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {

        const buttons = document.querySelectorAll(".anak-btn");

        buttons.forEach(btn => {
            btn.addEventListener("click", function () {

                buttons.forEach(b => {
                    b.classList.remove("active");
                });

                this.classList.add("active");
            });
        });

    });
</script>

</html>