<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->foreignId('teacher_id')->nullable()->after('course_id')->constrained('users')->nullOnDelete();
        });

        foreach (DB::table('groups')->join('courses', 'groups.course_id', '=', 'courses.id')->select('groups.id', 'courses.teacher_id')->get() as $group) {
            DB::table('groups')->where('id', $group->id)->update(['teacher_id' => $group->teacher_id]);
        }

        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->dropColumn('teacher_id');
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->foreignId('teacher_id')->nullable()->constrained('users')->nullOnDelete();
        });

        foreach (DB::table('groups')->whereNotNull('teacher_id')->select('course_id', 'teacher_id')->orderBy('id')->get()->unique('course_id') as $group) {
            DB::table('courses')->where('id', $group->course_id)->update(['teacher_id' => $group->teacher_id]);
        }

        Schema::table('groups', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->dropColumn('teacher_id');
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->foreignId('teacher_id')->nullable(false)->change();
        });
    }
};
