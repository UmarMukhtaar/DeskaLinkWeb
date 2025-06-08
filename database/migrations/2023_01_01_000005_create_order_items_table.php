<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders');
            $table->string('item_id'); // Can be design_id or service_id
            $table->enum('item_type', ['service', 'design']);
            $table->string('title');
            $table->decimal('price', 10, 2);
            $table->foreignId('partner_id')->constrained('users');
            $table->foreignId('client_id')->constrained('users');
            $table->enum('status', ['pending', 'delivered'])->default('pending');
            $table->string('result_url')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};