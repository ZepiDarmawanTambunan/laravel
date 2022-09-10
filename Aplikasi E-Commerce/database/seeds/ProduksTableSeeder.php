<?php

use Illuminate\Database\Seeder;

class ProduksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Produk::create([
            'id' => '1',
            'nama' => 'terpal sakura korea 2x2',
            'kode_barang' => 'B-0001',
            'image' => '',
            'berat' => '600',
            'harga' => '25000',
            'jumlah' => '56',
            'deskripsi' => 'Kualitas dari Bahan Premium cocok untuk melindungi barang anda dari segala cuaca : tahan terhadap panas teriknya matahari dan tahan terhadap air hujan.
            Ukuran kurang +/- 0,2 m setiap sisi dikarenakan bahan waktu proses pinggirannya dilipat / ditekuk. Yang dilipat/ditekuk 2 yaitu sisi kiri dan kanannya dipress mesin utk tempat lubang ring. Bahan lebar max 2 m sehingga perlu utk sambungannya apabila ukuran lebih dari 2 m di satu sisi maka bahan berkurang lagi +/- 0,2 meter utk setiap proses sambungannya',
            'user_id' => '1',
        ]);

        \App\Produk::create([
            'id' => '2',
            'nama' => 'terpal gajah 3x6',
            'kode_barang' => 'B-0002',
            'image' => '',
            'berat' => '700',
            'harga' => '36000',
            'jumlah' => '43',
            'deskripsi' => 'Sudah di PATENT kan sehingga Terpal Cap Titanium ini hanya dapat dibeli di toko kami saja 👍👍👍
            BISA TAHAN 4 TAHUN LEBIH (pemakaian tidak kasar)
            BAHAN PLASTIK VIRGIN ORI, tidak ada campuran plastik daur ulang
            Ciri bahan yang bagus : warna terpal Cerah, Pekat dan Mengkilat
            
            SUDAH TERMASUK mata ayam tiap 1meter dan tiap ujung
            SUDAH TERMASUK tali tampar di pinggiran terpal
            dijamin TIDAK TEMBUS AIR, jahitan dari mesin press dijamin KUAT dan RAPI
            direkomendasikan untuk penggunaan yang banyak terkena sinar matahari',
            'user_id' => '1',
        ]);

        \App\Produk::create([
            'id' => '3',
            'nama' => 'terpal sakura 4x4',
            'kode_barang' => 'B-0003',
            'image' => '',
            'berat' => '750',
            'harga' => '48000',
            'jumlah' => '60',
            'deskripsi' => 'Terpal sakura salur tersedia dengan ukuran 1 rol yaitu lebar bahan 4m dan panjang bahan 50m, dengan ketebalan bahan hingga 0,35 s/d 0,38 yang sangat kuat dan tahan lama. Konsumen dapat memesan ukuran dan bentuk sesuai permintaan konsumen dan tiap sisi terpal dipres mesin dengan tali kasat dan lubang ring.',
            'user_id' => '1',
        ]);

        \App\Produk::create([
            'id' => '4',
            'nama' => 'terpal singa 4x3',
            'kode_barang' => 'B-0004',
            'image' => '',
            'berat' => '650',
            'harga' => '28000',
            'jumlah' => '50',
            'deskripsi' => 'Terpal / tenda jadi pada produk ini adalah terpal yang telah disisipkan tali di sekeliling tepian nya dan diberikan ring / cincin juga di sekelilinganya sebagai tempat mengikat tali atau tempat cantolan penahan.

            Penggunaan terpal / tenda jadi ini yakni:
            - sebagai kolam ikan terutama kolam ikan lele, kolam ikan nila.
            - penutup barang jualan
            - penahan hujan dan panas matahari untuk kios2 non permanen
            - penutup bak mobil barang
            - penahan air / hujan sementara terhadap benda yang hendak dilindungi
            
            Ukuran asli barang akan berkurang +- 15cm disebabkan pembuatan pinggiran terpal yang disisipkan tali. Ukuran asli akan berkurang lebih dari 15cm jika terpal jadi / tenda jadi yang anda beli adalah ukuran besar (disebabkan penyambungan terpal menjadi ukuran besar).
            Harap lakukan diskusi melalui kolom chat agar produk ini tetap sesuai dengan kebutuhan anda.',
            'user_id' => '1',
        ]);

        \App\Produk::create([
            'id' => '5',
            'nama' => 'terpal pelangi 2x6',
            'kode_barang' => 'B-0005',
            'image' => '',
            'berat' => '660',
            'harga' => '32000',
            'jumlah' => '44',
            'deskripsi' => 'Terpal / tenda jadi pada produk ini adalah terpal yang telah disisipkan tali di sekeliling tepian nya dan diberikan ring / cincin juga di sekelilinganya sebagai tempat mengikat tali atau tempat cantolan penahan.

            Penggunaan terpal / tenda jadi ini yakni:
            - sebagai kolam ikan terutama kolam ikan lele, kolam ikan nila.
            - penutup barang jualan
            - penahan hujan dan panas matahari untuk kios2 non permanen
            - penutup bak mobil barang
            - penahan air / hujan sementara terhadap benda yang hendak dilindungi
            
            Ukuran asli barang akan berkurang +- 15cm disebabkan pembuatan pinggiran terpal yang disisipkan tali. Ukuran asli akan berkurang lebih dari 15cm jika terpal jadi / tenda jadi yang anda beli adalah ukuran besar (disebabkan penyambungan terpal menjadi ukuran besar).
            Harap lakukan diskusi melalui kolom chat agar produk ini tetap sesuai dengan kebutuhan anda.',
            'user_id' => '1',
        ]);

        \App\Produk::create([
            'id' => '6',
            'nama' => 'barang 1',
            'kode_barang' => 'B-0006',
            'image' => '',
            'berat' => '610',
            'harga' => '18000',
            'jumlah' => '44',
            'deskripsi' => 'Terpal / tenda jadi pada produk ini adalah terpal yang telah disisipkan tali di sekeliling tepian nya dan diberikan ring / cincin juga di sekelilinganya sebagai tempat mengikat tali atau tempat cantolan penahan.

            Penggunaan terpal / tenda jadi ini yakni:
            - sebagai kolam ikan terutama kolam ikan lele, kolam ikan nila.
            - penutup barang jualan
            - penahan hujan dan panas matahari untuk kios2 non permanen
            - penutup bak mobil barang
            - penahan air / hujan sementara terhadap benda yang hendak dilindungi
            
            Ukuran asli barang akan berkurang +- 15cm disebabkan pembuatan pinggiran terpal yang disisipkan tali. Ukuran asli akan berkurang lebih dari 15cm jika terpal jadi / tenda jadi yang anda beli adalah ukuran besar (disebabkan penyambungan terpal menjadi ukuran besar).
            Harap lakukan diskusi melalui kolom chat agar produk ini tetap sesuai dengan kebutuhan anda.',
            'user_id' => '1',
        ]);
    }
}
