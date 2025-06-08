<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStatusInServicesTable extends Migration
{
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'banned'])->default('pending')->change();
        });
    }

    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive'])->default('active')->change();
        });
    }
}
