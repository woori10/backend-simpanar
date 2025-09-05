<?php

namespace App\Http\Controllers;

use App\Models\TataKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TataKerjaController extends Controller
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

        $tata_kerja = TataKerja::create([
            'nama' => $request->nama,
            'foto' => $fotoPath,
            'dokumen' => $dokumenPath,
        ]);

        return response()->json([
            'message' => 'Tata Kerja Berhasil Ditambahkan',
            'data' => $tata_kerja

        ]);
    }

    public function index()
    {
        $tata_kerja = TataKerja::all()->map(function ($item) {
            return[
                'id' => $item->id,
                'nama' => $item->nama,
                'foto_url' => asset('storage/'. $item->foto),
                'dokumen_url' => asset('storage/'. $item->dokumen),
            ];
        });

        return response()->json($tata_kerja);
    }

    public function show($id)
    {
        $tata_kerja = TataKerja::findOrFail($id);

        return response()->json([
            'id' => $tata_kerja->id,
            'nama' => $tata_kerja->nama,
            'foto_url' => asset('storage/' . $tata_kerja->foto),
            'dokumen_url' => asset('storage/' . $tata_kerja->dokumen),
        ]);
    }

    public function update (Request $request, $id)
    {
        $tata_kerja = TataKerja::findOrFail($id);

        $request->validate([
            'nama'=> 'string|max:255',
            'foto'=> 'image|mimes:jpg,jpeg,png|max:2048',
            'dokumen'=> 'mimes:pdf|max:102400',
        ]);

        if ($request->has('nama')){
            $tata_kerja->nama = $request->nama;
        }

        if ($request->hasFile('foto')){
            Storage::disk('public')->delete($tata_kerja->foto);
            $tata_kerja->foto=$request->file('foto')->store('foto', 'public');
        }

        if ($request->hasFile('dokumen')){
            Storage::disk('public')->delete($tata_kerja->dokumen);
            $tata_kerja->dokumen=$request->file('dokumen')->store('dokumen', 'public');
        }

        $tata_kerja->save();

        return response()->json([
            'message'=>'Tata Kerja Berhasil Diperbarui',
            'data'=>$tata_kerja
        ]);


    }

    public function destroy($id)
    {
        $tata_kerja = TataKerja::findOrFail($id);

        Storage::disk('public')->delete($tata_kerja->foto);
        Storage::disk('public')->delete($tata_kerja->dokumen);

        $tata_kerja->delete();

        return response()->json([
            'message' => 'Tata Kerja Berhasil Dihapus'
        ]);
    }

}
