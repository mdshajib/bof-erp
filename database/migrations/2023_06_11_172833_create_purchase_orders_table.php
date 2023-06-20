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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('outlet_id')->references('id')->on('outlets')->onDelete('Cascade');
            $table->string('purchase_number')->nullable();
            $table->float('gross_amount', 8, 2)->default(0);
            $table->float('discount_amount', 8, 2)->default(0);
            $table->float('net_payment_amount', 8, 2)->default(0);
            $table->date('order_date')->nullable();
            $table->foreignId('generated_by')->references('id')->on('users')->onDelete('Cascade');
            $table->text('internal_comments')->nullable();
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
        Schema::dropIfExists('purchase_orders');
    }
};
