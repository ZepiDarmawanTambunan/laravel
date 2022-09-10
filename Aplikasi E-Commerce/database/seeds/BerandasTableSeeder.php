<?php

use Illuminate\Database\Seeder;

class BerandasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Beranda::create([
            'judul' => 'BERANDA USER (PEMILIK)',
            'sub_judul' => 'Selamat datang dihalaman beranda pemilik. jika anda baru pertama kali menggunakan website ini alangkah baiknya untuk membaca penjelasan tentang website ini',
            'deskripsi' => 'Selamat datang dihalaman beranda pemilik. dihalaman ini anda bisa merubah beranda milik pemilik, admin dan juga pelanggan. untuk foto anda bisa gunakan jika ada pengumuman atau event tertentu ke pelanggan aneka terpal dan untuk video anda bisa gunakan sebagai panduan / tutorial penggunaan website aneka terpal. ada pun foto untuk admin anda bisa gunakan pengumuman info untuk admin. adapun foto pada pemilik digunakan untuk pemilik mengetahui beberapa fitur pada website ini. dan video disebelah kanan atas juga berupa tutorial penggunaan website ini. Fitur yang bisa digunakan oleh pemilik diantaranya adalah: mengelola beranda, mengelola user, mengelola produk, mengelola diskon, mengelola penjualan, mengelola pembayaran, mengelola penigriman, mengelola kebijakan, mengelola rekning dan melihat laporan.',
            'image' => '',
            'video' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/XSsVP1fV1mU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
            'status' => 'pemilik',
            'user_id' => '1',
        ]);

        \App\Beranda::create([
            'judul' => 'BERANDA USER (ADMIN)',
            'sub_judul' => 'Tutorial dan penjelasan fitur - fitur dianeka terpal berserta cara penggunaan nya.',
            'deskripsi' => 'Selamat Datang di Halaman Beranda (Admin) PT. Aneka Terpal.
            Pada halaman beranda ini terdapat beberapa fitur untuk mengelolah pesanan pelanggan, baik itu offline ataupun online.
            Disini fitur fitur yang ada seperti :
            -Fitur Profil : Pada fitur ini admin dapat mengelolah data profilnya
            -Fitur User : Pada fitur ini berguna untuk mengelolah data user baik itu menambah user baru, mengedit, atau pun menghapus
            -Fitur Produk : Pada fitur ini admin mengelola data jenis jenis produk yang ada pada PT. Aneka Terpal
            -Fitur Diskon : Pada fitur ini admin mengelola kode diskon yang dapat di berikan kepada pembeli
            -Fitur Penjualan : Ini adalah fitur untuk admin mengelola data penjualan produk PT. Aneka Terpal
            -Fitur Pembayaran : Pada fitur ini admin melakukan pengecekan data pembayaran yang telah di bayar oleh pelanggan
            -Fitur Pengiriman : Pada fitur ini admin mengelola data pengiriman dan juga pengiriman produk ke pelanggan
            -Fitur Kebijakan : Pada fitur ini admin dapat mengelola kebijakan 
            
            Kemudian pada tampilan beranda juga memiliki Fitur pengumuman berupa foto yang bisa digunakan untuk pemberian promosi, DLL
            kemudian di sebelah kanan fitur pengumuman terdapat video yang berisi tutorial penggunaan website.',
            'image' => '',
            'video' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/XSsVP1fV1mU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
            'status' => 'admin',
            'user_id' => '1',
        ]);

        \App\Beranda::create([
            'judul' => 'BERANDA USER (PELANGGAN)',
            'sub_judul' => 'Tutorial dan penjelasan fitur - fitur dianeka terpal berserta cara penggunaan nya.',
            'deskripsi' => 'Selamat Datang di Halaman Beranda (Pelanggan) PT. Aneka Terpal.
            Pada halaman beranda ini terdapat beberapa fitur untuk mengelolah pesanan pelanggan, baik itu offline ataupun online.
            Disini fitur fitur yang ada seperti :
            -Fitur Profil : Pada fitur ini pelanggan dapat mengelolah data profilnya
            -Fitur Produk : Pada fitur ini pelanggan dapat melihat produk yang tersedia pada PT. Aneka Terpal
            -Fitur Pesanan : Pada fitur ini pelanggan dapat melakukan pengecekan terhadap produk yang ingin di beli, dan juga melakukan konfirmasi pembayaran, dan juga bisa melihat status pengiriman produk
            -Fitur Hubungi Kami : Pada fitur ini pelanggan dapat melihat nomor yang dapat di hubungin jika terdapat keluhan atau pun ingin melakukan negosiasi.
            -Fitur Kebijakan : Pada fitur ini berisi kebijakan pada PT. Aneka Terpal yang harus diikuti ketika melakukan pembelian produk
            Fitur Tentang Kami : fitur di mana terdapat informasi tentang PT. Aneka Terpal  yang dapat di lihat oleh pelanggan.
            
            Kemudian pada tampilan beranda juga memiliki Fitur pengumuman berupa foto yang bisa digunakan untuk melihat adanya promosi, DLL
            kemudian di sebelah kanan fitur pengumuman terdapat video yang berisi tutorial penggunaan website.',
            'image' => '',
            'video' => '<iframe width="560" height="315" src="https://www.youtube.com/embed/XSsVP1fV1mU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
            'status' => 'pelanggan',
            'user_id' => '1',
        ]);
    }
}
