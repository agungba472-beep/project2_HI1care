<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * GET /api/user - Ambil data user yang sedang login.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Load relasi sesuai role
        if ($user->role === 'pasien') {
            $user->load('pasien.master');
        } elseif ($user->role === 'nakes') {
            $user->load('nakes');
        } elseif ($user->role === 'admin') {
            $user->load('admin');
        }

        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    /**
     * GET /api/profile - Ambil profil lengkap (legacy endpoint).
     */
    public function profile(Request $request)
    {
        $user = $request->user();

        // Load relasi sesuai role
        if ($user->role === 'pasien') {
            $user->load('pasien.master');
        } elseif ($user->role === 'nakes') {
            $user->load('nakes');
        }

        return response()->json([
            'user' => $user
        ]);
    }

    /**
     * POST /api/profile/update - Update profil user.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'nama' => 'sometimes|string|max:255',
            'username' => 'sometimes|string|unique:users,username,' . $user->id,
            'password' => 'sometimes|string|min:6|confirmed',
        ]);

        $updateData = [];

        if ($request->has('nama')) {
            $updateData['nama'] = $request->nama;
        }

        if ($request->has('username')) {
            $updateData['username'] = $request->username;
        }

        if ($request->has('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        if (!empty($updateData)) {
            $user->update($updateData);
        }

        // Reload relasi
        if ($user->role === 'pasien') {
            $user->load('pasien.master');
        } elseif ($user->role === 'nakes') {
            $user->load('nakes');
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Profil berhasil diperbarui',
            'data' => $user
        ]);
    }
}
