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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // id bigint(20) unsigned [cite: 23]
            $table->unsignedBigInteger('id_lokasi'); // id_lokasi bigint(20) unsigned [cite: 24]
            $table->string('no_tiket', 255); // no_tiket varchar(255) [cite: 25]
            $table->string('no_polisi', 15); // no_polisi varchar(15) [cite: 26]
            $table->unsignedBigInteger('id_jenis'); // id_jenis bigint(20) unsigned [cite: 27]
            $table->dateTime('masuk'); // masuk datetime [cite: 28]
            $table->dateTime('keluar')->nullable(); // keluar datetime [cite: 29]
            $table->integer('perjam_pertama'); // perjam_pertama int(11) [cite: 30]
            $table->integer('perjam_berikutnya'); // perjam_berikutnya int(11) [cite: 31]
            $table->integer('max_perhari'); // max_perhari int(11) [cite: 32]
            $table->integer('total_jam')->nullable(); // total_jam int(11) [cite: 33]
            $table->integer('total_bayar')->nullable(); // total_bayar int(11) [cite: 34]
            $table->timestamps(); // created_at & updated_at timestamp [cite: 35, 36]

            // Relasi Foreign Key
            $table->foreign('id_lokasi')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('id_jenis')->references('id')->on('vehicle_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
