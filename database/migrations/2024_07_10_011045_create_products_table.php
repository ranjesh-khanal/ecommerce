<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // ['category_id', 'name', 'slug', 'featured_image', 'price', 'description'];
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->onConstrained('categories')->onDelete('CASCADE');
            $table->string('name')->unique();
            $table->string('slug');
            $table->string('feature_image');
            $table->decimal('price', 10, 2)->default(0);
            $table->longText('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
