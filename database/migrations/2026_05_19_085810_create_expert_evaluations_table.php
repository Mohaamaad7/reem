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
        Schema::create('expert_evaluations', function (Blueprint $table) {
            $table->id();
            $table->string('evaluator_name')->nullable();
            
            // القسم الأول (1-8)
            for ($i = 1; $i <= 8; $i++) {
                $table->tinyInteger("q1_$i")->nullable();
            }
            
            // القسم الثاني (9-14)
            for ($i = 9; $i <= 14; $i++) {
                $table->tinyInteger("q2_$i")->nullable();
            }
            
            // القسم الثالث (15-17)
            for ($i = 15; $i <= 17; $i++) {
                $table->tinyInteger("q3_$i")->nullable();
            }
            
            // القسم الرابع (18-27)
            for ($i = 18; $i <= 27; $i++) {
                $table->tinyInteger("q4_$i")->nullable();
            }
            
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expert_evaluations');
    }
};
