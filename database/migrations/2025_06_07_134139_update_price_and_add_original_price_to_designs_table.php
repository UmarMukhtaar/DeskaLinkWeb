<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class UpdatePriceAndAddOriginalPriceToDesignsTable extends Migration
{
    public function up()
    {
        // Ubah tipe data price menjadi DECIMAL(13, 2)
        DB::statement('ALTER TABLE designs MODIFY price DECIMAL(13, 2)');
        
        // Tambahkan kolom original_price
        Schema::table('designs', function (Blueprint $table) {
            $table->decimal('original_price', 13, 2)->nullable()->after('price');
        });
    }

    public function down()
    {
        // Kembalikan price ke DECIMAL(10, 2), hapus original_price
        Schema::table('designs', function (Blueprint $table) {
            $table->dropColumn('original_price');
        });

        DB::statement('ALTER TABLE designs MODIFY price DECIMAL(10, 2)');
    }
}
