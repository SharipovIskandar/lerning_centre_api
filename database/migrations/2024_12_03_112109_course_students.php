<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('course_students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses', 'id')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users', 'id')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['course_id', 'student_id']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_students');
    }
};
