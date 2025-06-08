<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class UpdateStatusInOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Menggunakan raw query karena Laravel tidak mendukung langsung modify ENUM dengan Blueprint
        DB::statement("ALTER TABLE order_items MODIFY status ENUM('pending','completed','refunded','processing','canceled','delivered') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Kembali ke bentuk sebelumnya
        DB::statement("ALTER TABLE order_items MODIFY status ENUM('pending','delivered') DEFAULT 'pending'");
    }
}
