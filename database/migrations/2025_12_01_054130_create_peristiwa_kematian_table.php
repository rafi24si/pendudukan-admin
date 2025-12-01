<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('peristiwa_kematian', function (Blueprint $table) {
            $table->id('kematian_id');
            $table->unsignedBigInteger('warga_id');
            $table->date('tgl_meninggal');
            $table->string('sebab');
            $table->string('lokasi');
            $table->string('no_surat')->unique()->nullable();
            $table->timestamps();

            $table->foreign('warga_id')
                ->references('warga_id')->on('warga')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peristiwa_kematian');
    }
};

