<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrangTuaResolver
{
    public function current(): ?object
    {
        if (! Auth::check()) {
            session()->forget('uid_orangtua');

            return null;
        }

        $query = DB::table('orang_tua')
            ->where('user_id', Auth::id());

        $sessionUid = session('uid_orangtua');

        $orangTua = $sessionUid
            ? (clone $query)
                ->where('uid', $sessionUid)
                ->first()
            : null;

        if (! $orangTua) {
            $orangTua = (clone $query)
                ->orderByDesc('uid')
                ->first();
        }

        if ($orangTua) {
            session([
                'uid_orangtua' => $orangTua->uid,
            ]);
        } else {
            session()->forget('uid_orangtua');
        }

        return $orangTua;
    }
}