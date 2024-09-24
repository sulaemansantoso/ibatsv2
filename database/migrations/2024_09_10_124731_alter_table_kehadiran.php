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
		$table->renameColumn('photo','id_pertemuan_photo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //

        Schema::table('kehadiran', function (Blueprint $table) {
		$table->renameColumn('id_pertemuan_photo', 'photo');
        });
    }
};
