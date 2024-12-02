<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Get(
     *     path="/api/gallery",
     *     tags={"Gallery"},
     *     summary="Retrieve a list of gallery posts",
     *     description="API untuk mendapatkan daftar galeri yang memiliki gambar",
     *     operationId="getGallery",
     *     @OA\Response(
     *         response=200,
     *         description="List of gallery posts",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Gallery Post Title"),
     *                 @OA\Property(property="picture", type="string", example="https://example.com/image.jpg"),
     *                 @OA\Property(property="description", type="string", example="This is a gallery post description."),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01T00:00:00Z")
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        // Ambil data dari API
        $response = Http::get('http://localhost:8000/api/gallery');
        
        // Periksa respons API
        if ($response->ok()) {
            $galleries = $response->json()['data']; // Data dari API
            return view('gallery.index', compact('galleries'));
        }
    
        // Jika gagal, tampilkan pesan error
        return back()->withErrors('Gagal memuat data gallery dari API');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'picture' => 'image|nullable|max:1999'
        ]);
        if ($request->hasFile('picture')) {
            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();
            $basename = uniqid() . time();
            $smallFilename = "small_{$basename}.{$extension}";
            $mediumFilename = "medium_{$basename}.{$extension}";
            $largeFilename = "large_{$basename}.{$extension}";
            $filenameSimpan = "{$basename}.{$extension}";
            $path = $request->file('picture')->storeAs('posts_image', $filenameSimpan);
        } else {
            $filenameSimpan = 'noimage.png';
        }
        $post = new Post;
        $post->picture = $filenameSimpan;
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->save();
        return redirect('gallery')->with('success', 'Berhasil menambahkan data baru');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $gallery = Post::findOrFail($id);
        return view('gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $gallery = Post::findOrFail($id);

        // Validasi input
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'picture' => 'image|nullable|max:1999'
        ]);

        // Jika ada file gambar baru, proses penggantian gambar
        if ($request->hasFile('picture')) {
            // Hapus gambar lama jika ada
            if ($gallery->picture && $gallery->picture != 'noimage.png') {
                Storage::delete('public/posts_image/' . $gallery->picture);
            }

            // Upload gambar baru
            $filenameWithExt = $request->file('picture')->getClientOriginalName();
            $extension = $request->file('picture')->getClientOriginalExtension();
            $basename = uniqid() . time();
            $filenameSimpan = "{$basename}.{$extension}";
            $path = $request->file('picture')->storeAs('public/posts_image', $filenameSimpan);

            // Simpan nama file gambar ke dalam database
            $gallery->picture = $filenameSimpan;
        }

        // Perbarui data lain
        $gallery->title = $validatedData['title'];
        $gallery->description = $validatedData['description'];
        $gallery->save();

        return redirect()->route('gallery.index')->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $gallery = Post::findOrFail($id);

        // Hapus gambar jika ada
        if ($gallery->picture && $gallery->picture != 'noimage.png') {
            Storage::delete('public/posts_image/' . $gallery->picture);
        }

        // Hapus data dari database
        $gallery->delete();

        return redirect()->route('gallery.index')->with('success', 'Data berhasil dihapus');
    }
}
