<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('cashier');
            $table->string('customer')->nullable();
            $table->integer('total');
            $table->integer('discount')->default(0);
            $table->integer('pay');
            $table->integer('change');
            $table->timestamps();
        });
    }
};
