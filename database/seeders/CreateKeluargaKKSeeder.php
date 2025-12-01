<?php

namespace Database\Seeders;

use App\Models\KeluargaKK;
use App\Models\Warga;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CreateKeluargaKKSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ambil semua ID warga untuk kepala keluarga
        $wargaIds = Warga::pluck('warga_id')->toArray();

        if (count($wargaIds) === 0) {
            $this->command->error("❌ Tidak ada data Warga! Jalankan seeder Warga terlebih dahulu.");
            return;
        }

        foreach (range(1, 100) as $i) {
            KeluargaKK::create([
                'kk_nomor' => $faker->unique()->numerify('3174##########'),

                // Ambil random warga untuk kepala keluarga
                'kepala_keluarga_warga_id' => $faker->randomElement($wargaIds),

                'alamat' => $faker->streetAddress(),
                'rt'     => $faker->numberBetween(1, 20),
                'rw'     => $faker->numberBetween(1, 10),
            ]);
        }

        $this->command->info("✔ 100 Data Keluarga KK berhasil dibuat.");
    }
}
