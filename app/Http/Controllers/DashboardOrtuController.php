<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardOrtuController extends Controller
{
    public function index()
    {
        $orangTua = $this->getOrangTua();

        if (! $orangTua) {
            return redirect()->route('profil.ortu')
                ->with('warning', 'Lengkapi profil orang tua terlebih dahulu.');
        }

        session(['uid_orangtua' => $orangTua->uid]);

        $hasTagihan = Schema::hasTable('tagihan');
        $hasKomponenTagihan = Schema::hasTable('komponen_tagihan');
        $hasJenisPenolakan = Schema::hasColumn('pendaftaran', 'jenis_penolakan');
        $hasDisetujuiOleh = $hasTagihan && Schema::hasColumn('tagihan', 'disetujui_oleh');

        $select = [
            'cs.*',
            'p.uid as pendaftaran_uid',
            'p.uid as uid_pendaftaran',
            'p.no_pendaftaran',
            'p.status_pendaftaran',
            'p.alasan_penolakan',
            DB::raw('COALESCE(p.status_pendaftaran, cs.status) as status'),
        ];

        $select[] = $hasJenisPenolakan
            ? 'p.jenis_penolakan'
            : DB::raw('NULL as jenis_penolakan');

        if ($hasTagihan) {
            $select = array_merge($select, [
                't.uid as tagihan_uid',
                't.nomor_tagihan',
                't.subtotal_tagihan',
                't.diskon_tagihan',
                't.total_tagihan',
                't.status_tagihan',
                't.tanggal_tagihan',
                't.dibuat_oleh as tagihan_dibuat_oleh',
            ]);

            $select[] = $hasDisetujuiOleh
                ? 't.disetujui_oleh as tagihan_disetujui_oleh'
                : DB::raw('NULL as tagihan_disetujui_oleh');
        } else {
            $select = array_merge($select, [
                DB::raw('NULL as tagihan_uid'),
                DB::raw('NULL as nomor_tagihan'),
                DB::raw('0 as subtotal_tagihan'),
                DB::raw('0 as diskon_tagihan'),
                DB::raw('0 as total_tagihan'),
                DB::raw('NULL as status_tagihan'),
                DB::raw('NULL as tanggal_tagihan'),
                DB::raw('NULL as tagihan_dibuat_oleh'),
                DB::raw('NULL as tagihan_disetujui_oleh'),
            ]);
        }

        $query = DB::table('calon_siswa as cs')
            ->leftJoin('pendaftaran as p', 'p.calon_siswa_id', '=', 'cs.uid')
            ->where('cs.uid_orangtua', $orangTua->uid);

        if ($hasTagihan) {
            $query->leftJoin('tagihan as t', 't.uid_pendaftaran', '=', 'p.uid');
        }

        $dataSiswa = $query
            ->select($select)
            ->orderByDesc('cs.uid')
            ->get();

        $komponenByTagihan = collect();

        if ($hasTagihan && $hasKomponenTagihan) {
            $tagihanIds = $dataSiswa
                ->pluck('tagihan_uid')
                ->filter()
                ->unique()
                ->values();

            if ($tagihanIds->isNotEmpty()) {
                $komponenByTagihan = DB::table('komponen_tagihan')
                    ->whereIn('uid_tagihan', $tagihanIds)
                    ->orderBy('urutan')
                    ->get()
                    ->groupBy('uid_tagihan');
            }
        }

        $dataSiswa = $dataSiswa->map(function ($siswa) use ($komponenByTagihan) {
            $siswa->komponen_tagihan = $komponenByTagihan
                ->get($siswa->tagihan_uid, collect())
                ->values();

            return $siswa;
        });

        $batch = DB::table('batch_pendaftaran')
            ->where('is_active', 1)
            ->orderByDesc('tanggal_buka')
            ->first();

        $jumlahPendaftar = 0;
        $sisaKuota = 0;
        $batchAktif = false;

        if ($batch) {
            $jumlahPendaftar = DB::table('pendaftaran')->count();

            $sisaKuota = max(0, (int) $batch->kuota - $jumlahPendaftar);
            $batchAktif = $sisaKuota > 0;
        }

        return view('dashboard_user.dashboard_ortu', compact(
            'dataSiswa',
            'orangTua',
            'batch',
            'sisaKuota',
            'batchAktif'
        ));
    }

    private function getOrangTua()
    {
        $user = Auth::user();

        if (! $user) {
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
