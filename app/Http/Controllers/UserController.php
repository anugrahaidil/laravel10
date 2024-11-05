<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\File;


class UserController extends Controller
{
    public function index()
    {
        if (!Auth::check()){
            return redirect ()->route('login')
                ->withErrors([
                    'email' => 'Please login to access the dashboard.',
                ])->onlyInput('email');
        }
        $users = User::get();
        return view('users')->with('userss', $users);
    }

    public function destroy(string $id)
    {
        // Cari data pengguna berdasarkan ID
        $user = User::find($id);

        // Buat path ke file gambar di folder publik
        $file = public_path('storage/' . $user->photo);

        try {
            // Cek apakah file ada di lokasi penyimpanan
            if (File::exists($file)) { 
                File::delete($file); // Hapus file dari penyimpanan
            }

            // Hapus data pengguna dari database
            $user->delete();

            return redirect('user')->with('success', 'Berhasil hapus data');
        } catch (\Throwable $th) {
            return redirect('user')->with('error', 'Gagal hapus data');
        }
    }

}
