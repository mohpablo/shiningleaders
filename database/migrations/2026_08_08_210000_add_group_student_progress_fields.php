<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('group_student', function (Blueprint $table) {
            $table->boolean('attendance')->default(false)->after('enrollment_date');
            $table->boolean('homework_completed')->default(false)->after('attendance');
        });
    }

    public function down(): void
    {
        Schema::table('group_student', function (Blueprint $table) {
            $table->dropColumn(['attendance', 'homework_completed']);
        });
    }
};
