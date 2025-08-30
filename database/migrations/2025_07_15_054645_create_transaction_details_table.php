<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade');

            $table->integer('qty');
            $table->integer('price');
            $table->integer('subtotal');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('transaction_details');
    }
};
