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
        Schema::create('variation_metas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->references('id')->on('products')->onDelete('Cascade');
            $table->foreignId('variation_id')->nullable()->references('id')->on('product_variations')->onDelete('Cascade');
            $table->string('key')->nullable();
            $table->string('value')->nullable();
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
        Schema::dropIfExists('variation_metas');
    }
};
