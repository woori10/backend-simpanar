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
        Schema::create('materi_diklat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('daftar_alat_id')
                  ->constrained('daftar_alat')
                  ->onDelete('cascade');     // jika alat dihapus, materi ikut terhapus
            $table->string('file_pdf')->nullable(); // path file PDF materi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materi_diklat');
    }
};
