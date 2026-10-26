<?php

namespace App\Http\Controllers;

use App\Services\OrangTuaResolver;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BerkasController extends Controller
{
    public function validasi(int $id, int $status)
    {
        abort_unless(
            in_array($status, [0, 1], true),
            404
        );

        DB::transaction(function () use ($id, $status) {
            $berkas = DB::table('berkas')
                ->where('uid', $id)
                ->lockForUpdate()
                ->first();

            abort_unless(
                $berkas,
                404,
                'Berkas tidak ditemukan.'
            );

            if ((int) $berkas->is_valid !== $status) {
                DB::table('berkas')
                    ->where('uid', $id)
                    ->update([
                        'is_valid' => $status,
                    ]);
            }
        });

        return back()->with(
            'success',
            'Status berkas berhasil diupdate!'
        );
    }

    public function showForOrangTua(
        int $uid,
        ?string $filename = null
    ): StreamedResponse {
        $orangTua = app(OrangTuaResolver::class)->current();

        abort_unless(
            $orangTua,
            404,
            'Profil orang tua tidak ditemukan.'
        );

        $berkas = DB::table('berkas as b')
            ->join(
                'pendaftaran as p',
                'p.uid',
                '=',
                'b.id_pendaftar'
            )
            ->join(
                'calon_siswa as cs',
                'cs.uid',
                '=',
                'p.calon_siswa_id'
            )
            ->where('b.uid', $uid)
            ->where('cs.uid_orangtua', $orangTua->uid)
            ->select([
                'b.file_url',
                'b.jenis_berkas',
            ])
            ->first();

        abort_unless(
            $berkas,
            404,
            'Berkas tidak ditemukan.'
        );

        return $this->serve($berkas);
    }

    public function showForAdmin(
        int $uid,
        ?string $filename = null
    ): StreamedResponse {
        $berkas = DB::table('berkas')
            ->where('uid', $uid)
            ->select([
                'file_url',
                'jenis_berkas',
            ])
            ->first();

        abort_unless(
            $berkas,
            404,
            'Berkas tidak ditemukan.'
        );

        return $this->serve($berkas);
    }

    private function serve(object $berkas): StreamedResponse
    {
        $path = ltrim(
            str_replace('\\', '/', (string) $berkas->file_url),
            '/'
        );

        abort_if(
            $path === ''
            || str_contains($path, '..')
            || !str_starts_with($path, 'berkas/'),
            404
        );

        $disk = Storage::disk('local');

        abort_unless($disk->exists($path), 404);

        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $downloadName = Str::slug((string) $berkas->jenis_berkas);

        if ($downloadName === '') {
            $downloadName = 'berkas';
        }

        if ($extension !== '') {
            $downloadName .= '.' . strtolower($extension);
        }

        return $disk->response(
            $path,
            $downloadName,
            [
                'Cache-Control' => 'private, no-store, max-age=0',
                'Pragma' => 'no-cache',
                'X-Content-Type-Options' => 'nosniff',
            ]
        );
    }
}