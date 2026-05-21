<?php

namespace Database\Seeders;

use App\Models\Faskes;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaskesSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Bersihkan seluruh data lama (menghapus Klinik Jakarta dll)
        DB::table('faskes')->truncate();

        // 2. Data Puskesmas & RSUD Asli di Kabupaten Subang
        $data = [
            [
                'nama' => 'RSUD Kelas B Kabupaten Subang',
                'alamat' => 'Jl. Brigjen Katamso No.37, Dangdeur, Kec. Subang',
                'kontak' => '(0260) 411421',
                'tipe' => 'Rumah Sakit',
                'layanan' => 'ARV, Viral Load, PDP, Konseling',
                'latitude' => '-6.568114',
                'longitude' => '107.766160',
            ],
            [
                'nama' => 'Puskesmas Subang',
                'alamat' => 'Jl. H. Otto Iskandardinata No. 12, Karanganyar, Kec. Subang',
                'kontak' => '(0260) 411418',
                'tipe' => 'Puskesmas',
                'layanan' => 'PDP, Konseling, Tes HIV (VCT)',
                'latitude' => '-6.562340',
                'longitude' => '107.761230',
            ],
            [
                'nama' => 'Puskesmas Sukarahayu',
                'alamat' => 'Jl. Apel Raya No. 43, Perumnas, Karanganyar, Kec. Subang',
                'kontak' => '(0260) 412211',
                'tipe' => 'Puskesmas',
                'layanan' => 'ARV, Konseling',
                'latitude' => '-6.566838',
                'longitude' => '107.761066',
            ],
            [
                'nama' => 'Puskesmas Cibogo',
                'alamat' => 'Jl. Raya Cinangsi No. 53, Kec. Cibogo, Kabupaten Subang',
                'kontak' => '(0260) 411000',
                'tipe' => 'Puskesmas',
                'layanan' => 'Tes HIV, Konseling',
                'latitude' => '-6.551000',
                'longitude' => '107.801000',
            ],
            [
                'nama' => 'Puskesmas Pamanukan',
                'alamat' => 'Jl. Ion Martasasmita No. 30, Pamanukan, Kabupaten Subang',
                'kontak' => '(0260) 551044',
                'tipe' => 'Puskesmas',
                'layanan' => 'ARV, PDP, Konseling',
                'latitude' => '-6.281986',
                'longitude' => '107.816431',
            ],
            [
                'nama' => 'Puskesmas Jalancagak',
                'alamat' => 'Jl. Raya Jalancagak No. 90, Kec. Jalancagak, Kabupaten Subang',
                'kontak' => '(0260) 470001',
                'tipe' => 'Puskesmas',
                'layanan' => 'PDP, Tes HIV (VCT)',
                'latitude' => '-6.671000',
                'longitude' => '107.671200',
            ],
            [
                'nama' => 'Puskesmas Pagaden',
                'alamat' => 'Jl. Subang-Pamanukan, Kec. Pagaden, Kabupaten Subang',
                'kontak' => '(0260) 450111',
                'tipe' => 'Puskesmas',
                'layanan' => 'ARV, Tes HIV',
                'latitude' => '-6.483912',
                'longitude' => '107.800123',
            ]
        ];

        // 3. Masukkan data ke Database
        foreach ($data as $item) {
            Faskes::create($item);
        }
    }
}