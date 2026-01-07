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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            // Menambahkan operator_id sebagai pemilik sekolah
            $table->foreignId('operator_id')->constrained('operators')->onDelete('cascade');
            $table->string('nama_sekolah');
            $table->string('npsn_sekolah')->unique();
            $table->string('jenjang_pendidikan');
            $table->integer('jumlah_perangkat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
