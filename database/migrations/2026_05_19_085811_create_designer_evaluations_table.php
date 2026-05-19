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
        Schema::create('designer_evaluations', function (Blueprint $table) {
            $table->id();
            $table->string('designer_name')->nullable();
            $table->string('factory_name')->nullable();
            
            for ($i = 1; $i <= 13; $i++) {
                $table->tinyInteger("f2_$i")->nullable();
            }
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('designer_evaluations');
    }
};
