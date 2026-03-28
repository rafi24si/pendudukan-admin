<?php
namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 🔥 GENERATE 150 MEMBER
        for ($i = 1; $i <= 150; $i++) {

            User::create([
                'nama_ic'  => $faker->unique()->userName . '_' . $i,
                'password' => Hash::make('123456'),
                'role'     => 'member',
            ]);
        }
    }
}
