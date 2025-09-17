<?php

namespace App\Http\Controllers;

use App\Models\VideoTutorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoTutorialController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'daftar_alat_id' => 'required|exists:daftar_alat,id',
            'file_video'     => 'required|mimes:mp4,mov,avi,wmv,flv|max:512000',
        ]);

        $fileVideoPath = $request->file('file_video')->store('file_video', 'public');

        $video_tutorial = VideoTutorial::create([
            'daftar_alat_id' => $validated['daftar_alat_id'],
            'file_video'     => $fileVideoPath,
        ]);

        // sertakan info alat supaya respon lengkap
        $video_tutorial->load('daftarAlat');

        return response()->json([
            'message' => 'Video Tutorial berhasil ditambahkan',
            'data'    => $video_tutorial
        ]);
    }

    // daftar semua alat beserta jumlah videonya (untuk halaman awal)
    public function listAlat()
    {
        $alat = \App\Models\DaftarAlat::withCount('videoTutorial')->get();
        return response()->json($alat);
    }

    // daftar semua video milik satu alat (halaman kedua)
    public function listByAlat($id)
    {
        $alat = \App\Models\DaftarAlat::with('videoTutorial')->findOrFail($id);
        return response()->json($alat);
    }

    // detail satu video (opsional, halaman ketiga)
    public function show($id)
    {
        $video = VideoTutorial::with('daftarAlat')->findOrFail($id);
        return response()->json($video);
    }

    public function index()
    {
        $video_tutorial = VideoTutorial::with('daftarAlat')->get();
        return response()->json($video_tutorial);
    }

    public function update(Request $request, $id)
    {
        $video_tutorial = VideoTutorial::findOrFail($id);

        $validated = $request->validate([
            'daftar_alat_id' => 'sometimes|exists:daftar_alat,id',
            'file_video'     => 'sometimes|mimetypes:video/mp4,video/mpeg,video/quicktime|max:512000',
        ]);

        if ($request->has('daftar_alat_id')) {
            $video_tutorial->daftar_alat_id = $validated['daftar_alat_id'];
        }

        if ($request->hasFile('file_video')) {
            // hapus file lama
            if ($video_tutorial->file_video && \Storage::disk('public')->exists($video_tutorial->file_video)) {
                \Storage::disk('public')->delete($video_tutorial->file_video);
            }
            // simpan file baru
            $videoPath = $request->file('file_video')->store('file_video', 'public');
            $video_tutorial->file_video = $videoPath;
        }

        $video_tutorial->save();

        return response()->json([
            'message' => 'Video tutorial berhasil diperbarui',
            'data'    => $video_tutorial->load('daftarAlat')
        ]);
    }

    public function destroy($id)
    {
        $video_tutorial = VideoTutorial::findOrFail($id);

        // if ($video_tutorial->video_path && \Storage::disk('public')->exists($video->video_path)) {
        //     \Storage::disk('public')->delete($video_tutorial->video_path);
        // }

        $video_tutorial->delete();

        return response()->json(['message' => 'Video tutorial berhasil dihapus']);
    }

}
