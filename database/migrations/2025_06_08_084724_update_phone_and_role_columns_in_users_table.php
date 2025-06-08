<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class UpdatePhoneAndRoleColumnsInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Ubah kolom phone menjadi nullable
        DB::statement('ALTER TABLE users MODIFY phone VARCHAR(20) NULL');

        // Ubah kolom role menjadi nullable
        DB::statement("ALTER TABLE users MODIFY role ENUM('client', 'partner', 'admin') NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Kembalikan ke bentuk sebelumnya (NOT NULL dengan default)
        DB::statement("ALTER TABLE users MODIFY phone VARCHAR(20) NOT NULL DEFAULT ''");
        DB::statement("ALTER TABLE users MODIFY role ENUM('client', 'partner', 'admin') NOT NULL DEFAULT 'client'");
    }
}