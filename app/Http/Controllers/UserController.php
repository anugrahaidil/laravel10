<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegisteredNotification;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        // Simpan data ke database
        $user = \App\Models\User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        // Siapkan data untuk email
        $userData = [
            'name' => $user->name,
            'email' => $user->email,
            'registered_at' => now()->format('d-m-Y H:i:s'),
        ];

        // Kirimkan email notifikasi
        Mail::to($user->email)->send(new UserRegisteredNotification($userData));

        // Redirect dengan pesan sukses
        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan cek email Anda untuk notifikasi.');
    }
}
