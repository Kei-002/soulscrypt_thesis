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
        Schema::create('grave_occupant', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('occupant_id')->unsigned();
            $table->foreign('occupant_id')->references('id')->on('grave_records')
                ->onDelete('cascade');
            $table->integer('grave_id')->unsigned();
            $table->foreign('grave_id')->references('id')->on('graves')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grave_occupant');
    }
};
