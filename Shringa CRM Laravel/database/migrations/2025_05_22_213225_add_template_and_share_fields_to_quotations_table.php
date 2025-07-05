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
        Schema::table('quotations', function (Blueprint $table) {
            $table->string('share_link_token')->nullable()->after('expiry_date');
            $table->datetime('last_viewed_by_client_at')->nullable()->after('viewed_at');
            $table->string('brand_style')->default('classic')->after('template_used');
            // Add an items JSON column for simple quotations that don't need full line items
            $table->json('items')->nullable()->after('notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn(['share_link_token', 'last_viewed_by_client_at', 'brand_style', 'items']);
        });
    }
};
