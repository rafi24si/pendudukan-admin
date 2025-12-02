<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\PeristiwaPindah;
use App\Models\Warga;

class CreatePeristiwaPindahSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ambil semua warga
        $daftarWarga = Warga::pluck('warga_id')->toArray();

        if (empty($daftarWarga)) {
            dd("Error: Tidak ada data warga untuk dijadikan peristiwa pindah.");
        }

        for ($i = 0; $i < 20; $i++) {

            $wargaId = $faker->randomElement($daftarWarga);

            PeristiwaPindah::create([
                'warga_id'       => $wargaId,
                'tgl_pindah'     => $faker->date(),
                'alamat_tujuan'  => $faker->address(),
                'alasan'         => $faker->randomElement([
                    'Pekerjaan',
                    'Pendidikan',
                    'Keluarga',
                    'Menikah',
                    'Pindah Rumah',
                    'Masalah Ekonomi',
                    'Pembangunan Rumah Baru',
                ]),
                'no_surat'       => strtoupper($faker->bothify('SPN-####-####')),
            ]);
        }
    }
}
