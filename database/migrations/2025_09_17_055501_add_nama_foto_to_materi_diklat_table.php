<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('materi_diklat', function (Blueprint $table) {
            $table->string('nama_alat')->after('daftar_alat_id');
            $table->string('foto')->after('nama_alat');
        });
    }

    public function down(): void
    {
        Schema::table('materi_diklat', function (Blueprint $table) {
            $table->dropColumn(['nama_alat','foto']);
        });
    }
};
