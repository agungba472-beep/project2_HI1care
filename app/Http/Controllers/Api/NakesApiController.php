<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Konsultasi;
use App\Models\Nakes;
use App\Models\Pasien;
use Illuminate\Http\Request;

class NakesApiController extends Controller
{
    /**
     * Helper: Ambil data nakes dari user yang login.
     */
    private function getNakes()
    {
        return Nakes::where('user_id', auth()->id())->first();
    }

    /**
     * Melihat daftar semua pasien aktif beserta status kepatuhan terakhir (FR-T02).
     */
    public function getMyPatients()
    {
        $user = auth()->user();

        if ($user->role !== 'nakes') {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak. Hanya nakes yang bisa mengakses fitur ini.'
            ], 403);
        }

        $patients = Pasien::with([
            'user:id,nama,username,status_akun',
            'master:id,no_reg_hiv,nama',
            'kepatuhan' => function ($q) {
                $q->latest('last_update')->take(1);
            }
        ])->get();

        return response()->json(['status' => 'success', 'data' => $patients]);
    }

    /**
     * Detail lengkap satu pasien: profil, kepatuhan, diary, alarm, refill (FR-T02).
     */
    public function getPatientDetails($id)
    {
        $user = auth()->user();

        if ($user->role !== 'nakes') {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak'
            ], 403);
        }

        $pasien = Pasien::with([
            'user:id,nama,username',
            'master',
            'kepatuhan' => function ($q) {
                $q->latest('last_update')->take(30);
            },
            'diaryHarian' => function ($q) {
                $q->latest('tanggal')->take(10);
            },
            'alarm' => function ($q) {
                $q->orderBy('waktu');
            },
            'refillObat' => function ($q) {
                $q->latest('tanggal_refill')->take(5);
            },
        ])->find($id);

        if (!$pasien) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data pasien tidak ditemukan'
            ], 404);
        }

        // Hitung statistik kepatuhan
        $totalKepatuhan = $pasien->kepatuhan->count();
        $diminum = $pasien->kepatuhan->where('status', 'diminum')->count();
        $persentase = $totalKepatuhan > 0 ? round(($diminum / $totalKepatuhan) * 100, 1) : 0;

        return response()->json([
            'status' => 'success',
            'data' => [
                'pasien' => $pasien,
                'statistik_kepatuhan' => [
                    'total_log' => $totalKepatuhan,
                    'diminum' => $diminum,
                    'terlewat' => $pasien->kepatuhan->where('status', 'terlewat')->count(),
                    'tunda' => $pasien->kepatuhan->where('status', 'tunda')->count(),
                    'persentase_kepatuhan' => $persentase,
                ],
            ]
        ]);
    }

    /**
     * Daftar konsultasi milik nakes yang login (FR-T03).
     */
    public function getConsultations()
    {
        $nakes = $this->getNakes();

        if (!$nakes) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data nakes tidak ditemukan'
            ], 404);
        }

        $konsultasi = Konsultasi::where('nakes_id', $nakes->id)
            ->with(['pasien.user:id,nama', 'pasien.master:id,no_reg_hiv,nama'])
            ->orderByDesc('tanggal')
            ->paginate(10);

        return response()->json(['status' => 'success', 'data' => $konsultasi]);
    }

    /**
     * Update status konsultasi (terima/tolak/selesai) oleh nakes.
     */
    public function updateConsultationStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diterima,ditolak,selesai,batal',
        ]);

        $nakes = $this->getNakes();
        if (!$nakes) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data nakes tidak ditemukan'
            ], 404);
        }

        $konsultasi = Konsultasi::where('id', $id)
            ->where('nakes_id', $nakes->id)
            ->first();

        if (!$konsultasi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Konsultasi tidak ditemukan'
            ], 404);
        }

        $konsultasi->update(['status' => $request->status]);

        return response()->json([
            'status' => 'success',
            'message' => 'Status konsultasi berhasil diperbarui',
            'data' => $konsultasi
        ]);
    }
}
