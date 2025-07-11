<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->isProfileComplete()) {
            return redirect()->route('portofolios.index')->with('error', 'Lengkapi data diri Anda sebelum bertransaksi.');
        }
        // ...lanjutkan proses transaksi...
    }
}