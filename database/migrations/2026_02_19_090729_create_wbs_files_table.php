<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wbs_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wbs_report_id')->constrained('wbs_reports')->onDelete('cascade');
            $table->string('file_path');
            $table->enum('file_type', ['image', 'video']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wbs_files');
    }
};
