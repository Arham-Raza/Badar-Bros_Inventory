<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->string('iban')->nullable()->after('address');
            $table->string('account_number')->nullable()->after('iban');
            $table->string('account_title')->nullable()->after('account_number');
        });
    }

    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn(['iban', 'account_number', 'account_title']);
        });
    }
};
