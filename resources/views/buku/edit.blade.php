@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h4>Edit Buku</h4>
        <form method="post" action="{{ route('buku.update', $buku->id) }}">
            @csrf
            <div class="form-group">
                <label>Judul</label>
                <input type="text" name="judul" value="{{ $buku->judul }}" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Penulis</label>
                <input type="text" name="penulis" value="{{ $buku->penulis }}" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="harga" value="{{ $buku->harga }}" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Tanggal Terbit</label>
                <input type="date" name="tgl_terbit" value="{{ $buku->tgl_terbit }}" class="form-control" required>
            </div>
            <div class="form-group mt-3">
                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                <a href="{{ route('buku.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
@endsection
