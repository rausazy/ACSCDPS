<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('stockable_id');
    $table->string('stockable_type');
    $table->integer('quantity')->default(0);
    $table->timestamps();
});
    }

    public function down()
    {
        Schema::table('stocks', function (Blueprint $table) {
            // rollback (balik sa dati kung may product_id)
            $table->dropColumn(['stockable_id', 'stockable_type']);
            $table->unsignedBigInteger('product_id')->nullable();
        });
    }
};
