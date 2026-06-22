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
        Schema::create('culinaries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category_type')->nullable(); // Makanan, Minuman, dll
            $table->string('image')->nullable();
            $table->string('badge')->nullable();
            $table->string('location')->nullable();
            $table->decimal('rating', 3, 1)->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->string('status')->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('culinaries');
    }
};
