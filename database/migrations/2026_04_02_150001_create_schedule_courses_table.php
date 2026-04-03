<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedule_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained()->cascadeOnDelete();
            $table->string('day', 20);                 // SENIN, SELASA, …
            $table->string('name');                    // Nama mata kuliah
            $table->string('code', 50)->nullable();    // Kode MK
            $table->unsignedTinyInteger('credits')->default(3); // SKS
            $table->string('class', 20)->nullable();   // Kelas (A2, C2, …)
            $table->string('lecturer')->nullable();    // Nama dosen
            $table->string('time_start', 5)->nullable(); // HH:MM
            $table->string('time_end', 5)->nullable();   // HH:MM
            $table->string('room', 50)->nullable();    // Ruangan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedule_courses');
    }
};
