<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('item_id'); // Can be design_id or service_id
            $table->enum('item_type', ['service', 'design']);
            $table->string('title');
            $table->decimal('price', 10, 2);
            $table->string('thumbnail');
            $table->foreignId('partner_id')->constrained('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
};