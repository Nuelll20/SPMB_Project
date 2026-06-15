<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
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
        $orangTua = $this->getOrangTua();

        if (!$orangTua) {
            return redirect()->route('profil.ortu')
                ->with('warning', 'Lengkapi profil orang tua terlebih dahulu.');
        }

        $validated = $request->validate([
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
            'surat_baptis' => 'nullable|required_if:agama,katolik|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'nik.digits' => 'NIK wajib berisi tepat 16 digit.',

            'kartu_keluarga.required' => 'Kartu Keluarga wajib diupload.',
            'kartu_keluarga.mimes' => 'Format Kartu Keluarga harus JPG, JPEG, PNG, atau PDF.',

            'akte_kelahiran.required' => 'Akte Kelahiran wajib diupload.',
            'akte_kelahiran.mimes' => 'Format Akte Kelahiran harus JPG, JPEG, PNG, atau PDF.',

            'ktp_ortu.required' => 'E-KTP Orang Tua wajib diupload.',
            'ktp_ortu.mimes' => 'Format E-KTP Orang Tua harus JPG, JPEG, PNG, atau PDF.',

            'pas_foto.required' => 'Pas Foto wajib diupload.',
            'pas_foto.mimes' => 'Format Pas Foto harus JPG, JPEG, atau PNG.',

            'surat_baptis.required_if' => 'Surat Baptis wajib diupload jika agama Katolik.',
            'surat_baptis.mimes' => 'Format Surat Baptis harus JPG, JPEG, PNG, atau PDF.',

            '*.required' => 'Field wajib belum lengkap.',
            '*.max' => 'Ukuran berkas maksimal 2 MB.',
        ]);

        return DB::transaction(function () use ($request, $validated, $orangTua) {
            $batchId = $this->getBatchPendaftaranId();

            $existingSiswa = DB::table('calon_siswa')
                ->where('nik', $validated['nik'])
                ->lockForUpdate()
                ->first();

            if ($existingSiswa) {
                if ((int) $existingSiswa->uid_orangtua !== (int) $orangTua->uid) {
                    throw ValidationException::withMessages([
                        'nik' => 'NIK ini sudah digunakan pada akun orang tua lain.',
                    ]);
                }

                if ($existingSiswa->status !== 'draft') {
                    throw ValidationException::withMessages([
                        'nik' => 'NIK ini sudah pernah disubmit. Silakan cek halaman riwayat pendaftaran.',
                    ]);
                }

                $uidCalonSiswa = $existingSiswa->uid;
                $noPendaftar = $this->generateNoPendaftar($uidCalonSiswa);

                DB::table('calon_siswa')
                    ->where('uid', $uidCalonSiswa)
                    ->update([
                        'nama' => $validated['nama_lengkap'],
                        'nik' => $validated['nik'],
                        'tanggal_lahir' => $validated['tanggal_lahir'],
                        'alamat' => $validated['alamat'],
                        'agama' => $validated['agama'],
                        'golongan_darah' => $validated['gol_darah'] ?? null,
                        'tempat_lahir' => $validated['tempat_lahir'],
                        'uid_orangtua' => $orangTua->uid,
                        'status' => 'pending',
                        'nomor_registrasi' => $noPendaftar,
                        'updated_at' => now(),
                    ]);
            } else {
                $uidCalonSiswa = DB::table('calon_siswa')->insertGetId([
                    'nama' => $validated['nama_lengkap'],
                    'nik' => $validated['nik'],
                    'tanggal_lahir' => $validated['tanggal_lahir'],
                    'alamat' => $validated['alamat'],
                    'agama' => $validated['agama'],
                    'golongan_darah' => $validated['gol_darah'] ?? null,
                    'tempat_lahir' => $validated['tempat_lahir'],
                    'uid_orangtua' => $orangTua->uid,
                    'status' => 'pending',
                    'nomor_registrasi' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $noPendaftar = $this->generateNoPendaftar($uidCalonSiswa);

                DB::table('calon_siswa')
                    ->where('uid', $uidCalonSiswa)
                    ->update([
                        'nomor_registrasi' => $noPendaftar,
                    ]);
            }

            $existingPendaftaran = DB::table('pendaftaran')
                ->where('calon_siswa_id', $uidCalonSiswa)
                ->lockForUpdate()
                ->first();

            if ($existingPendaftaran) {
                $uidPendaftaran = $existingPendaftaran->uid;
                $noPendaftar = $existingPendaftaran->no_pendaftaran ?: $noPendaftar;

                DB::table('pendaftaran')
                    ->where('uid', $uidPendaftaran)
                    ->update([
                        'no_pendaftaran' => $noPendaftar,
                        'id_batch_pendaftaran' => $batchId,
                        'status_pendaftaran' => 'pending',
                        'tanggal_daftar' => now()->toDateString(),
                        'calon_siswa_id' => $uidCalonSiswa,
                    ]);
            } else {
                $uidPendaftaran = DB::table('pendaftaran')->insertGetId([
                    'no_pendaftaran' => $noPendaftar,
                    'id_batch_pendaftaran' => $batchId,
                    'status_pendaftaran' => 'pending',
                    'diverifikasi_oleh' => null,
                    'alasan_penolakan' => null,
                    'tanggal_daftar' => now()->toDateString(),
                    'calon_siswa_id' => $uidCalonSiswa,
                ]);
            }

            $this->replaceBerkas($request, $uidPendaftaran);

            return redirect()->route('dashboard')
                ->with('success', 'Pendaftaran berhasil dikirim dan sedang ditinjau admin.');
        });
    }

    private function replaceBerkas(Request $request, int $uidPendaftaran): void
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

        foreach ($files as $inputName => $jenisBerkas) {
            if (!$request->hasFile($inputName)) {
                continue;
            }

            $path = $request->file($inputName)->store('berkas', 'public');

            DB::table('berkas')->insert([
                'id_pendaftar' => $uidPendaftaran,
                'jenis_berkas' => $jenisBerkas,
                'file_url' => $path,
                'is_valid' => 0,
            ]);
        }
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
