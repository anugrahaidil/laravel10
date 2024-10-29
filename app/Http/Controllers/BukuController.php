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

    public function store(Request $request){
        $buku = new Buku();
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl_terbit;
        $buku->save();

        return redirect('/buku');
    }

    public function destroy($id){
        $buku = Buku::find($id);
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
        ]);
        
        $buku = Buku::findOrFail($id);
        $buku->update($validatedData);
        
        return redirect()->route('buku.index')->with('success', 'Data buku berhasil diperbarui');
    }

}

