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
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('outlet_id')->references('id')->on('outlets')->onDelete('Cascade');
            $table->foreignId('purchase_order_id')->references('id')->on('purchase_orders')->onDelete('Cascade');
            $table->foreignId('product_id')->references('id')->on('products')->onDelete('Cascade');
            $table->foreignId('variation_id')->nullable()->references('id')->on('product_variations')->onDelete('Cascade');
            $table->foreignId('supplier_id')->nullable()->references('id')->on('suppliers')->onDelete('Cascade');
            $table->integer('quantity')->default(0);
            $table->float('selling_price', 8, 2)->default(0);
            $table->float('cogs_price', 8, 2)->default(0);
            $table->tinyInteger('loan')->default(0);
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();

            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_items');
    }
};
