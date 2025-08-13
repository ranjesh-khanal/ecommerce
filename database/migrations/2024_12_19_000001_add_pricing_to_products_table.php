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
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('dealer_price', 10, 2)->nullable();
            $table->decimal('sub_dealer_price', 10, 2)->nullable();
            $table->decimal('retailer_price', 10, 2)->nullable();
            $table->decimal('freelancer_price', 10, 2)->nullable();
            $table->decimal('customer_price', 10, 2)->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->string('sku')->unique()->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('dimensions')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'dealer_price',
                'sub_dealer_price',
                'retailer_price',
                'freelancer_price',
                'customer_price',
                'stock_quantity',
                'sku',
                'weight',
                'dimensions',
                'is_featured',
                'is_active'
            ]);
        });
    }
};
