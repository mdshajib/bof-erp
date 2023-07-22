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
        Schema::create('sales_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('outlet_id')->references('id')->on('outlets')->onDelete('Cascade');
            $table->foreignId('sales_order_id')->references('id')->on('sales_orders')->onDelete('Cascade');
            $table->foreignId('product_id')->references('id')->on('products')->onDelete('Cascade');
            $table->foreignId('variation_id')->nullable()->references('id')->on('product_variations')->onDelete('Cascade');
            $table->foreignId('supplier_id')->nullable()->references('id')->on('suppliers')->onDelete('Cascade');
            $table->string('sku_id')->nullable();
            $table->float('unit_sales_price', 8, 2);
            $table->float('cogs_price', 8, 2);
            $table->float('quantity', 8, 2);
            $table->float('gross_amount', 8, 2);
            $table->foreignId('applied_discount_id')->nullable()->references('id')->on('discounts')->onDelete('Cascade');
            $table->float('discount_amount', 8, 2)->default(0);
            $table->float('total_discount_amount', 8, 2)->default(0);
            $table->float('tax_amount', 8, 2)->default(0);
            $table->float('total_sales_price', 8, 2)->default(0);
            $table->string('note')->nullable();
            $table->tinyInteger('is_exchanged')->default(0);
            $table->integer('exchanged_quantity')->default(0);
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();

            $table->softDeletes($column = 'deleted_at', $precision = 0);

            $table->foreign('sku_id')->references('id')->on('skus')->onDelete('Cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_items');
    }
};
