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
        Schema::create('tb_akun', function (Blueprint $table) {
    $table->string('username')->primary();
    $table->string('password');
    $table->string('name');
    $table->string('status');
    $table->integer('lvlAkun');
    $table->string('imgProfile')->nullable();
    $table->timestamps();
    $table->unsignedBigInteger('idRole');

    $table->foreign('idRole')->references('idRole')->on('tb_role')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akuns');
    }
};
