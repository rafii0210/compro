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
        Schema::create('eksperiences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_profile');
            $table->string('judul');
            $table->string('subjudul');
            $table->string('descriptions');
            $table->date('tanggal_awal');
            $table->date('tanggal_akhir');
            $table->timestamps();

            $table->foreign('id_profile')->references('id')->on('profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eksperiences');
    }
};
