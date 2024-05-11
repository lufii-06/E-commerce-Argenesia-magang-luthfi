<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('toko_id')->references('id')->on('tokos')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name');
            $table->string('nohp');
            $table->text('alamat');
            $table->date('tanggal');
            $table->integer('total');
            $table->boolean('status');
            $table->text('jenispembayaran');
            $table->text('buktipembayaran')->nullable();
            $table->text('resipengiriman')->nullable();
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
        Schema::dropIfExists('pemesanans');
    }
};
