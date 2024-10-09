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

        Schema::table('pertemuan_photo', function (Blueprint $table) {
            $table->integer('id_user')->references('id')->on('users')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('pertemuan_photo', function (Blueprint $table) {
            $table->dropColumn('id_user');
        });
    }
};
