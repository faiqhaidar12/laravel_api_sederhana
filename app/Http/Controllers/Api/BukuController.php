<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Buku::orderBy('judul', 'asc')->paginate(10);
        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan!',
            'data' => $data,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataBuku = new Buku;

        $rules = [
            'judul' => 'required',
            'pengarang' => 'required',
            'tgl_publikasi' => 'required|date'
        ];

        $validasi = Validator::make($request->all(), $rules);
        if ($validasi->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memasukan data!',
                'data' => $validasi->errors()
            ]);
        }

        $dataBuku->judul = $request->judul;
        $dataBuku->pengarang = $request->pengarang;
        $dataBuku->tgl_publikasi = $request->tgl_publikasi;

        $simpanBuku = $dataBuku->save();

        return response()->json([
            'status' => true,
            'message' => "Data berhasil di tambahkan!",
            'data' => $dataBuku
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Buku::find($id);
        if ($data) {
            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan!',
                'data' => $data,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Data tidak ditemukan!",
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dataBuku = Buku::find($id);
        if (empty($dataBuku)) {
            return response()->json([
                'status' => false,
                'message' => "Data tidak ditemukan",
            ], 404);
        }

        $rules = [
            'judul' => 'required',
            'pengarang' => 'required',
            'tgl_publikasi' => 'required|date'
        ];

        $validasi = Validator::make($request->all(), $rules);
        if ($validasi->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal update data!',
                'data' => $validasi->errors()
            ]);
        }

        $dataBuku->judul = $request->judul;
        $dataBuku->pengarang = $request->pengarang;
        $dataBuku->tgl_publikasi = $request->tgl_publikasi;

        $simpanBuku = $dataBuku->save();

        return response()->json([
            'status' => true,
            'message' => "Data berhasil di update!",
            'data' => $dataBuku
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dataBuku = Buku::find($id);
        if (empty($dataBuku)) {
            return response()->json([
                'status' => false,
                'message' => "Data tidak ditemukan",
            ], 404);
        }

        $simpanBuku = $dataBuku->delete();

        return response()->json([
            'status' => true,
            'message' => "Data berhasil di delete!",
            'data' => $dataBuku
        ]);
    }
}
