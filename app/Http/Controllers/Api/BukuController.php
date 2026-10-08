<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    // GET /api/bukus (auth) - hanya buku milik sendiri
    public function index(Request $request)
    {
        $bukus = Buku::where('user_id', $request->user()->id)
            ->with('user:id,name,email')
            ->latest()
            ->get();

        return response()->json(['success' => true, 'data' => $bukus]);
    }

    // POST /api/bukus (auth)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'nullable|string|max:255',
            'tahun_terbit' => 'nullable|digits:4|integer|min:1000|max:' . date('Y'),
            'isbn' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
        ]);

        $validated['user_id'] = $request->user()->id;

        $buku = Buku::create($validated);
        $buku->load('user:id,name,email');

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil ditambahkan.',
            'data' => $buku,
        ], 201);
    }

    // GET /api/bukus/{buku} (auth + buku.owner)
    public function show(Request $request, $id)
    {
        $buku = $request->attributes->get('buku_owned') ?? Buku::find($id);
        $buku->load('user:id,name,email');

        return response()->json(['success' => true, 'data' => $buku]);
    }

    // PUT /api/bukus/{buku} (auth + buku.owner)
    public function update(Request $request, $id)
    {
        $buku = $request->attributes->get('buku_owned') ?? Buku::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'sometimes|string|max:255',
            'penulis' => 'sometimes|string|max:255',
            'penerbit' => 'nullable|string|max:255',
            'tahun_terbit' => 'nullable|digits:4|integer|min:1000|max:' . date('Y'),
            'isbn' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
        ]);

        $buku->update($validated);
        $buku->load('user:id,name,email');

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil diupdate.',
            'data' => $buku,
        ]);
    }

    // DELETE /api/bukus/{buku} (auth + buku.owner)
    public function destroy(Request $request, $id)
    {
        $buku = $request->attributes->get('buku_owned') ?? Buku::findOrFail($id);
        $buku->delete();

        return response()->json(['success' => true, 'message' => 'Buku berhasil dihapus.']);
    }
}
