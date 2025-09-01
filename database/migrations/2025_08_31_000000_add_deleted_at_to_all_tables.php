<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        $tables = [
            'users',
            'accounts',
            'products',
            'product_categories',
            'product_makes',
            'purchase_masters',
            'purchase_details',
            'purchase_payments',
            'sales_masters',
            'sales_details',
            'transactions',
        ];
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) {
                    if (!Schema::hasColumn($table->getTable(), 'deleted_at')) {
                        $table->softDeletes();
                    }
                });
            }
        }
    }

    public function down()
    {
        $tables = [
            'users',
            'accounts',
            'products',
            'product_categories',
            'product_makes',
            'purchase_masters',
            'purchase_details',
            'purchase_payments',
            'sales_masters',
            'sales_details',
            'transactions',
        ];
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) {
                    if (Schema::hasColumn($table->getTable(), 'deleted_at')) {
                        $table->dropSoftDeletes();
                    }
                });
            }
        }
    }
};
