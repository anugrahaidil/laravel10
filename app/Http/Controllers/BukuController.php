<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{
    public function index (){

        $data_buku = Buku::all();

        $jumlah_buku = $data_buku->count();

        $total_harga = $data_buku->sum('harga');

        return view('buku.index', compact('data_buku', 'jumlah_buku', 'total_harga'));
    }

    public function create(){
        return view('buku.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'penulis' => 'required|max:255',
            'harga' => 'required|numeric',
            'tgl_terbit' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ]);

        $buku = new Buku();
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl_terbit;

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename); // Simpan gambar ke folder `public/images`
            $buku->gambar = $filename;
        }

        $buku->save();
        return redirect('/buku');
    }


    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);

        // Hapus gambar jika ada
        if ($buku->gambar && file_exists(public_path('images/' . $buku->gambar))) {
            unlink(public_path('images/' . $buku->gambar));
        }

        $buku->delete();
        return redirect('/buku');
    }


    public function edit($id){
        $buku = Buku::findOrFail($id);

        return view('buku.edit', compact('buku'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'judul' => 'required|max:255',
            'penulis' => 'required|max:255',
            'harga' => 'required|numeric',
            'tgl_terbit' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ]);

        $buku = Buku::findOrFail($id);

        $buku->judul = $validatedData['judul'];
        $buku->penulis = $validatedData['penulis'];
        $buku->harga = $validatedData['harga'];
        $buku->tgl_terbit = $validatedData['tgl_terbit'];

        if ($request->hasFile('gambar')) {
            if ($buku->gambar && file_exists(public_path('images/' . $buku->gambar))) {
                unlink(public_path('images/' . $buku->gambar));
            }
            $file = $request->file('gambar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $buku->gambar = $filename;
        }

        // Simpan perubahan
        $buku->save();

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil diperbarui');
    }


}

