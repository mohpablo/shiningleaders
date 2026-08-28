<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_student_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('session_number');
            $table->boolean('attendance')->default(false);
            $table->enum('homework_status', ['completed', 'partial', 'not_completed'])->default('not_completed');
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->unique(['group_id', 'student_id', 'session_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_student_sessions');
    }
};
