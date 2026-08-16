<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('jurusan_id')
                ->constrained('jurusan')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('tahun_ajaran_id')
                ->constrained('tahun_ajaran')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->enum('tingkat', ['X', 'XI', 'XII']);
            $table->string('nama_kelas', 50);

            $table->timestamps();

            $table->unique([
                'jurusan_id',
                'tahun_ajaran_id',
                'nama_kelas'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
