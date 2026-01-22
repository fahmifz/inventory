<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Rak;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * TAMPIL DATA BARANG + STATUS ROP
     */
    public function barang(Request $request)
{
    // barang dengan fitur pencarian
    $search = $request->search;

    $barang = Barang::when($search, function ($query) use ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('nama_barang', 'LIKE', "%$search%")
              ->orWhere('kategori', 'LIKE', "%$search%")
              ->orWhere('harga_satuan', 'LIKE', "%$search%")
              ->orWhere('satuan', 'LIKE', "%$search%");
        });
    })->get();

    foreach ($barang as $b) {
        $b->rop = $b->hitungROP();
    }

    return view('pages.admin.barang.index', compact('barang'));
}
    /**
     * FORM TAMBAH BARANG
     */
    public function createbarang()
    {
        $raks = Rak::all();
        return view('pages.admin.barang.create', compact('raks'));
    }

    /**
     * PROSES SIMPAN BARANG
     */
    public function createproses(Request $request)
    {
        $request->validate([
            'nama_barang'   => 'required|string',
            'jumlah_stok'   => 'required|integer|min:1',
            'harga_satuan'  => 'required|integer|min:1',
            'kategori'      => 'required|string',
            'satuan'        => 'required|string',
            'lead_time'     => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
            'rak_id'        => 'required|exists:raks,id',
        ]);

        // VALIDASI KAPASITAS RAK
        $total_terisi = Barang::where('rak_id', $request->rak_id)->sum('jumlah_stok');
        $kapasitas = Rak::findOrFail($request->rak_id)->kapasitas;

        if (($total_terisi + $request->jumlah_stok) > $kapasitas) {
            return back()
                ->withErrors(['jumlah_stok' => 'Kapasitas rak tidak mencukupi'])
                ->withInput();
        }

        Barang::create($request->all());

        return redirect()->route('admin.barang')->with('success', 'Data barang berhasil ditambahkan.');
    }

    /**
     * FORM EDIT BARANG
     */
    public function edit($id)
    {
        $b = Barang::findOrFail($id);
        $rak = Rak::all();
        return view('pages.admin.barang.edit', compact('b', 'rak'));
    }

    /**
     * PROSES UPDATE BARANG
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang'   => 'required|string',
            'jumlah_stok'   => 'required|integer|min:1',
            'harga_satuan'  => 'required|integer|min:1',
            'kategori'      => 'required|string',
            'satuan'        => 'required|string',
            'lead_time'     => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
            'rak_id'        => 'required|exists:raks,id',
        ]);
        
        $barang = Barang::findOrFail($id);
        $rak_baru = Rak::findOrFail($request->rak_id);

        // VALIDASI KAPASITAS RAK SAAT UPDATE
        if ($barang->rak_id == $request->rak_id) {
            $total_terisi = Barang::where('rak_id', $request->rak_id)->sum('jumlah_stok')
                             - $barang->jumlah_stok;
        } else {
            $total_terisi = Barang::where('rak_id', $request->rak_id)->sum('jumlah_stok');
        }

        if (($total_terisi + $request->jumlah_stok) > $rak_baru->kapasitas) {
            return back()
                ->withErrors(['jumlah_stok' => 'Kapasitas rak tidak mencukupi'])
                ->withInput();
        }

        $barang->update($request->all());

        return redirect()
            ->route('admin.barang')
            ->with('success', 'Data barang berhasil diupdate.');
    }

    /**
     * HAPUS BARANG
     */
    public function destroy($id)
    {
        Barang::findOrFail($id)->delete();

        return redirect()
            ->route('admin.barang')
            ->with('success', 'Data berhasil dihapus.');
    }
}
