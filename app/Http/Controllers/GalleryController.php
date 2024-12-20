<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = array(
            'id'=>"posts",
            'menu'=>'Gallery',
            'galleries'=> Post::where('picture', '!=',
        '')->whereNotNull('picture')->orderBy('created_at', 'desc')->paginate(30)
            );
            return view('gallery.index')->with($data);
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