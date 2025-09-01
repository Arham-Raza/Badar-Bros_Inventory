<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('purchase_masters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id');
            $table->date('transaction_date');
            $table->string('transaction_no');
            $table->decimal('gross_amount', 12, 2);
            $table->decimal('discount_percentage', 5, 2)->nullable();
            $table->decimal('discount_amount', 12, 2)->nullable();
            $table->decimal('tax_amount', 12, 2)->nullable();
            $table->decimal('tax_percentage', 5, 2)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('vendor_id')->references('id')->on('accounts')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_masters');
    }
};
