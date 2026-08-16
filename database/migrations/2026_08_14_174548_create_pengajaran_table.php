<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajaran', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tahun_ajaran_id')
                ->constrained('tahun_ajaran')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('kelas_id')
                ->constrained('kelas')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('mata_pelajaran_id')
                ->constrained('mata_pelajaran')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('guru_id')
                ->constrained('guru')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->enum('hari', [
                'Senin',
                'Selasa',
                'Rabu',
                'Kamis',
                'Jumat',
                'Sabtu'
            ]);

            $table->time('jam_mulai');
            $table->time('jam_selesai');

            $table->unsignedTinyInteger('jam_per_minggu');

            $table->enum('semester', [
                'Ganjil',
                'Genap'
            ]);

            $table->timestamps();

            $table->index([
                'guru_id',
                'hari',
                'jam_mulai',
                'jam_selesai'
            ]);

            $table->index([
                'kelas_id',
                'hari',
                'jam_mulai',
                'jam_selesai'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajaran');
    }
};
