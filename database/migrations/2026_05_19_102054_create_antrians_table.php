<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('antrians', function (Blueprint $table) {

            $table->id();

            $table->string('kode_antrian');

            $table->string('nama_pasien');

            $table->string('poli');

            $table->integer('loket')->nullable();

            $table->enum('status', [
                'menunggu',
                'dipanggil',
                'selesai',
                'terlambat'
            ])->default('menunggu');

            $table->timestamp('waktu_panggil')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('antrians');
    }
};