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
        Schema::create('tb_filechat', function (Blueprint $table) {
    $table->id();
    $table->string('ekstensi');
    $table->string('nameFile');
    $table->unsignedBigInteger('idDetailChat');
    $table->timestamps();

    $table->foreign('idDetailChat')->references('idDetailChat')->on('tb_detailchat')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_chats');
    }
};
