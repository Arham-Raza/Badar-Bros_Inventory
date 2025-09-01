<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_id')->nullable();
            $table->unsignedBigInteger('account_id'); // The account (cash/bank) receiving or paying
            $table->unsignedBigInteger('counterparty_id'); // The vendor/customer
            $table->decimal('amount', 15, 2);
            $table->date('transaction_date');
            $table->string('transaction_no')->nullable();
            $table->enum('type', ['payment', 'receiving']);
            $table->string('payment_term')->nullable();
            $table->string('cheque_no')->nullable();
            $table->date('cheque_date')->nullable();
            $table->string('po_no')->nullable();
            $table->date('po_date')->nullable();
            $table->date('online_transfer_date')->nullable();
            $table->text('note')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('purchase_id')->references('id')->on('purchase_masters')->onDelete('set null');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('restrict');
            $table->foreign('counterparty_id')->references('id')->on('accounts')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
