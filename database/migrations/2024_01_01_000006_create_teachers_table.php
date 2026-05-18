<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->string('specialty')->nullable();
            $table->text('qualifications')->nullable();
            $table->date('hire_date');
            $table->enum('status', ['active', 'inactive', 'on_leave', 'retired'])->default('active');
            $table->unsignedInteger('total_evaluations')->default(0);
            $table->decimal('average_rating', 3, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('status');
            $table->index('average_rating');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
