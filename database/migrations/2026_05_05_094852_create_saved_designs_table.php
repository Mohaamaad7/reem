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
        Schema::create('saved_designs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participant_id')->constrained()->onDelete('cascade');
            $table->string('fabric_id')->nullable();
            $table->string('blend_mode')->default('multiply');
            $table->decimal('opacity', 3, 2)->default(0.80);
            $table->json('patterns_used')->nullable();
            $table->longText('canvas_json');
            $table->longText('preview_image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saved_designs');
    }
};
