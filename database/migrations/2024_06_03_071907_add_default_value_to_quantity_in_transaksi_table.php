<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultValueToQuantityInTransaksiTable extends Migration
{
    public function up()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->integer('quantity')->default(1)->change(); // Menambahkan nilai default 1
        });
    }

    public function down()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->integer('quantity')->default(null)->change(); // Mengembalikan perubahan
        });
    }
}
