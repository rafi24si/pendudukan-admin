<?php

namespace Database\Seeders;

use App\Models\AnggotaKeluarga;
use App\Models\KeluargaKK;
use App\Models\Warga;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CreateAnggotaKeluargaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $keluargaKK = KeluargaKK::all();
        $warga = Warga::all();

        if ($keluargaKK->count() == 0 || $warga->count() == 0) {
            $this->command->error('Seeder gagal: KK atau Warga masih kosong.');
            return;
        }

        $hubunganList = [
            'Kepala Keluarga',
            'Istri',
            'Anak',
            'Ayah',
            'Ibu',
            'Menantu',
            'Cucu',
            'Saudara',
        ];

        foreach (range(1, 100) as $i) {
            AnggotaKeluarga::create([
                'kk_id'     => $keluargaKK->random()->kk_id,
                'warga_id'  => $warga->random()->warga_id,
                'hubungan'  => $faker->randomElement($hubunganList),
            ]);
        }

        $this->command->info('✔ 100 Data Anggota Keluarga berhasil dibuat.');
    }
}
