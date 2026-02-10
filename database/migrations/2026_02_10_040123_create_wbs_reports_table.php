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
        Schema::create('wbs_reports', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelapor')->nullable();
            $table->string('kontak_pelapor')->nullable();
            $table->string('hubungan')->nullable();
            $table->string('jenis_pelanggaran')->nullable();
            $table->text('deskripsi')->nullable();
            $table->date('tanggal_kejadian')->nullable();
            $table->time('waktu_kejadian')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('terlapor')->nullable();
            $table->text('saksi')->nullable();
            $table->text('bukti')->nullable();
            $table->string('foto_bukti')->nullable(); // Store URL
            $table->string('video_bukti')->nullable(); // Store URL
            $table->text('dampak')->nullable();
            $table->text('harapan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wbs_reports');
    }
};
