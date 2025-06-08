<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class UpdateStatusEnumInOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Menggunakan raw query karena Laravel tidak mendukung langsung modify ENUM
        DB::statement("ALTER TABLE orders MODIFY status ENUM('held', 'released', 'refunded', 'completed') DEFAULT 'held'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Kembali ke bentuk sebelumnya tanpa 'completed'
        DB::statement("ALTER TABLE orders MODIFY status ENUM('held', 'released', 'refunded') DEFAULT 'held'");
    }
}