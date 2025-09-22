<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        // Add valid_upto to sale_product_license
        Schema::table('sale_product_licenses', function (Blueprint $table) {
            $table->date('valid_upto')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        // Drop valid_upto from sale_product_license
        Schema::table('sale_product_licenses', function (Blueprint $table) {
            $table->dropColumn('valid_upto');
        });
    }
};
