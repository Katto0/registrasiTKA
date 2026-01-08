<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->date('exam_date');
            $table->unsignedTinyInteger('session_number');
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedInteger('capacity');
            $table->timestamps();

            $table->unique(['school_id', 'exam_date', 'session_number']);
            $table->index(['school_id', 'exam_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_sessions');
    }
};

