<?php

namespace App\Http\Controllers;

use App\Services\OrangTuaResolver;
use Illuminate\Support\Facades\DB;

class VerifikasiBerkasController extends Controller
{
    public function show($uid)
    {
        $orangTua = app(OrangTuaResolver::class)->current();

        abort_unless(
            $orangTua,
            404,
            'Profil orang tua tidak ditemukan.'
        );

        $siswa = DB::table('calon_siswa as cs')
            ->join(
                'pendaftaran as p',
                'p.calon_siswa_id',
                '=',
                'cs.uid'
            )
            ->where('p.uid', $uid)
            ->where('cs.uid_orangtua', $orangTua->uid)
            ->select([
                'cs.*',
                'p.uid as pendaftaran_uid',
                'p.no_pendaftaran',
                'p.status_pendaftaran',
                'p.jenis_penolakan',
                'p.alasan_penolakan',
                DB::raw(
                    'COALESCE(p.status_pendaftaran, cs.status) as status'
                ),
            ])
            ->first();

        abort_unless(
            $siswa,
            404,
            'Data calon siswa tidak ditemukan.'
        );

        $berkas = DB::table('berkas')
            ->where('id_pendaftar', $uid)
            ->orderBy('uid')
            ->get();

        return view(
            'dashboard_user.verifikasi_berkas',
            compact('siswa', 'berkas')
        );
    }
}