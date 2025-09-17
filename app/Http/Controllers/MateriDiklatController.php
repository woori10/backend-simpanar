<?php

namespace App\Http\Controllers;

use App\Models\MateriDiklat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriDiklatController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'daftar_alat_id' => 'required|exists:daftar_alat,id',
            'file_pdf'       => 'required|mimes:pdf|max:102400',
        ]);

        // Simpan file PDF ke storage/public/file_pdf
        $filePDFPath = $request->file('file_pdf')->store('file_pdf', 'public');

        // Ambil data nama_alat dan foto dari tabel daftar_alat
        $alat = \App\Models\DaftarAlat::findOrFail($validated['daftar_alat_id']);

        // Simpan ke tabel materi_diklat termasuk nama_alat & foto
        $materi_diklat = MateriDiklat::create([
            'daftar_alat_id' => $alat->id,
            'nama_alat'      => $alat->nama_alat,
            'foto'           => $alat->foto,
            'file_pdf'       => $filePDFPath,
        ]);

        // // Jika masih ingin relasi daftarAlat ikut diload
        // $materi_diklat->load('daftarAlat');

        return response()->json([
            'message' => 'Materi Diklat Berhasil Ditambahkan',
            'data'    => $materi_diklat
        ]);
    }


    public function index()
    {
        return MateriDiklat::with('daftarAlat')->get();
        // $materi_diklat = MateriDiklat::all()->map(function ($item) {
        //     return[
        //         'id' => $item->id,
        //         'nama' => $item->nama,
        //         'foto_url' => asset('storage/'. $item->foto),
        //         'dokumen_url' => asset('storage/'. $item->dokumen),
        //     ];
        // });

        // return response()->json($materi_diklat);
    }

    public function show($id)
    {
        return MateriDiklat::with('daftarAlat')->findOrFail($id);
        // $materi_diklat = MateriDiklat::findOrFail($id);

        // return response()->json([
        //     'id' => $materi_diklat->id,
        //     'nama' => $materi_diklat->nama,
        //     'foto_url' => asset('storage/' . $materi_diklat->foto),
        //     'dokumen_url' => asset('storage/' . $materi_diklat->dokumen),
        // ]);
    }

    public function update (Request $request, $id)
    {
        $materi_diklat = MateriDiklat::findOrFail($id);

        $request->validate([
            'daftar_alat_id' => 'sometimes|exists:daftar_alat,id',
            'file_pdf'=> 'mimes:pdf|max:102400',
        ]);

        // update dokumen bila ada
        if ($request->hasFile('file_pdf')) {
            Storage::disk('public')->delete($materi_diklat->file_pdf);
            $materi_diklat->file_pdf = $request->file('file_pdf')->store('file_pdf', 'public');
        }

        $materi_diklat->save();

        return response()->json([
            'message'=>'Materi Diklat Berhasil Diperbarui',
            'data'=>$materi_diklat
        ]);

    }

    public function destroy($id)
    {
        $materi_diklat = MateriDiklat::findOrFail($id);
        $materi_diklat->delete();

        return response()->json([
            'message' => 'Materi Diklat Berhasil Dihapus'
        ]);
    }

}
