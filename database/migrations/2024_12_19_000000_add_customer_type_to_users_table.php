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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('customer_type', ['dealer', 'sub_dealer', 'retailer', 'freelancer', 'end_customer'])->default('end_customer');
            $table->string('phone')->nullable();
            $table->string('company_name')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('country')->default('Nepal');
            $table->boolean('phone_verified')->default(false);
            $table->boolean('email_verified')->default(false);
            $table->string('verification_token')->nullable();
            $table->text('documents')->nullable(); // JSON field for uploaded documents
            $table->boolean('is_approved')->default(false);
            $table->timestamp('approved_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'customer_type',
                'phone',
                'company_name',
                'address',
                'city',
                'state',
                'zip_code',
                'country',
                'phone_verified',
                'email_verified',
                'verification_token',
                'documents',
                'is_approved',
                'approved_at'
            ]);
        });
    }
};
