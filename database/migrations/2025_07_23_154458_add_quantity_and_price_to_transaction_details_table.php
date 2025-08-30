<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::table('transaction_details', function (Blueprint $table) {
        if (!Schema::hasColumn('transaction_details', 'quantity')) {
            $table->integer('quantity')->default(1);
        }
        // Kolom 'price' sudah ada, jadi jangan ditambahkan lagi
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_details', function (Blueprint $table) {
            //
        });
    }
};
