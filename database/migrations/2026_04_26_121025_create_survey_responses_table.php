<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participant_id')->constrained()->onDelete('cascade');
            $table->string('participant_code', 10);
            $table->string('participant_name', 100);

            // أداة التصميم
            $table->string('fabric_chosen', 50)->nullable();
            $table->string('pattern_chosen', 50)->nullable();
            $table->tinyInteger('tool_ease_rating')->nullable();        // 1-5
            $table->tinyInteger('tool_visual_rating')->nullable();      // 1-5

            // المحتوى التعليمي
            $table->tinyInteger('morris_knowledge_before')->nullable(); // 1-5
            $table->tinyInteger('morris_knowledge_after')->nullable();  // 1-5
            $table->tinyInteger('technique_clarity')->nullable();       // 1-5
            $table->tinyInteger('eco_fabric_awareness')->nullable();    // 1-5

            // التقييم العام
            $table->tinyInteger('app_overall_rating')->nullable();      // 1-5
            $table->tinyInteger('app_usefulness')->nullable();          // 1-5
            $table->tinyInteger('would_recommend')->nullable();         // 1-5

            // أسئلة مفتوحة
            $table->text('most_liked')->nullable();
            $table->text('improvement_suggestions')->nullable();
            $table->text('design_ideas')->nullable();

            // metadata
            $table->enum('language_used', ['ar', 'en'])->default('ar');
            $table->string('device_type', 50)->nullable();
            $table->integer('time_spent_seconds')->nullable();
            $table->boolean('synced_to_sheets')->default(false);
            $table->string('sheets_row_id', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survey_responses');
    }
};
