<?php

namespace App\Http\Controllers;

use App\Models\MateriDiklat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriDiklatController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama'=> 'required|string|max:255',
            'foto'=> 'required|image|mimes:jpg,jpeg,png|max:2048',
            'dokumen'=> 'required|mimes:pdf|max:102400',
        ], [
            'nama.required' => 'Nama harus diisi.',
            'nama.string'   => 'Nama harus berupa teks.',
            'nama.max'      => 'Nama maksimal 255 karakter.',

            'foto.required' => 'Foto wajib diunggah.',
            'foto.image'    => 'File foto harus berupa gambar.',
            'foto.mimes'    => 'Format foto harus jpg, jpeg, atau png.',
            'foto.max'      => 'Ukuran foto maksimal 2 MB.',

            'dokumen.required' => 'Dokumen wajib diunggah.',
            'dokumen.mimes'    => 'Dokumen hanya boleh berupa file PDF.',
            'dokumen.max'      => 'Ukuran file maksimal 100 MB.',
        ]);

        $fotoPath = $request->file('foto')->store('foto', 'public');
        $dokumenPath = $request->file('dokumen')->store('dokumen', 'public');

        $materi_diklat = MateriDiklat::create([
            'nama' => $request->nama,
            'foto' => $fotoPath,
            'dokumen' => $dokumenPath,
        ]);

        return response()->json([
            'message' => 'Materi Diklat Berhasil Ditambahkan',
            'data' => $materi_diklat

        ]);
    }

    public function index()
    {
        $materi_diklat = MateriDiklat::all()->map(function ($item) {
            return[
                'id' => $item->id,
                'nama' => $item->nama,
                'foto_url' => asset('storage/'. $item->foto),
                'dokumen_url' => asset('storage/'. $item->dokumen),
            ];
        });

        return response()->json($materi_diklat);
    }

    public function show($id)
    {
        $materi_diklat = MateriDiklat::findOrFail($id);

        return response()->json([
            'id' => $materi_diklat->id,
            'nama' => $materi_diklat->nama,
            'foto_url' => asset('storage/' . $materi_diklat->foto),
            'dokumen_url' => asset('storage/' . $materi_diklat->dokumen),
        ]);
    }

    public function update (Request $request, $id)
    {
        $materi_diklat = MateriDiklat::findOrFail($id);

        $request->validate([
            'nama'=> 'string|max:255',
            'foto'=> 'image|mimes:jpg,jpeg,png|max:2048',
            'dokumen'=> 'mimes:pdf|max:102400',
        ]);

        // update kolom teks
        $materi_diklat->nama = $request->nama ?? $materi_diklat->nama;

        // update file foto bila ada
        if ($request->hasFile('foto')) {
            Storage::disk('public')->delete($materi_diklat->foto);
            $materi_diklat->foto = $request->file('foto')->store('foto', 'public');
        }

        // update dokumen bila ada
        if ($request->hasFile('dokumen')) {
            Storage::disk('public')->delete($materi_diklat->dokumen);
            $materi_diklat->dokumen = $request->file('dokumen')->store('dokumen', 'public');
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

        Storage::disk('public')->delete($materi_diklat->foto);
        Storage::disk('public')->delete($materi_diklat->dokumen);

        $materi_diklat->delete();

        return response()->json([
            'message' => 'Materi Diklat Berhasil Dihapus'
        ]);
    }

}
