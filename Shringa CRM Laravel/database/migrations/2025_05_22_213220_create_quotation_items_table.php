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
        Schema::create('quotation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained()->onDelete('cascade');
            $table->text('description');
            $table->decimal('quantity', 10, 2)->default(1.00);
            $table->string('unit')->nullable();
            $table->decimal('unit_price', 10, 2)->default(0.00);
            $table->decimal('amount', 10, 2)->default(0.00);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_section_header')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_items');
    }
};
