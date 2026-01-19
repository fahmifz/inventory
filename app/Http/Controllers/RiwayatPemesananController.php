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

        if ($request->status === 'selesai') {
            $riwayat->delete();
            return redirect()->back()->with('success', 'Barang selesai dan dihapus dari daftar.');
        }

        $riwayat->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }
}
