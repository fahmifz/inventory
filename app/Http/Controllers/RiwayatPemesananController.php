<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPemesananUlang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatPemesananController extends Controller
{
    public function index()
    {
        $riwayats = RiwayatPemesananUlang::with('barang')
            ->latest()
            ->get();

        return view('pages.admin.pemesananulang.rop', compact('riwayats'));
    }

    public function updateStatus(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('admin.riwayat')
                ->with('error', 'Anda tidak memiliki izin mengubah status.');
        }

        $request->validate([
            'status' => 'required|in:pending,diproses,selesai'
        ]);

        $riwayat = RiwayatPemesananUlang::findOrFail($id);

        if ($request->status === 'selesai') {
            $riwayat->delete();

            return redirect()->route('admin.riwayat')
                ->with('success', 'Barang selesai dan dihapus dari daftar.');
        }

        $riwayat->update([
            'status' => $request->status
        ]);

        return redirect()->route('admin.riwayat')
            ->with('success', 'Status berhasil diperbarui.');
    }
}