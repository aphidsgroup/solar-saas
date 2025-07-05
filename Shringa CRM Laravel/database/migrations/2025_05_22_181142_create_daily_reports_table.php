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
        Schema::create('daily_reports', function (Blueprint $table) {
            $table->id();
            $table->date('report_date');
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('work_completed');
            $table->text('challenges')->nullable();
            $table->text('next_steps')->nullable();
            $table->text('materials_used')->nullable();
            $table->string('weather_conditions')->nullable();
            $table->unsignedTinyInteger('progress_percentage')->default(0);
            $table->text('remarks')->nullable();
            $table->boolean('client_updated')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_reports');
    }
};
