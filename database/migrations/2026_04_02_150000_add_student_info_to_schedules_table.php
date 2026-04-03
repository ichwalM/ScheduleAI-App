<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->string('student_name')->nullable()->after('status');
            $table->string('nim', 30)->nullable()->after('student_name');
            $table->string('program')->nullable()->after('nim');
            $table->string('semester', 60)->nullable()->after('program');
            $table->string('advisor')->nullable()->after('semester');
            $table->string('period', 100)->nullable()->after('advisor');
            $table->unsignedSmallInteger('total_credits')->default(0)->after('period');
            $table->unsignedTinyInteger('conflict_count')->default(0)->after('total_credits');
        });
    }

    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn([
                'student_name', 'nim', 'program', 'semester',
                'advisor', 'period', 'total_credits', 'conflict_count',
            ]);
        });
    }
};
