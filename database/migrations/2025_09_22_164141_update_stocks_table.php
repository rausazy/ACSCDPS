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
    Schema::table('stocks', function (Blueprint $table) {
        if (!Schema::hasColumn('stocks', 'stockable_id')) {
            $table->unsignedBigInteger('stockable_id')->nullable();
        }
        if (!Schema::hasColumn('stocks', 'stockable_type')) {
            $table->string('stockable_type')->nullable();
        }
    });
}

public function down(): void
{
    Schema::table('stocks', function (Blueprint $table) {
        $table->dropColumn(['stockable_id', 'stockable_type']);
    });
}
};
