<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('group_student', function (Blueprint $table) {
            $table->text('comment')->nullable()->after('homework_completed');
        });
    }

    public function down(): void
    {
        Schema::table('group_student', function (Blueprint $table) {
            $table->dropColumn('comment');
        });
    }
};
