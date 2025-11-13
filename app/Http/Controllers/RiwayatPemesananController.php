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
            return redirect()->back()->with('success', 'Barang telah selesai dan dihapus dari daftar.');
        }

        $riwayat->status = $request->status;
        $riwayat->save();

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }

    // 🔥 Tambahan untuk hapus banyak data sekaligus
    public function destroyMultiple(Request $request)
    {
        $ids = $request->input('selected');
        if ($ids) {
            RiwayatPemesananUlang::whereIn('id', $ids)->delete();
            return redirect()->back()->with('success', 'Data terpilih berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Tidak ada data yang dipilih.');
    }
}
