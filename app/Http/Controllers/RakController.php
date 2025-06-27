<?php

namespace App\Http\Controllers;

use App\Models\Rak;
use Illuminate\Http\Request;

class RakController extends Controller
{
       public function rak()
       {
          $rak = Rak::with('barangs')->get();
          return view('pages.admin.Rak.index', compact('rak'));
       }


        public function create()
        {
            return view('pages.admin.Rak.create');
        }

        public function createproses(Request $request) {
            
    $request->validate([
        'rak' => 'required',
        'kategori' => 'required',
        'kapasitas' => 'required|integer|min:1',
    ]);

    Rak::create([
        'rak' => $request->rak,
        'kategori' => $request->kategori,
        'kapasitas' => $request->kapasitas,
        ]);

    return redirect()->route('admin.rak')->with('success', 'Data barang berhasil ditambahkan.');
}

    public function edit($id) 
    {
        $r = Rak::findOrFail($id); // ambil data barang berdasarkan ID
        return view('pages.admin.Rak.edit', compact('r'));
    }

   public function update(Request $request, $id)
{
    $request->validate([
        'rak' => 'required',
        'kategori' => 'required',
        'kapasitas' => 'required|integer|min:1',
        ]);

    $barang = Rak::findOrFail($id);
    $barang->update([
        'rak' => $request->rak,
        'kategori' => $request->kategori,
        'kapasitas' => $request->kapasitas,
        ]);

    return redirect()->route('admin.rak')->with('success', 'Data barang berhasil diupdate.');
}

public function hapus($id)
{
    $rak = Rak::findOrFail($id);
    $rak->delete();

    return redirect()->route('admin.rak')->with('success', 'Data berhasil dihapus');
}
}
