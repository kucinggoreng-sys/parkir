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
        Schema::create('vehicle_types', function (Blueprint $table) {
            $table->id(); // id bigint(20) unsigned [cite: 14]
            $table->enum('jenis', ['motorcycle', 'car', 'other']); // jenis enum('motorcycle', 'car', 'other') [cite: 15]
            $table->integer('perjam_pertama'); // perjam_pertama int(11) [cite: 16]
            $table->integer('perjam_berikutnya'); // perjam_berikutnya int(11) [cite: 17]
            $table->integer('max_perhari'); // max_perhari int(11) [cite: 18]
            $table->timestamps(); // created_at & updated_at timestamp [cite: 19, 20]
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_types');
    }
};
