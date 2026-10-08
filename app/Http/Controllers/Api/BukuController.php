<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    // tampil semua buku milik user yang login
    public function index(Request $request)
    {
        $bukus = Buku::where('user_id', $request->user()->id)->get();

        return response()->json($bukus);
    }

    // tambah buku baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
        ]);

        $buku = Buku::create([
            'user_id' => $request->user()->id,
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'isbn' => $request->isbn,
            'deskripsi' => $request->deskripsi,
        ]);

        return response()->json([
            'message' => 'Buku berhasil ditambah',
            'data' => $buku
        ], 201);
    }

    // tampil 1 buku (sudah dicek middleware buku.owner)
    public function show($id)
    {
        $buku = Buku::find($id);

        return response()->json($buku);
    }

    // edit buku (sudah dicek middleware buku.owner)
    public function update(Request $request, $id)
    {
        $buku = Buku::find($id);

        $buku->update([
            'judul' => $request->judul ?? $buku->judul,
            'penulis' => $request->penulis ?? $buku->penulis,
            'penerbit' => $request->penerbit ?? $buku->penerbit,
            'tahun_terbit' => $request->tahun_terbit ?? $buku->tahun_terbit,
            'isbn' => $request->isbn ?? $buku->isbn,
            'deskripsi' => $request->deskripsi ?? $buku->deskripsi,
        ]);

        return response()->json([
            'message' => 'Buku berhasil diupdate',
            'data' => $buku
        ]);
    }

    // hapus buku (sudah dicek middleware buku.owner)
    public function destroy($id)
    {
        $buku = Buku::find($id);
        $buku->delete();

        return response()->json([
            'message' => 'Buku berhasil dihapus'
        ]);
    }
}
