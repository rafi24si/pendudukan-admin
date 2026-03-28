<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // =========================
        // TAMBAH KOLOM (AMAN)
        // =========================
        Schema::table('absensis', function (Blueprint $table) {

            if (!Schema::hasColumn('absensis', 'jam_masuk')) {
                $table->timestamp('jam_masuk')->nullable();
            }

            if (!Schema::hasColumn('absensis', 'jam_keluar')) {
                $table->timestamp('jam_keluar')->nullable();
            }

            if (!Schema::hasColumn('absensis', 'durasi_menit')) {
                $table->integer('durasi_menit')->nullable();
            }
        });

        // =========================
        // 🔥 HAPUS UNIQUE DENGAN AMAN
        // =========================

        try {
            // 1. Drop foreign key dulu (kalau ada)
            DB::statement('ALTER TABLE absensis DROP FOREIGN KEY absensis_user_id_foreign');
        } catch (\Exception $e) {}

        try {
            DB::statement('ALTER TABLE absensis DROP FOREIGN KEY absensis_user_id_tanggal_foreign');
        } catch (\Exception $e) {}

        try {
            // 2. Drop unique index
            DB::statement('ALTER TABLE absensis DROP INDEX absensis_user_id_tanggal_unique');
        } catch (\Exception $e) {}

        // 3. Tambah kembali foreign key (clean)
        try {
            DB::statement('
                ALTER TABLE absensis
                ADD CONSTRAINT absensis_user_id_foreign
                FOREIGN KEY (user_id) REFERENCES users(id)
                ON DELETE CASCADE
            ');
        } catch (\Exception $e) {}
    }

    public function down(): void
    {
        Schema::table('absensis', function (Blueprint $table) {

            if (Schema::hasColumn('absensis', 'jam_masuk')) {
                $table->dropColumn('jam_masuk');
            }

            if (Schema::hasColumn('absensis', 'jam_keluar')) {
                $table->dropColumn('jam_keluar');
            }

            if (Schema::hasColumn('absensis', 'durasi_menit')) {
                $table->dropColumn('durasi_menit');
            }
        });

        // balikin unique kalau rollback
        try {
            DB::statement('
                ALTER TABLE absensis
                ADD UNIQUE absensis_user_id_tanggal_unique (user_id, tanggal)
            ');
        } catch (\Exception $e) {}
    }
};
