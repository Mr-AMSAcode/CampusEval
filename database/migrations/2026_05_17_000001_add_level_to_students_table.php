<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            if (! Schema::hasColumn('students', 'level')) {
                $table->string('level', 100)->after('student_number')->nullable(false)->default('Licence 1')->comment('Niveau d’étude de l’étudiant');
            }
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            if (Schema::hasColumn('students', 'level')) {
                $table->dropColumn('level');
            }
        });
    }
};
