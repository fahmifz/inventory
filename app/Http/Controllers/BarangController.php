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

        $barang = $barang->filter(function ($b) {
            return $b->jumlah_stok > $b->rop;
        });

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

    public function restok(Request $request)
    {
        $search = $request->search;

        // Ambil semua barang + search
        $barang = Barang::when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'LIKE', "%$search%")
                ->orWhere('kategori', 'LIKE', "%$search%");
            });
        })->get();

        // Hitung ROP
        foreach ($barang as $b) {
            $b->rop = $b->hitungROP();
        }

        // FILTER: barang perlu restock
        $restok = $barang->filter(function ($b) {
            return $b->jumlah_stok <= $b->rop;
        });

        return view('pages.admin.barang.restok', compact('restok'));
    }

    public function prosesRestok(Request $request, $id)
    {
        $request->validate([
            'jumlah_restok' => 'required|integer|min:1'
        ]);

        $barang = Barang::findOrFail($id);

        $barang->jumlah_stok += $request->jumlah_restok;
        $barang->save();

        return redirect()
            ->route('admin.restok')
            ->with('success', 'Stok berhasil direstok');
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
