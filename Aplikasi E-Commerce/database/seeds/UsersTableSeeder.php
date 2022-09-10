<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::create([
            'id' => '1',
            'nama' => 'PT. Aneka Terpal',
            'email' => 'pt.anekaterpal@gmail.com',
            'password' => Hash::make("123"),
            'akses' => 'pemilik',
            'no_hp' => '6281994466852',
            'alamat' => 'Jl. Dharmapala, Kb. IX, Kec. Sungai Gelam, Kabupaten Muaro Jambi, Jambi 36374',
        ]);

        \App\Pemilik::create([
            'id' => '1',
            'user_id' => $user->id,
            'province_id' => '8',
            'city_id' => '156',
            'deskripsi' => 'Aneka Terpal (AT) Merupakan sebuah perusahaan yang bergerak di Bidang Terpal. PT. Aneka Terpal (AT) yang beralamat di jalan. Dharmapala, No. 1, Air Hitam, Muaro Jambi, yang dipimpin oleh Sofian G yang berdiri sejak 2015. Perusahaan ini berdiri  karena melihat peluang bisnis terpal ini sangatlah besar dan memiliki prospek yang bagus terutama di Kota Jambi. PT. Aneka Terpal sendiri telah melayani berbagai pesanan baik itu mulai dari ukuran yang besar atau pun kecil, dan dalam juga dalam jumlah yang banyak. Aneka Terpal sendiri juga telah memberikan pelayanan yang terbaik dan selalu meningkatan kualitas pelayanannya. Aneka Terpal juga memberikan layanan berupa perbaikan terpal yang rusak, seperti koyak atau pun berlubang selama produk tersebut adalah produk Aneka Terpal. PT. Aneka Terpal juga tidak hanya menjual produk di dalam kota saja, tetapi bisa menjangkau sampai luar kota jambi.',
            'peta_gmap' => '<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15952.644162796347!2d103.6654145!3d-1.6514826!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x660332fb30311974!2sAneka%20Terpal!5e0!3m2!1sid!2sid!4v1658449021291!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>'
        ]);

        $admin = \App\User::create([
            'id' => '2',
            'nama' => 'admin1',
            'email' => 'admin1@gmail.com',
            'password' => Hash::make('123'),
            'akses' => 'admin',
            'no_hp' => '6288785385334',
            'alamat' => 'Jl. Dharmapala, Kb. IX, Kec. Sungai Gelam, Kabupaten Muaro Jambi, Jambi 36374',
        ]);

        \App\Admin::create([
            'id' => '1',
            'user_id' => $admin->id,
            'jk' => 'laki-laki',
        ]);


        $pelanggan = \App\User::create([
            'id' => '3',
            'nama' => 'pelanggan1',
            'email' => 'pelanggan1@gmail.com',
            'password' => Hash::make('123'),
            'akses' => 'pelanggan',
            'no_hp' => '62887543535334',
            'alamat' => 'Jl. Mawar No. 22',    
        ]);

        \App\Pelanggan::create([
            'id' => '1',
            'user_id' => $pelanggan->id,
            'city_id' => '62',
            'province_id' => '4',
            'jk' => 'laki-laki',
        ]);
    }
}
