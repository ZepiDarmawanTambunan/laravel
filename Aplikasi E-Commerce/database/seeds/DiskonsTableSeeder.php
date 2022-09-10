<?php

use Illuminate\Database\Seeder;

class DiskonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Diskon::create([
            'id' => '1',
            'user_id' => '1',
            'kode' => 'DISKON',
            'poin' => '10',
            'jumlah' => '100',
            'tgl_berakhir' => strtotime("1 October 2022"),
            'gratis_ongkir' => 'yes',
        ]);
    }
}
