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
        DB::unprepared('
            CREATE TRIGGER t_ai_produk
            AFTER INSERT ON detail_pemesanans
            FOR EACH ROW
            BEGIN
                UPDATE produks
                SET stok = stok - NEW.qty
                WHERE id = NEW.produk_id;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS t_ai_produk;');
    }
};
