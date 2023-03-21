<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buses', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->unsignedBigInteger('supir_id');
            $table->foreign('supir_id')->references('id')->on('users')->where('role', '3');
            $table->string('police_number');
            $table->string('number_of_seats');
            $table->string('merk');
            $table->string('nomor_pintu');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buses');
    }
};
