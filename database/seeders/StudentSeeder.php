<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $prodiList = [
            'Teknik Informatika',
            'Sistem Informasi',
            'Teknik Elektro',
            'Manajemen',
            'Akuntansi',
        ];

        for ($i = 0; $i < 15; $i++) {
            Student::create([
                'nim'           => $faker->unique()->numerify('##########'),
                'nama'          => $faker->name(),
                'prodi'         => $faker->randomElement($prodiList),
                'tanggal_lahir' => $faker->dateTimeBetween('2000-01-01', '2005-12-31')->format('Y-m-d'),
                'email'         => $faker->unique()->safeEmail(),
                'alamat'        => $faker->address(),
            ]);
        }
    }
}
