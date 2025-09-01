<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_master_id');
            $table->unsignedBigInteger('product_id');
            $table->decimal('rate', 12, 2);
            $table->integer('quantity');
            $table->decimal('amount', 12, 2);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('purchase_master_id')->references('id')->on('purchase_masters')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_details');
    }
};
