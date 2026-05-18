<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->morphs('evaluatable'); // teacher_id ou staff_id
            $table->float('rating', 3, 2); // Note sur 5
            $table->text('comment')->nullable();
            $table->boolean('is_anonymous')->default(true);
            $table->string('anonymized_hash')->nullable()->unique()->comment('Hash pour vérifier l\'anonymité');
            $table->timestamp('anonymous_until')->nullable();
            $table->enum('status', ['pending', 'published', 'flagged', 'deleted'])->default('pending');
            
            // Métadonnées anonymisation
            $table->boolean('shows_student_identity')->default(false);
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by_id')->nullable()->constrained('users')->onDelete('set null');
            
            $table->timestamps();
            $table->softDeletes();
            
            // Prévention des doublons
            $table->unique(['student_id', 'evaluatable_type', 'evaluatable_id']);
            
            // Index pour performances
            $table->index('evaluatable_type');
            $table->index('evaluatable_id');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
