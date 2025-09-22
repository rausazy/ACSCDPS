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
        Schema::create('raw_materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_id'); // Link to parent stock (e.g., Shirt)
            $table->string('name'); // Raw material name (e.g., Cotton Fabric)
            $table->integer('quantity')->default(0);
            $table->decimal('price', 10, 2)->default(0);
            $table->timestamps();

            // Foreign key to stocks
            $table->foreign('stock_id')
                  ->references('id')
                  ->on('stocks')
                  ->onDelete('cascade'); // kapag na-delete yung stock, delete din raw materials
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raw_materials');
    }
};
