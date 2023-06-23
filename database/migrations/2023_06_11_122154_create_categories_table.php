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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('type')->nullable();
            $table->tinyInteger('is_active')->default(1);
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
        Schema::dropIfExists('categories');
    }
};
