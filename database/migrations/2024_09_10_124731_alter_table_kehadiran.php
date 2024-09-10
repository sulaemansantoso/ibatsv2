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

        Schema::table('kehadiran', function (Blueprint $table) {
            $table->integer('photo')->renamed('id_pertemuan_photo')->references('id_pertemuan_photo')->on('pertemuan_photo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //

        Schema::table('kehadiran', function (Blueprint $table) {
            $table->integer('id_pertemuan_photo')->rename('photo')->references('id_pertemuan_photo')->on('pertemuan_photo');
        });
    }
};
