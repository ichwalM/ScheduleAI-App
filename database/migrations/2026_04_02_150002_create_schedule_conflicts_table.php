<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedule_conflicts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained()->cascadeOnDelete();
            $table->string('day', 20)->nullable();
            $table->text('description');
            $table->json('courses_involved')->nullable(); // array of course names
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedule_conflicts');
    }
};
