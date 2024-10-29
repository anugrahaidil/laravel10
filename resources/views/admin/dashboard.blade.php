@extends('auth.layouts')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">Admin Dashboard</div>
                <div class="card-body">
                    <div class="alert alert-success">
                        Welcome, {{ Auth::user()->name }}! You are logged in as an Admin.
                    </div>

                    <!-- Tombol Lihat Data Buku -->
                    <a href="{{ route('buku.index') }}" class="btn btn-info mt-3">Lihat Data Buku</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
