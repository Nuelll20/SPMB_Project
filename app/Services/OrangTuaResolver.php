<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrangTuaResolver
{
    public function current(): ?object
    {
        $orangTua = Auth::check()
            ? DB::table('orang_tua')
                ->where('user_id', Auth::id())
                ->first()
            : null;

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