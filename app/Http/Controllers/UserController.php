<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,' . $id,
            'satker' => 'string',
            'nip' => 'string|max:18|unique:users,nip,' . $id,
            'no_telp' => 'string|max:20',
            'password' => 'string|min:6',
        ]);

        $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'satker' => $request->satker ?? $user->satker,
            'nip' => $request->nip ?? $user->nip,
            'no_telp' => $request->no_telp ?? $user->no_telp,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return response()->json([
            'message' => 'User berhasil diperbarui',
            'user' => $user
        ]);
    }

    public function destroy ($id)
    {
        $user = User::findorFail($id);
        $user->delete();

        return response()->json([
            'message'=>'User berhasil dihapus'
        ]);
    }
}
