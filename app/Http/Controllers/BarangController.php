<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Rak;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function barang(Request $request)
    {
        $barang = Barang::with('rak')->get();
        return view('pages.admin.barang.index', compact('barang'));
    }

    public function createbarang()
    {
        $raks = Rak::all();
        return view('pages.admin.barang.create', compact('raks'));
    }

    public function createproses(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string',
            'jumlah_stok' => 'required|integer|min:1',
            'harga_satuan' => 'required|integer|min:1',
            'kategori' => 'required|string',
            'satuan' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'rak_id' => 'required|exists:raks,id',
        ]);

       
        // Validasi kapasitas rak
        $total_terisi = Barang::where('rak_id', $request->rak_id)->sum('jumlah_stok');
        $kapasitas = Rak::findOrFail($request->rak_id)->kapasitas;

        if (($total_terisi + $request->jumlah_stok) > $kapasitas) {
            return back()->withErrors(['jumlah_stok' => 'Kapasitas rak tidak mencukupi'])->withInput();
        }

        Barang::create($request->all());
        return redirect()->route('admin.barang')->with('success', 'Data barang berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $b = Barang::findOrFail($id);
        $rak = Rak::all();
        return view('pages.admin.barang.edit', compact('b', 'rak'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string',
            'jumlah_stok' => 'required|integer|min:1',
            'harga_satuan' => 'required|integer|min:1',
            'kategori' => 'required|string',
            'satuan' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'rak_id' => 'required|exists:raks,id',
        ]);

        $barang = Barang::findOrFail($id);
        $rak_baru = Rak::findOrFail($request->rak_id);

        // Validasi kapasitas saat update
        if ($barang->rak_id == $request->rak_id) {
            $total_terisi = Barang::where('rak_id', $request->rak_id)->sum('jumlah_stok');
            $total_terisi -= $barang->jumlah_stok; // kurangi stok lama
        } else {
            $total_terisi = Barang::where('rak_id', $request->rak_id)->sum('jumlah_stok');
        }

        if (($total_terisi + $request->jumlah_stok) > $rak_baru->kapasitas) {
            return back()->withErrors(['jumlah_stok' => 'Kapasitas rak tidak mencukupi'])->withInput();
        }

        $barang->update($request->all());
        return redirect()->route('admin.barang')->with('success', 'Data barang berhasil diupdate.');
    }


    public function hapus($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();
        return redirect()->route('admin.barang')->with('success', 'Data berhasil dihapus.');
    }
}
