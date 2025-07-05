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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->string('milestone_type'); // Advance, Mid, Final
            $table->date('due_date');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('gst_percentage', 5, 2)->default(18.00);
            $table->decimal('gst_amount', 12, 2);
            $table->decimal('total', 12, 2);
            $table->decimal('amount_paid', 12, 2)->default(0.00);
            $table->decimal('amount_due', 12, 2);
            $table->string('status')->default('unpaid'); // unpaid, partially_paid, paid, overdue
            $table->text('payment_details')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
