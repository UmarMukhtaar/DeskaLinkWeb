<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('google_id', 50)->nullable();
            $table->string('username')->unique();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('phone', 20);
            $table->string('password');
            $table->enum('role', ['client', 'partner', 'admin']);
            $table->enum('status', ['active', 'banned'])->default('active');
            $table->string('profile_photo_url')->default('https://i.postimg.cc/qqChrG8y/profile.png');
            $table->text('description')->nullable();
            $table->boolean('is_profile_completed')->default(false);
            $table->decimal('balance', 10, 2)->default(0.00);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration
// {
//     public function up()
//     {
//         Schema::create('users', function (Blueprint $table) {
//             $table->string('user_id', 20)->primary();
//             $table->string('google_id', 50)->nullable();
//             $table->string('username', 50);
//             $table->string('password')->nullable();
//             $table->string('full_name', 100);
//             $table->string('email', 100)->unique();
//             $table->string('phone', 20);
//             $table->enum('role', ['client', 'partner', 'admin'])->default('client');
//             $table->enum('status', ['active', 'suspended', 'banned'])->default('active');
//             $table->string('profile_photo_url')->default('https://i.postimg.cc/qqChrG8y/profile.png');
//             $table->text('description')->nullable();
//             $table->boolean('is_profile_completed')->default(false);
//             $table->text('bio')->nullable();
//             $table->timestamps();
//         });
//     }

//     public function down()
//     {
//         Schema::dropIfExists('users');
//     }
// };