<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\PeristiwaKematian;
use App\Models\Warga;

class CreatePeristiwaKematianSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ambil semua warga
        $daftarWarga = Warga::pluck('warga_id')->toArray();

        if (empty($daftarWarga)) {
            dd("Error: Tidak ada data warga untuk dijadikan peristiwa kematian.");
        }

        for ($i = 0; $i < 20; $i++) {

            $wargaId = $faker->randomElement($daftarWarga);

            PeristiwaKematian::create([
                'warga_id'      => $wargaId,
                'tgl_meninggal' => $faker->date(),
                'sebab'         => $faker->randomElement([
                    'Sakit',
                    'Kecelakaan',
                    'Usia Lanjut',
                    'COVID-19',
                    'Tenggelam',
                    'Kebakaran',
                ]),
                'lokasi'        => $faker->city(),
                'no_surat'      => strtoupper($faker->bothify('SKM-####-####')),
            ]);
        }
    }
}
