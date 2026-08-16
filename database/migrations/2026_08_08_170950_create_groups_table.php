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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            
            $table->string('name'); // e.g., "Group A" or "Sunday/Tuesday Group"
            $table->string('schedule'); // e.g., "Sun & Tue 5:00 PM - 7:00 PM"
            $table->unsignedInteger('capacity')->nullable(); // Max students allowed
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
