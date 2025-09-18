<?php

namespace App\Http\Controllers;

use App\Models\Keluhan;
use Illuminate\Http\Request;

class KeluhanController extends Controller
{
    public function index() {
        return Keluhan::with('user:id,name,email')->get();
    }

    public function store(Request $request) {

        $user = $request->user();

        $validated = $request->validate([
            'keluhan' => 'required|string',
        ]);

        $keluhan = Keluhan::create([
            'user_id'     => $user->id,
            'keluhan' => $validated['keluhan'],
        ]);

        $keluhan->load('user:id,name,email');

        return response()->json([
            'message' => 'Keluhan berhasil dikirim',
            'data'    => $keluhan
        ], 201);
    }

    public function show($id) {
        return response()->json(Keluhan::findOrFail($id));
    }

    public function destroy($id) {
        Keluhan::findOrFail($id)->delete();
        return response()->json(['message'=>'Keluhan dihapus']);
    }
}
