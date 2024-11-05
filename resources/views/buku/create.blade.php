@extends('auth.layouts')

@section('content')
    <div>
        <h4>Tambah Buku</h4>
        <form method="post" action="{{route('buku.store')}}" enctype="multipart/form-data">
            @csrf
            <div>Judul <input type="text" name="judul"></div>
            <div>Penulis <input type="text" name="penulis"></div>
            <div>Harga <input type="text" name="harga"></div>
            <div>Tanggal Terbit <input type="date" name="tgl_terbit"></div>
            <div class="form-group">
                <label>Gambar</label>
                <input type="file" name="gambar" class="form-control">
            </div>
            <div><button type="submit">Simpan</button>
            <a href="{{'/buku'}}">Kembali</a></div>
        </form>
    </div>
@endsection    

