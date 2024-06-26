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
        Schema::create('pertemuan_photo', function (Blueprint $table) {
            $table->id('id_pertemuan_photo');
            $table->integer('id_pertemuan')->references('id_pertemuan')->on('pertemuan');
            $table->integer('id_photo')->references('id_photo')->on('photo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertemuan_photo');
    }
};
