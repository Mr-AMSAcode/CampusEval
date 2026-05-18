<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluation_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluation_id')->constrained('evaluations')->onDelete('cascade');
            $table->foreignId('criterion_id')->constrained('evaluation_criteria')->onDelete('cascade');
            $table->unsignedTinyInteger('score'); // 1 à 5
            $table->timestamps();
            
            $table->unique(['evaluation_id', 'criterion_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluation_details');
    }
};
