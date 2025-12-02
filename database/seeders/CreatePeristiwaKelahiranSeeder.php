<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\PeristiwaKelahiran;
use App\Models\Warga;

class CreatePeristiwaKelahiranSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $daftarAyah = Warga::where('jenis_kelamin', 'L')->pluck('warga_id')->toArray();
        $daftarIbu  = Warga::where('jenis_kelamin', 'P')->pluck('warga_id')->toArray();

        if (empty($daftarAyah) || empty($daftarIbu)) {
            dd("Error: Tidak ada data warga laki-laki / perempuan.");
        }

        for ($i = 0; $i < 20; $i++) {

            $ayahId = $faker->randomElement($daftarAyah);
            $ibuId  = $faker->randomElement($daftarIbu);

            $bayi = Warga::create([
                'no_ktp'       => $faker->nik(),
                'nama'         => $faker->firstName() . ' ' . $faker->lastName(),
                'jenis_kelamin'=> $faker->randomElement(['L', 'P']),
                'agama'        => 'Islam',
                'pekerjaan'    => '-',
                'telp'         => '-',
                'email'        => '-',
            ]);

            PeristiwaKelahiran::create([
                'warga_id'      => $bayi->warga_id,
                'tgl_lahir'     => $faker->date(),
                'tempat_lahir'  => $faker->city(),
                'ayah_warga_id' => $ayahId,
                'ibu_warga_id'  => $ibuId,
                'no_akta'       => strtoupper($faker->bothify('AKTA-####-####')),
            ]);
        }
    }
}
