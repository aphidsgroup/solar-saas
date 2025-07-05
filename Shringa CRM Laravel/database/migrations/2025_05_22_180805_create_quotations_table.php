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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('quotation_number')->unique();
            $table->foreignId('lead_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('client_id')->nullable()->constrained()->nullOnDelete();
            $table->string('template_used');
            $table->string('scope_type'); // Residential, Commercial, Retail
            $table->string('fee_structure'); // Per Room, Per Sq Ft, Package
            $table->decimal('subtotal', 12, 2);
            $table->decimal('gst_percentage', 5, 2)->default(18.00);
            $table->decimal('gst_amount', 12, 2);
            $table->decimal('total', 12, 2);
            $table->text('terms_and_conditions')->nullable();
            $table->string('status')->default('draft'); // draft, sent, viewed, accepted, rejected, expired
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('viewed_at')->nullable();
            $table->timestamp('expiry_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
