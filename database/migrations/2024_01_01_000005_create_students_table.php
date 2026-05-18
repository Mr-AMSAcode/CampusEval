<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->string('student_number')->comment('Numéro étudiant universitaire');
            $table->date('enrollment_date');
            $table->enum('status', ['active', 'inactive', 'graduated', 'suspended'])->default('active');
            $table->unsignedInteger('evaluations_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            $table->unique(['class_id', 'user_id']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
