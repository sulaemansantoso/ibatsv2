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
        //
        Schema::table('pertemuan', function (Blueprint $table) {
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->dropColumn('no_pertemuan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('pertemuan', function (Blueprint $table) {
            $table->dropColumn('jam_mulai');
            $table->dropColumn('jam_selesai');
            $table->integer('no_pertemuan');
        });
    }
};
