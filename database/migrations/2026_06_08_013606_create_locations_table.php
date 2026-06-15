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
        Schema::create('locations', function (Blueprint $table) {
            $table->id(); // id: bigint(20) unsigned [cite: 6]
            $table->string('location_name', 100); // location_name varchar(100) [cite: 7]
            $table->integer('max_motorcycle'); // max_motorcycle int(11) [cite: 8]
            $table->integer('max_car'); // max_car int(11) [cite: 9]
            $table->integer('max_other'); // max_other int(11) [cite: 10]
            $table->timestamps(); // created_at & updated_at timestamp [cite: 11, 12]
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
