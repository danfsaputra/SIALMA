<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToAlihmediaTable extends Migration
{
    public function up()
    {
        Schema::table('alihmedia', function (Blueprint $table) {
            $table->string('status')->nullable(); // Menambahkan kolom status
        });
    }

    public function down()
    {
        Schema::table('alihmedia', function (Blueprint $table) {
            $table->dropColumn('status'); // Menghapus kolom status jika migrasi dibatalkan
        });
    }
}
