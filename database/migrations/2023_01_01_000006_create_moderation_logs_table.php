<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('moderation_logs', function (Blueprint $table) {
            $table->id();
            $table->string('content_type');
            $table->string('content_id');
            $table->string('action');
            $table->foreignId('admin_id')->constrained('users');
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('moderation_logs');
    }
};