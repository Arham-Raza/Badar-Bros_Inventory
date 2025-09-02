<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('sale_product_licenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_detail_id');
            $table->string('license_name')->nullable();
            $table->string('license_no')->nullable();
            $table->date('license_issue_date')->nullable();
            $table->string('issued_by')->nullable();
            $table->string('cnic_no')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('weapon_type')->nullable();
            $table->string('weapon_no')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('sale_detail_id')->references('id')->on('sales_details')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sale_product_licenses');
    }
};
