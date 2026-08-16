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
        Schema::create('parent_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->enum('registered_by', ['father', 'mother']);

            $table->string('father_name');
            $table->string('father_mobile');
            $table->string('father_job');

            $table->string('mother_name');
            $table->string('mother_mobile');
            $table->string('mother_job');

            $table->text('address');

            $table->text('ideal_community_opinion'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parent_profiles');
    }
};
