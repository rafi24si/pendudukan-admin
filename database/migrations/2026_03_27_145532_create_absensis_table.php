<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations
     */
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();

            // relasi ke users
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // tanggal absensi
            $table->date('tanggal');

            // jam
            $table->time('jam_masuk')->nullable();
            $table->time('jam_pulang')->nullable();

            // durasi dalam menit
            $table->integer('durasi')->nullable();

            // status absensi
            $table->enum('status', ['hadir', 'belum_pulang', 'selesai'])
                  ->default('hadir');

            // 🔥 anti double absen (1 hari 1 user)
            $table->unique(['user_id', 'tanggal']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
