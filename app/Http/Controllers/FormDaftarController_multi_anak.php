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
            $pendaftaran = DB::table('pendaftaran')
                ->where('calon_siswa_id', $draft->uid)
                ->first();

            if ($pendaftaran) {
                $berkas = DB::table('berkas')
                    ->where('id_pendaftar', $pendaftaran->uid)
                    ->get()
                    ->keyBy('jenis_berkas');
            }
        }

        return view('dashboard_user.form_daftar', compact('draft', 'berkas', 'orangTua'));
    }

    public function store(Request $request)
    {
        $orangTua = $this->getOrangTua();

        if (!$orangTua) {
            return redirect()->route('profil.ortu')
                ->with('warning', 'Lengkapi profil orang tua terlebih dahulu.');
        }

        $validated = $request->validate([
            'anak' => 'required|array|min:1|max:5',

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
            'anak.*.surat_baptis' => 'nullable|required_if:anak.*.agama,katolik|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'anak.required' => 'Minimal harus ada 1 data anak.',
            'anak.max' => 'Maksimal data anak adalah 5.',
            'anak.*.nik.digits' => 'NIK wajib berisi tepat 16 digit.',

            'anak.*.kartu_keluarga.required' => 'Kartu Keluarga wajib diupload.',
            'anak.*.kartu_keluarga.mimes' => 'Format Kartu Keluarga harus JPG, JPEG, PNG, atau PDF.',

            'anak.*.akte_kelahiran.required' => 'Akte Kelahiran wajib diupload.',
            'anak.*.akte_kelahiran.mimes' => 'Format Akte Kelahiran harus JPG, JPEG, PNG, atau PDF.',

            'anak.*.ktp_ortu.required' => 'E-KTP Orang Tua wajib diupload.',
            'anak.*.ktp_ortu.mimes' => 'Format E-KTP Orang Tua harus JPG, JPEG, PNG, atau PDF.',

            'anak.*.pas_foto.required' => 'Pas Foto wajib diupload.',
            'anak.*.pas_foto.mimes' => 'Format Pas Foto harus JPG, JPEG, atau PNG.',

            'anak.*.surat_baptis.required_if' => 'Surat Baptis wajib diupload jika agama Katolik.',
            'anak.*.surat_baptis.mimes' => 'Format Surat Baptis harus JPG, JPEG, PNG, atau PDF.',

            '*.required' => 'Field wajib belum lengkap.',
            '*.max' => 'Ukuran berkas maksimal 2 MB.',
        ]);

        return DB::transaction(function () use ($request, $validated, $orangTua) {
            $batchId = $this->getBatchPendaftaranId();
            $savedCount = 0;

            foreach ($validated['anak'] as $index => $anak) {
                $existingSiswa = DB::table('calon_siswa')
                    ->where('nik', $anak['nik'])
                    ->lockForUpdate()
                    ->first();

                if ($existingSiswa) {
                    if ((int) $existingSiswa->uid_orangtua !== (int) $orangTua->uid) {
                        throw ValidationException::withMessages([
                            "anak.$index.nik" => 'NIK ini sudah digunakan pada akun orang tua lain.',
                        ]);
                    }

                    if ($existingSiswa->status !== 'draft') {
                        throw ValidationException::withMessages([
                            "anak.$index.nik" => 'NIK ini sudah pernah disubmit. Silakan cek halaman riwayat pendaftaran.',
                        ]);
                    }

                    $uidCalonSiswa = $existingSiswa->uid;
                    $noPendaftaran = $this->generateNoPendaftar($uidCalonSiswa);

                    DB::table('calon_siswa')
                        ->where('uid', $uidCalonSiswa)
                        ->update([
                            'nama' => $anak['nama_lengkap'],
                            'nik' => $anak['nik'],
                            'tanggal_lahir' => $anak['tanggal_lahir'],
                            'alamat' => $anak['alamat'],
                            'agama' => $anak['agama'],
                            'golongan_darah' => $anak['gol_darah'] ?? null,
                            'tempat_lahir' => $anak['tempat_lahir'],
                            'uid_orangtua' => $orangTua->uid,
                            'status' => 'pending',
                            'nomor_registrasi' => $noPendaftaran,
                            'updated_at' => now(),
                        ]);
                } else {
                    $uidCalonSiswa = DB::table('calon_siswa')->insertGetId([
                        'nama' => $anak['nama_lengkap'],
                        'nik' => $anak['nik'],
                        'tanggal_lahir' => $anak['tanggal_lahir'],
                        'alamat' => $anak['alamat'],
                        'agama' => $anak['agama'],
                        'golongan_darah' => $anak['gol_darah'] ?? null,
                        'tempat_lahir' => $anak['tempat_lahir'],
                        'uid_orangtua' => $orangTua->uid,
                        'status' => 'pending',
                        'nomor_registrasi' => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $noPendaftaran = $this->generateNoPendaftar($uidCalonSiswa);

                    DB::table('calon_siswa')
                        ->where('uid', $uidCalonSiswa)
                        ->update([
                            'nomor_registrasi' => $noPendaftaran,
                        ]);
                }

                $existingPendaftaran = DB::table('pendaftaran')
                    ->where('calon_siswa_id', $uidCalonSiswa)
                    ->lockForUpdate()
                    ->first();

                if ($existingPendaftaran) {
                    $uidPendaftaran = $existingPendaftaran->uid;
                    $noPendaftaran = $existingPendaftaran->no_pendaftaran ?: $noPendaftaran;

                    DB::table('pendaftaran')
                        ->where('uid', $uidPendaftaran)
                        ->update([
                            'no_pendaftaran' => $noPendaftaran,
                            'id_batch_pendaftaran' => $batchId,
                            'status_pendaftaran' => 'pending',
                            'tanggal_daftar' => now()->toDateString(),
                            'calon_siswa_id' => $uidCalonSiswa,
                        ]);
                } else {
                    $uidPendaftaran = DB::table('pendaftaran')->insertGetId([
                        'no_pendaftaran' => $noPendaftaran,
                        'id_batch_pendaftaran' => $batchId,
                        'status_pendaftaran' => 'pending',
                        'diverifikasi_oleh' => null,
                        'alasan_penolakan' => null,
                        'tanggal_daftar' => now()->toDateString(),
                        'calon_siswa_id' => $uidCalonSiswa,
                    ]);
                }

                $this->replaceBerkas($request, $uidPendaftaran, $index);
                $savedCount++;
            }

            return redirect()->route('dashboard')
                ->with('success', $savedCount . ' data anak berhasil dikirim dan sedang ditinjau admin.');
        });
    }

    private function replaceBerkas(Request $request, int $uidPendaftaran, int $index = 0): void
    {
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

        $folder = $this->buildBerkasFolder($uidPendaftaran);

        foreach ($files as $inputName => $jenisBerkas) {
            $fileKey = "anak.$index.$inputName";

            if (!$request->hasFile($fileKey)) {
                continue;
            }

            $file = $request->file($fileKey);
            $extension = strtolower($file->getClientOriginalExtension());

            $fileName = Str::slug($jenisBerkas)
                . '-'
                . now()->format('YmdHis')
                . '.'
                . $extension;

            $path = $file->storeAs($folder, $fileName, 'public');

            $this->compressImageIfNeeded($path);

            DB::table('berkas')->insert([
                'id_pendaftar' => $uidPendaftaran,
                'jenis_berkas' => $jenisBerkas,
                'file_url' => $path,
                'is_valid' => 0,
            ]);
        }
    }

    private function buildBerkasFolder(int $uidPendaftaran): string
    {
        $user = Auth::user();

        $userId = $user->id ?? 'guest';
        $userName = Str::slug($user->name ?? 'user');

        return "berkas/{$userId}-{$userName}/pendaftaran-{$uidPendaftaran}";
    }

    private function compressImageIfNeeded(string $relativePath): void
    {
        $absolutePath = storage_path('app/public/' . $relativePath);

        if (!file_exists($absolutePath) || !extension_loaded('gd')) {
            return;
        }

        $imageInfo = @getimagesize($absolutePath);

        if (!$imageInfo) {
            return;
        }

        [$width, $height] = $imageInfo;
        $mime = $imageInfo['mime'] ?? null;

        if (!in_array($mime, ['image/jpeg', 'image/png'])) {
            return;
        }

        $maxWidth = 1600;
        $maxHeight = 1600;
        $ratio = min($maxWidth / $width, $maxHeight / $height, 1);

        $newWidth = (int) round($width * $ratio);
        $newHeight = (int) round($height * $ratio);

        if ($mime === 'image/jpeg') {
            $source = imagecreatefromjpeg($absolutePath);
        } else {
            $source = imagecreatefrompng($absolutePath);
        }

        if (!$source) {
            return;
        }

        $canvas = imagecreatetruecolor($newWidth, $newHeight);

        if ($mime === 'image/png') {
            imagealphablending($canvas, false);
            imagesavealpha($canvas, true);
        }

        imagecopyresampled($canvas, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        if ($mime === 'image/jpeg') {
            imagejpeg($canvas, $absolutePath, 75);
        } else {
            imagepng($canvas, $absolutePath, 7);
        }

        imagedestroy($source);
        imagedestroy($canvas);
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
