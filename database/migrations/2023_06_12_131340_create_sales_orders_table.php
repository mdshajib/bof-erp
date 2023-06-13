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
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contact_id')->nullable();
            $table->string('order_number')->nullable();
            $table->string('order_status')->nullable();
            $table->float('gross_amount', 8, 2);
            $table->float('discount_amount', 8, 2)->default(0);
            $table->float('net_payment_amount', 8, 2);
            $table->string('payment_method')->nullable();
            $table->date('order_date')->nullable();
            $table->foreignId('generated_by')->references('id')->on('users')->onDelete('Cascade');
            $table->text('internal_comments')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('Cascade');
            $table->timestamps();

            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
