<?php

namespace Database\Seeders;

use App\Models\Faskes;
use Illuminate\Database\Seeder;

class FaskesSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama' => 'RSUD Pasar Minggu',
                'alamat' => 'Jl. TB Simatupang No.1, Pasar Minggu, Jakarta Selatan',
                'kontak' => '(021) 7890-1234',
                'tipe' => 'Rumah Sakit',
                'layanan' => 'ARV, Viral Load, PDP, Konseling',
            ],
            [
                'nama' => 'Puskesmas Tebet',
                'alamat' => 'Jl. Prof. Dr. Soepomo SH No.8, Tebet, Jakarta Selatan',
                'kontak' => '(021) 8301-456',
                'tipe' => 'Puskesmas',
                'layanan' => 'ARV, PDP, Konseling',
            ],
            [
                'nama' => 'RS Medistra',
                'alamat' => 'Jl. Gatot Subroto Kav.59, Kuningan Timur, Jakarta Selatan',
                'kontak' => '(021) 5210-200',
                'tipe' => 'Rumah Sakit',
                'layanan' => 'ARV, Viral Load',
            ],
            [
                'nama' => 'Puskesmas Kebayoran Baru',
                'alamat' => 'Jl. Wijaya I No.63, Kebayoran Baru, Jakarta Selatan',
                'kontak' => '(021) 7234-567',
                'tipe' => 'Puskesmas',
                'layanan' => 'ARV, Konseling HIV',
            ],
            [
                'nama' => 'Klinik Mandiri Sehat',
                'alamat' => 'Jl. Mampang Prapatan Raya No.12, Jakarta Selatan',
                'kontak' => '0812-3456-7890',
                'tipe' => 'Mandiri',
                'layanan' => 'ARV, Tes HIV',
            ],
        ];

        foreach ($data as $item) {
            Faskes::create($item);
        }
    }
}
