<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengirimansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengirimans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('penjualan_id');
            $table->integer('city_id');
            $table->integer('province_id');
            $table->string('no_resi')->nullable();
            $table->string('jasa_pengirim');
            $table->integer('berat');
            $table->string('estimasi_waktu');
            $table->integer('biaya_pengiriman');
            $table->text('alamat_pengiriman');
            $table->enum('status_pengiriman', ['sedang dikemas', 'dikirim', 'diterima']);
            $table->text('keterangan')->nullable();
            $table->text('catatan_pengiriman')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengirimans');
    }
}
