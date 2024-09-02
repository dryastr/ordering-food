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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('code_order')->unique();
            $table->string('customer');
            $table->string('table_number')->nullable();
            $table->foreignId('pelayan_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('qty');
            $table->foreignId('menu_id')->constrained('menu_items')->onUpdate('cascade')->onDelete('cascade');
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
