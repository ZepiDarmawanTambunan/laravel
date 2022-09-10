<?php

use Illuminate\Database\Seeder;

class RekeningsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Rekening::create([
            'id' => '1',
            'nama_bank' => 'BRI',
            'nomor_rekening' => '1224234453534',
            'nama_pemilik' => 'PT. Aneka Terpal',
        ]);

        \App\Rekening::create([
            'id' => '2',
            'nama_bank' => 'PANIN',
            'nomor_rekening' => '134534534534',
            'nama_pemilik' => 'PT. Aneka Terpal',
        ]);
    }
}
