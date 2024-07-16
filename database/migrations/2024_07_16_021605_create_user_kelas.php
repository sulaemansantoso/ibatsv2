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
        Schema::create('user_kelas', function (Blueprint $table) {
            $table->id("id_user_kelas");
            $table->integer('id_user')->references('id')->on('users');
            $table->integer('id_kelas')->references('id_kelas')->on('kelas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_kelas');
    }
};
