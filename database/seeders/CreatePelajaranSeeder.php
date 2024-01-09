<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pelajaran;

class CreatePelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pelajarans = [
            [
                'pelajaran' => 'Matematika',
                'kode_akses' => 4004
            ],
            [
                'pelajaran' => 'Sejarah',
                'kode_akses' => 4114
            ],
            [
                'pelajaran' => 'Geografi',
                'kode_akses' => 4771
            ],
        ];

        foreach ($pelajarans as $key => $pelajaran) 
        {
            Pelajaran::create($pelajaran);
        }
    }
}
