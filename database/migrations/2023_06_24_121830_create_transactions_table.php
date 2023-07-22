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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('outlet_id')->references('id')->on('outlets')->onDelete('Cascade');
            $table->foreignId('product_id')->references('id')->on('products')->onDelete('Cascade');
            $table->foreignId('variation_id')->references('id')->on('product_variations')->onDelete('Cascade');
            $table->foreignId('supplier_id')->references('id')->on('suppliers')->onDelete('Cascade');
            $table->string('sku_id')->nullable();
            $table->integer('quantity');
            $table->integer('stock_after_transaction')->default(0);
            $table->string('type')->comment('in,out');
            $table->tinyInteger('is_adjust')->default(0)->comment('1 for adjust yes and 0 for no adjust');
            $table->text('note')->nullable();
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->onDelete('Cascade');

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
        Schema::dropIfExists('transactions');
    }
};
