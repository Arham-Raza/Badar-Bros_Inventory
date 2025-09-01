<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('account_type', ['customer', 'supplier', 'cash', 'bank']);
            $table->string('email')->nullable();
            $table->string('cnic')->nullable();
            $table->string('mobile1')->nullable();
            $table->string('mobile2')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('address')->nullable();
            $table->string('iban')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_title')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
