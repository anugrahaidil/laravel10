@extends('auth.layouts')
@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Gallery</span>
                <!-- Tambahkan tombol "Upload Gambar Baru" -->
                <a href="{{ route('gallery.create') }}" class="btn btn-primary btn-sm">Upload Gambar Baru</a>
            </div>
            <div class="card-body">
                <div class="row">
                    @if(!empty($galleries) && count($galleries) > 0)
                        @foreach($galleries as $gallery)
                            <div class="col-sm-4 mb-4">
                                <div class="card">
                                    <a href="{{ asset('storage/posts_image/' . $gallery['picture']) }}" data-lightbox="roadtrip" data-title="{{ $gallery['description'] }}">
                                        <img src="{{ asset('storage/posts_image/' . $gallery['picture']) }}" alt="Gallery Image" class="card-img-top img-fluid">
                                    </a>
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $gallery['title'] }}</h5>
                                        <p class="card-text">{{ $gallery['description'] }}</p>
                                        
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('gallery.edit', $gallery['id']) }}" class="btn btn-warning btn-sm">Edit</a>
                                        
                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('gallery.destroy', $gallery['id']) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus gambar ini?')">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h3>Tidak ada data</h3>
                    @endif
                </div>
                <!-- Pagination -->
                @if(!empty($galleries))
                    <div class="d-flex justify-content-center mt-3">
                        {{-- Tambahkan link ke API pagination di sini jika diperlukan --}}
                        {{-- Implementasi pagination manual jika tidak didukung --}}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
