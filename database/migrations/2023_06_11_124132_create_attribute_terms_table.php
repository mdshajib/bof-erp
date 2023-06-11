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
        Schema::create('attribute_terms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attribute_id')->references('id')->on('attributes')->onDelete('Cascade');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();

            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_terms');
    }
};
