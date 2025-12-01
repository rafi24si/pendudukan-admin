<?php

namespace Database\Seeders;

use App\Models\Warga;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class CreateWargaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $agamaList = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu'];
        $pekerjaanList = [
            'Karyawan Swasta', 'Wiraswasta', 'PNS', 'Pelajar/Mahasiswa',
            'Ibu Rumah Tangga', 'Petani', 'Nelayan', 'Guru', 'Dokter', 'Perawat'
        ];

        foreach (range(1, 100) as $i) {

            // Generate nomor KTP Indonesia realistis (16 digit)
            $nik = $faker->randomNumber(8) . $faker->randomNumber(8);

            // Generate nomor HP Indonesia (08xxxxxxxxxx)
            $telp = '08' . $faker->numerify('##########');

            Warga::create([
                'no_ktp'        => $nik,
                'nama'          => $faker->name,
                'jenis_kelamin' => $faker->randomElement(['L', 'P']), // lebih umum
                'agama'         => $faker->randomElement($agamaList),
                'pekerjaan'     => $faker->randomElement($pekerjaanList),
                'telp'          => $telp,
                'email'         => $faker->safeEmail,
            ]);
        }

        $this->command->info('✔ 100 Data Warga Indonesia berhasil dibuat!');
    }
}
