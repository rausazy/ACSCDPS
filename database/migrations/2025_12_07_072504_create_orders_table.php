<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();

        // Customer Info
        $table->string('customer_name')->nullable();
        $table->string('customer_email')->nullable();
        $table->string('customer_phone')->nullable();
        $table->string('customer_address')->nullable();

        // Quotation Info
        $table->string('product_name');
        $table->integer('quantity');
        $table->decimal('cost_per_piece', 10, 2)->default(0);
        $table->decimal('markup', 10, 2)->default(0);
        $table->decimal('selling_price_per_piece', 10, 2)->default(0);
        $table->decimal('discount_percentage', 10, 2)->default(0);
        $table->decimal('total_price', 12, 2)->default(0);

        // Json for raw materials & costing
        $table->json('raw_materials')->nullable();
        $table->decimal('overall_cost', 12, 2)->default(0);

        $table->timestamps();
    });
}
};
