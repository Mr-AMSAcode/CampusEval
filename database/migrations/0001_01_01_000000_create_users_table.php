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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            // Index unique sur matricle (évite erreur MySQL « clé trop longue »)
            // 1000 bytes max index length; charset utf8mb4 => réduire la taille.
            $table->string('matricule', 100)->unique('users_matricule_unique')->comment('Identifiant unique: GL.*, SR.*, ou PER.*CDI');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('name')->nullable()->comment('Nom complet (généralement first_name + last_name)');
            // Réduire longueur de l'index unique (MySQL/utf8mb4 erreur 1071)
            $table->string('email', 100)->unique('users_email_unique');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->enum('role', ['super_admin', 'student', 'teacher', 'staff'])->default('student');
            $table->boolean('is_active')->default(true);
            $table->string('phone')->nullable();
            $table->text('bio')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamp('last_login_at')->nullable();
            // Réduire longueur des index uniques (utf8mb4/1071)
            $table->string('invitation_token', 191)->nullable()->unique('users_invitation_token_unique');
            $table->timestamp('invitation_token_expires_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('role');
            $table->index('is_active');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            // Réduire longueur (utf8mb4 => index length 1000 bytes)
            $table->string('email', 100)->primary();
            $table->string('token', 255);
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            // Réduire longueur (utf8mb4 => index length 1000 bytes)
            $table->string('id', 100)->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
