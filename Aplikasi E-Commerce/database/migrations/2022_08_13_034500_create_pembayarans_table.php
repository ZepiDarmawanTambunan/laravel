<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('penjualan_id');
            $table->integer('user_id')->nullable();
            $table->integer('rekening_id');
            $table->dateTime('tgl_pembayaran')->useCurrent();
            $table->integer('uang_pembayaran');
            $table->string('image');
            $table->enum('status_pembayaran', ['ditolak', 'sedang diproses', 'diterima']);
            $table->text('keterangan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembayarans');
    }
}
