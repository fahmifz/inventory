<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Rak;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    // Controller Dashboard
    public function index()
    {
        $barang = Barang::all();
        $totalbarang = Barang::count();
        $totalrak = Rak::count();
            
        $data = [
            'totalbarang' => $totalbarang,
            'totalrak' => $totalrak,
        ];
        return view('pages.admin.dashboard.index', compact('barang','data'));
    }

    public function barang()
    {
        $barang = Barang::with('rak')->get();
        return view('pages.admin.barang.index', compact('barang'));
    }

    public function create()
    {
        $raks = Rak::with('barangs')->get();
        return view('pages.admin.barang.create', compact('raks'));
    }

    public function createproses(Request $request)
    {
        $validatedData = $this->validateBarang($request);
        
        if ((int)$validatedData['kondisi_baik'] + (int)$validatedData['kondisi_buruk'] !== (int)$validatedData['jumlah_stok']) {
        return back()->withErrors(['jumlah_stok' => 'Jumlah kondisi harus sama dengan total stok'])->withInput();
    }



        // VALIDASI KAPASITAS RAK
        if (!$this->cekKapasitasRak($validatedData['rak_id'], $validatedData['jumlah_stok'])) {
            $rak = Rak::findOrFail($validatedData['rak_id']);
            return back()->withErrors([
                'jumlah_stok' => 'Rak melebihi kapasitas. Maksimal kapasitas: ' . $rak->kapasitas
            ])->withInput();
        }

        Barang::create($validatedData);
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
        $validatedData = $this->validateBarang($request);

        if ((int)$validatedData['kondisi_baik'] + (int)$validatedData['kondisi_buruk'] !== (int)$validatedData['jumlah_stok']) {
        return back()->withErrors(['jumlah_stok' => 'Jumlah kondisi harus sama dengan total stok'])->withInput();
    }


        $barang = Barang::findOrFail($id);

        // VALIDASI KAPASITAS SAAT UPDATE
        if (!$this->cekKapasitasRakUpdate($validatedData['rak_id'], $validatedData['jumlah_stok'], $barang)) {
            $rak = Rak::findOrFail($validatedData['rak_id']);
            return back()->withErrors([
                'jumlah_stok' => 'Rak melebihi kapasitas. Maksimal kapasitas: ' . $rak->kapasitas
            ])->withInput();
        }

        $barang->update($validatedData);
        return redirect()->route('admin.barang')->with('success', 'Data barang berhasil diupdate.');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();
        return redirect()->route('admin.barang')->with('success', 'Data berhasil dihapus.');
    }

    private function validateBarang(Request $request)
    {
        return $request->validate([
            'nama_barang' => 'required|string',
            'jumlah_stok' => 'required|integer|min:1',
            'harga_satuan' => 'required|integer|min:1',
            'kategori' => 'required|string',
            'kondisi_baik' => 'required|integer|min:0',
            'kondisi_buruk' => 'required|integer|min:0',
            'satuan' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'rak_id' => 'required|exists:raks,id',
        ], [
            'kondisi_buruk.min' => 'Kondisi buruk minimal 0.',
            'kondisi_baik.min' => 'Kondisi baik minimal 0.',
            'jumlah_stok.min' => 'Jumlah stok minimal 1.',
            'harga_satuan.min' => 'Harga tidak boleh 0 atau negatif.',
        ]);
    }

    // FUNCTION VALIDASI PENAMBAHAN
    private function cekKapasitasRak($rak_id, $jumlah_stok_baru)
    {
        $rak = Rak::findOrFail($rak_id);
        $total_terisi = Barang::where('rak_id', $rak_id)->sum('jumlah_stok');
        $total_setelah_input = $total_terisi + $jumlah_stok_baru;

        return $total_setelah_input <= $rak->kapasitas;
    }

    // FUNCTION VALIDASI SAAT UPDATE
    private function cekKapasitasRakUpdate($rak_id, $jumlah_baik_baru, $barang_lama)
    {
        $rak = Rak::findOrFail($rak_id);
        $total_terisi = Barang::where('rak_id', $rak_id)->sum('jumlah_stok');

        // Saat update, kurangi stok lama, tambahkan stok baru
        $total_setelah_update = ($total_terisi - $barang_lama->kondisi_baik) + $jumlah_baik_baru;

        return $total_setelah_update <= $rak->kapasitas;
    }
}
