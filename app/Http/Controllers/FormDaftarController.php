<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class FormDaftarController extends Controller
{
    public function index()
    {
        $orangTua = $this->getOrangTua();

        if (!$orangTua) {
            return redirect()->route('profil.ortu')
                ->with('warning', 'Lengkapi profil orang tua terlebih dahulu.');
        }

        session(['uid_orangtua' => $orangTua->uid]);

        $draft = DB::table('calon_siswa')
            ->where('uid_orangtua', $orangTua->uid)
            ->where('status', 'draft')
            ->orderByDesc('uid')
            ->first();

        $berkas = collect();

        if ($draft) {
            $berkas = DB::table('berkas')
                ->where('id_pendaftar', $draft->uid)
                ->get()
                ->keyBy('jenis_berkas');
        }

        return view('dashboard_user.form_daftar', compact('draft', 'berkas', 'orangTua'));
    }

    public function store(Request $request)
    {
        $request->validate([
            // Anak pertama
            'nama_lengkap' => 'required|string|min:3|max:255',
            'nik' => 'required|digits:16',
            'tanggal_lahir' => 'required|date',
            'gol_darah' => 'nullable|string|max:3',
            'agama' => 'required|string|max:50',
            'alamat' => 'required|string|min:5|max:250',
            'tempat_lahir' => 'required|string|min:3|max:255',

            'kartu_keluarga' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'akte_kelahiran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'ktp_ortu' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'pas_foto' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'surat_baptis' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',

            // Anak tambahan
            'anak' => 'nullable|array',
            'anak.*.nama_lengkap' => 'required|string|min:3|max:255',
            'anak.*.nik' => 'required|digits:16',
            'anak.*.tanggal_lahir' => 'required|date',
            'anak.*.gol_darah' => 'nullable|string|max:3',
            'anak.*.agama' => 'required|string|max:50',
            'anak.*.alamat' => 'required|string|min:5|max:250',
            'anak.*.tempat_lahir' => 'required|string|min:3|max:255',

            'anak.*.kartu_keluarga' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'anak.*.akte_kelahiran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'anak.*.ktp_ortu' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'anak.*.pas_foto' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'anak.*.surat_baptis' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $orangTua = $this->getOrangTua();

        if (!$orangTua) {
            return redirect()->route('profil.ortu')
                ->with('warning', 'Lengkapi profil orang tua terlebih dahulu.');
        }

        $batchId = $this->getBatchPendaftaranId();

        $daftarAnak = $this->buildDaftarAnak($request);

        $this->validasiNikGandaDalamForm($daftarAnak);
        $this->validasiSuratBaptis($request, $daftarAnak);

        DB::transaction(function () use ($request, $daftarAnak, $orangTua, $batchId) {
            foreach ($daftarAnak as $anak) {
                $existing = DB::table('calon_siswa')
                    ->where('nik', $anak['nik'])
                    ->first();

                if ($existing && (int) $existing->uid_orangtua !== (int) $orangTua->uid) {
                    throw ValidationException::withMessages([
                        $anak['error_key'] . '.nik' => 'NIK ' . $anak['nik'] . ' sudah digunakan oleh pendaftar lain.',
                    ]);
                }

                if ($existing && ($existing->status ?? null) !== 'draft') {
                    throw ValidationException::withMessages([
                        $anak['error_key'] . '.nik' => 'NIK ' . $anak['nik'] . ' sudah pernah disubmit. Silakan cek halaman riwayat pendaftaran.',
                    ]);
                }

                $dataCalonSiswa = [
                    'nama' => $anak['nama_lengkap'],
                    'nik' => $anak['nik'],
                    'tanggal_lahir' => $anak['tanggal_lahir'],
                    'golongan_darah' => $anak['gol_darah'] ?? null,
                    'agama' => $anak['agama'],
                    'alamat' => $anak['alamat'],
                    'tempat_lahir' => $anak['tempat_lahir'],
                    'uid_orangtua' => $orangTua->uid,
                    'status' => 'pending',
                ];

                if ($existing) {
                    DB::table('calon_siswa')
                        ->where('uid', $existing->uid)
                        ->update($dataCalonSiswa);

                    $uidCalonSiswa = $existing->uid;
                } else {
                    $uidCalonSiswa = DB::table('calon_siswa')->insertGetId($dataCalonSiswa);
                }

                $noPendaftaran = $this->generateNoPendaftar($uidCalonSiswa);

                DB::table('calon_siswa')
                    ->where('uid', $uidCalonSiswa)
                    ->update([
                        'nomor_registrasi' => $noPendaftaran,
                    ]);

                $pendaftaran = DB::table('pendaftaran')
                    ->where('calon_siswa_id', $uidCalonSiswa)
                    ->first();

                $dataPendaftaran = [
                    'no_pendaftaran' => $noPendaftaran,
                    'id_batch_pendaftaran' => $batchId,
                    'status_pendaftaran' => 'pending',
                    'diverifikasi_oleh' => null,
                    'alasan_penolakan' => null,
                    'tanggal_daftar' => now()->toDateString(),
                    'calon_siswa_id' => $uidCalonSiswa,
                ];

                if ($pendaftaran) {
                    DB::table('pendaftaran')
                        ->where('uid', $pendaftaran->uid)
                        ->update($dataPendaftaran);

                    $uidPendaftaran = $pendaftaran->uid;
                } else {
                    $uidPendaftaran = DB::table('pendaftaran')->insertGetId($dataPendaftaran);
                }

                $this->replaceBerkas(
                    $request,
                    $uidPendaftaran,
                    $anak['file_prefix'],
                    $anak['nama_lengkap'],
                    $anak['nik']
                );
            }
        });

        return redirect()->route('dashboard')
            ->with('success', 'Data pendaftaran berhasil dikirim.');
    }

    private function buildDaftarAnak(Request $request): array
    {
        $daftarAnak = [];

        // Anak pertama, karena field-nya masih name biasa
        $daftarAnak[] = [
            'index' => 0,
            'error_key' => 'nama_lengkap',
            'file_prefix' => null,
            'nama_lengkap' => $request->input('nama_lengkap'),
            'nik' => $request->input('nik'),
            'tanggal_lahir' => $request->input('tanggal_lahir'),
            'gol_darah' => $request->input('gol_darah'),
            'agama' => $request->input('agama'),
            'alamat' => $request->input('alamat'),
            'tempat_lahir' => $request->input('tempat_lahir'),
        ];

        // Anak tambahan dari tombol + Tambah Anak
        foreach ($request->input('anak', []) as $index => $anak) {
            $daftarAnak[] = [
                'index' => $index,
                'error_key' => "anak.$index",
                'file_prefix' => "anak.$index",
                'nama_lengkap' => $anak['nama_lengkap'] ?? null,
                'nik' => $anak['nik'] ?? null,
                'tanggal_lahir' => $anak['tanggal_lahir'] ?? null,
                'gol_darah' => $anak['gol_darah'] ?? null,
                'agama' => $anak['agama'] ?? null,
                'alamat' => $anak['alamat'] ?? null,
                'tempat_lahir' => $anak['tempat_lahir'] ?? null,
            ];
        }

        return $daftarAnak;
    }

    private function validasiNikGandaDalamForm(array $daftarAnak): void
    {
        $nikList = [];

        foreach ($daftarAnak as $anak) {
            if (in_array($anak['nik'], $nikList)) {
                throw ValidationException::withMessages([
                    $anak['error_key'] . '.nik' => 'NIK tidak boleh sama antar data anak dalam satu formulir.',
                ]);
            }

            $nikList[] = $anak['nik'];
        }
    }

    private function validasiSuratBaptis(Request $request, array $daftarAnak): void
    {
        foreach ($daftarAnak as $anak) {
            if (($anak['agama'] ?? null) !== 'katolik') {
                continue;
            }

            $fieldSuratBaptis = $anak['file_prefix']
                ? $anak['file_prefix'] . '.surat_baptis'
                : 'surat_baptis';

            if (!$request->hasFile($fieldSuratBaptis)) {
                throw ValidationException::withMessages([
                    $anak['error_key'] . '.surat_baptis' => 'Surat Baptis wajib diupload untuk calon murid Katolik.',
                ]);
            }
        }
    }

    private function replaceBerkas(
        Request $request,
        int $uidPendaftaran,
        ?string $filePrefix = null,
        ?string $namaAnak = null,
        ?string $nikAnak = null
    ): void {
        $oldBerkas = DB::table('berkas')
            ->where('id_pendaftar', $uidPendaftaran)
            ->get();

        foreach ($oldBerkas as $berkas) {
            if (!empty($berkas->file_url)) {
                Storage::disk('public')->delete($berkas->file_url);
            }
        }

        DB::table('berkas')
            ->where('id_pendaftar', $uidPendaftaran)
            ->delete();

        $files = [
            'kartu_keluarga' => 'Kartu Keluarga',
            'akte_kelahiran' => 'Akte Kelahiran',
            'ktp_ortu' => 'E-KTP Orang Tua',
            'pas_foto' => 'Pas Foto',
            'surat_baptis' => 'Surat Baptis',
        ];

        $folder = $this->buildBerkasFolder($uidPendaftaran, $namaAnak, $nikAnak);

        foreach ($files as $inputName => $jenisBerkas) {
            $fieldName = $filePrefix
                ? $filePrefix . '.' . $inputName
                : $inputName;

            if (!$request->hasFile($fieldName)) {
                continue;
            }

            $file = $request->file($fieldName);
            $extension = strtolower($file->getClientOriginalExtension());

            $namaFileSlug = Str::slug($namaAnak ?? 'calon-siswa');
            $nikFileSlug = preg_replace('/\D/', '', $nikAnak ?? 'tanpa-nik');

            $fileName = Str::slug($jenisBerkas)
                . '-'
                . $namaFileSlug
                . '-'
                . $nikFileSlug
                . '-'
                . now()->format('YmdHis')
                . '-'
                . Str::random(6)
                . '.'
                . $extension;

            $path = $file->storeAs($folder, $fileName, 'public');

            if (method_exists($this, 'compressImageIfNeeded')) {
                $this->compressImageIfNeeded($path);
            }

            DB::table('berkas')->insert([
                'id_pendaftar' => $uidPendaftaran,
                'jenis_berkas' => $jenisBerkas,
                'file_url' => $path,
                'is_valid' => 0,
            ]);
        }
    }

    private function buildBerkasFolder(
        int $uidPendaftaran,
        ?string $namaAnak = null,
        ?string $nikAnak = null
    ): string {
        $user = Auth::user();

        $userId = $user->id ?? 'guest';
        $userName = Str::slug($user->name ?? 'user');

        $namaFolder = Str::slug($namaAnak ?? 'calon-siswa');
        $nikFolder = preg_replace('/\D/', '', $nikAnak ?? 'tanpa-nik');

        return "berkas/{$userId}-{$userName}/{$namaFolder}-{$nikFolder}/pendaftaran-{$uidPendaftaran}";
    }

    private function getBatchPendaftaranId(): int
    {
        $batchId = DB::table('batch_pendaftaran')
            ->where('is_active', 1)
            ->orderByDesc('uid')
            ->value('uid');

        if (!$batchId) {
            throw ValidationException::withMessages([
                'batch_pendaftaran' => 'Batch pendaftaran aktif belum tersedia. Silakan buat batch pendaftaran terlebih dahulu.',
            ]);
        }

        return (int) $batchId;
    }
    public function saveDraft(Request $request)
    {
        $orangTua = $this->getOrangTua();

        if (!$orangTua) {
            return response()->json([
                'success' => false,
                'message' => 'Profil orang tua belum ditemukan.',
            ], 422);
        }

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|min:3|max:255',
            'nik' => 'required|digits:16',
            'tanggal_lahir' => 'required|date',
            'gol_darah' => 'nullable|string|max:3',
            'agama' => 'required|string|max:50',
            'alamat' => 'required|string|min:5|max:250',
            'tempat_lahir' => 'required|string|min:3|max:255',
        ], [
            'nik.digits' => 'NIK wajib berisi tepat 16 digit.',
            '*.required' => 'Field wajib belum lengkap.',
        ]);

        return DB::transaction(function () use ($validated, $orangTua) {
            $existingByNik = DB::table('calon_siswa')
                ->where('nik', $validated['nik'])
                ->lockForUpdate()
                ->first();

            if ($existingByNik) {
                if ((int) $existingByNik->uid_orangtua !== (int) $orangTua->uid) {
                    return response()->json([
                        'success' => false,
                        'message' => 'NIK ini sudah digunakan pada akun orang tua lain.',
                    ], 422);
                }

                if ($existingByNik->status !== 'draft') {
                    return response()->json([
                        'success' => false,
                        'message' => 'NIK ini sudah pernah disubmit. Silakan cek halaman riwayat pendaftaran.',
                    ], 422);
                }

                $draft = $existingByNik;
            } else {
                $draft = DB::table('calon_siswa')
                    ->where('uid_orangtua', $orangTua->uid)
                    ->where('status', 'draft')
                    ->orderByDesc('uid')
                    ->lockForUpdate()
                    ->first();
            }

            $data = [
                'nama' => $validated['nama_lengkap'],
                'nik' => $validated['nik'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'alamat' => $validated['alamat'],
                'agama' => $validated['agama'],
                'golongan_darah' => $validated['gol_darah'] ?? null,
                'tempat_lahir' => $validated['tempat_lahir'],
                'uid_orangtua' => $orangTua->uid,
                'status' => 'draft',
                'nomor_registrasi' => null,
                'updated_at' => now(),
            ];

            if ($draft) {
                DB::table('calon_siswa')
                    ->where('uid', $draft->uid)
                    ->update($data);

                $uidCalonSiswa = $draft->uid;
            } else {
                $data['created_at'] = now();

                $uidCalonSiswa = DB::table('calon_siswa')
                    ->insertGetId($data);
            }

            return response()->json([
                'success' => true,
                'message' => 'Draft formulir anak berhasil disimpan.',
                'uid' => $uidCalonSiswa,
            ]);
        });
    }
    private function generateNoPendaftar(int $uidCalonSiswa): string
    {
        return 'REG-' . now()->format('Ymd') . '-' . str_pad($uidCalonSiswa, 5, '0', STR_PAD_LEFT);
    }

    private function getOrangTua()
    {
        $user = Auth::user();

        if (!$user) {
            return null;
        }

        if (session()->has('uid_orangtua')) {
            $orangTua = DB::table('orang_tua')->where('uid', session('uid_orangtua'))->first();
            if ($orangTua) {
                return $orangTua;
            }
        }

        if (Schema::hasColumn('orang_tua', 'user_id')) {
            return DB::table('orang_tua')->where('user_id', $user->id)->first();
        }

        return DB::table('orang_tua')->where('nama', $user->name)->first();
    }
}
