<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('anggota_keluarga', function (Blueprint $table) {
            $table->id('anggota_id');
            $table->unsignedBigInteger('kk_id');
            $table->unsignedBigInteger('warga_id');
            $table->string('hubungan'); // contoh: Istri, Anak, Orang Tua, dll
            $table->timestamps();

            // Relasi ke keluarga_kk
            $table->foreign('kk_id')
                ->references('kk_id')
                ->on('keluarga_kk')
                ->onDelete('cascade');

            // Relasi ke warga
            $table->foreign('warga_id')
                ->references('warga_id')
                ->on('warga')
                ->onDelete('cascade');

            // Optional: cegah duplikat anggota yang sama di 1 KK
            $table->unique(['kk_id', 'warga_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota_keluarga');
    }
};

