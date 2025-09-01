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
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('make_id')->nullable()->after('category_id');
            $table->string('weapon_no')->nullable()->after('name');

            // If make_id references another table (e.g., makes)
            // $table->foreign('make_id')->references('id')->on('makes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop foreign key first if added
            // $table->dropForeign(['make_id']);
            $table->dropColumn(['make_id', 'weapon_no']);
        });
    }
};
