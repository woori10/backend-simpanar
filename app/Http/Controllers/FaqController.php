<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'pertanyaan' => 'required|string',
            'jawaban'    => 'required|string',
        ]);

        $faq = Faq::create($data);

        return response()->json([
            'message' => 'FAQ berhasil dibuat',
            'data'    => $faq
        ], 201);
    }

    public function index()
    {
        return response()->json([
            'message' => 'Daftar semua FAQ',
            'data'    => Faq::all()
        ]);
    }

    public function show($id)
    {
        $faq = Faq::find($id);

        if (! $faq) {
            return response()->json(['message' => 'FAQ tidak ditemukan'], 404);
        }

        return response()->json([
            'message' => 'Detail FAQ',
            'data'    => $faq
        ]);
    }

    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);

        $validated = $request->validate([
            'pertanyaan' => 'sometimes|string|max:255',
            'jawaban'    => 'sometimes|string|max:255',
        ]);

        $faq->update($validated);

        return response()->json([
            'message' => 'FAQ berhasil diperbarui',
            'data'    => $faq
        ]);
    }

    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return response()->json([
            'message' => 'FAQ berhasil dihapus'
        ]);
    }
}
