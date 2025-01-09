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
        Schema::create('alihmedia', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('opd');
            $table->date('tgl_arsip');
            $table->string('no_arsip');
            $table->string('jenis_arsip');
            $table->string('klasifikasi_arsip');
            $table->string('uraian');
            $table->string('no_box');
            $table->string('no_berkas');
            $table->string('keterangan');
            $table->string('file_arsip');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alihmedia');
    }
};
