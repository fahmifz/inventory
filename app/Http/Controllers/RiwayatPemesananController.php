<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPemesananUlang;
use Illuminate\Http\Request;

class RiwayatPemesananController extends Controller
{
    public function index()
    {
        $riwayats = RiwayatPemesananUlang::with('barang')->latest()->get();
        return view('pages.admin.pemesananulang.rop', compact('riwayats'));
    }

    public function updateStatus(Request $request, $id)
    {
        $riwayat = RiwayatPemesananUlang::findOrFail($id);
        $riwayat->status = $request->status;
        $riwayat->save();

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }
}
