<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('pelanggan_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('kode');
            $table->string('nama_pelanggan')->nullable();
            $table->enum('status_penjualan', ['ditolak', 'belum bayar', 'lunas']);
            $table->integer('disc_point')->default(0);
            $table->integer('total');
            $table->integer('uang_penjualan')->default(0);
            $table->enum('metode_pembayaran', ['transfer-bank', 'cod', 'cash'])->default('transfer-bank');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualans');
    }
}
