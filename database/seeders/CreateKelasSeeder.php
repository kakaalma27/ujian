<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\kelas;

class CreateKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kelas = [
            [
                'nama_kelas' => 'X-IPS-1',
            ],
            [
                'nama_kelas' => 'XI-IPA-1',
            ],
            [
                'nama_kelas' => 'XII-IPS-1',
            ],
        ];

        foreach ($kelas as $key => $kelaz) 
        {
            kelas::create($kelaz);
        }
    }
}
