<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateBalanceColumnInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Menggunakan raw query karena Laravel tidak mendukung langsung modify DECIMAL dengan Blueprint
        DB::statement('ALTER TABLE users MODIFY balance DECIMAL(13, 2) DEFAULT 0.00');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Kembalikan ke bentuk sebelumnya
        DB::statement('ALTER TABLE users MODIFY balance DECIMAL(10, 2) DEFAULT 0.00');
    }
}