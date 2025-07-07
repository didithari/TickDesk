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
        Schema::create('tb_detailchat', function (Blueprint $table) {
    $table->id('idDetailChat');
    $table->text('deskripsi')->nullable();
    $table->string('link')->nullable();
    $table->boolean('check')->default(false);
    $table->dateTime('tanggalDetailChat');
    $table->string('type')->nullable();
    $table->timestamps();

    $table->string('username');
    $table->unsignedBigInteger('id');

    $table->foreign('username')->references('username')->on('tb_akun')->onDelete('cascade');
    $table->foreign('id')->references('id')->on('tb_chat')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_chats');
    }
};
