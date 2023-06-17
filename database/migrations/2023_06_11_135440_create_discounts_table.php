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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->references('id')->on('products')->onDelete('Cascade');
            $table->foreignId('variation_id')->nullable()->references('id')->on('product_variations')->onDelete('Cascade');
            $table->string('discount_type');
            $table->float('amount', 8, 2);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->integer('max_uses_user')->nullable();
            $table->integer('used_user')->nullable();
            $table->float('max_discount', 8, 2)->default(0);
            $table->float('min_discount', 8, 2)->default(0);
            $table->tinyInteger('is_active')->default(1);
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->onDelete('Cascade');
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->onDelete('Cascade');
            $table->foreignId('deleted_by')->nullable()->references('id')->on('users')->onDelete('Cascade');
            $table->timestamps();

            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
