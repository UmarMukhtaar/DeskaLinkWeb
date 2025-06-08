<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class UpdateStatus2EnumInOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Menambahkan 'canceled' ke dalam ENUM status
        DB::statement("ALTER TABLE orders MODIFY status ENUM('held', 'released', 'refunded', 'completed', 'canceled') DEFAULT 'held'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Kembali ke bentuk sebelumnya tanpa 'canceled'
        DB::statement("ALTER TABLE orders MODIFY status ENUM('held', 'released', 'refunded', 'completed') DEFAULT 'held'");
    }
}