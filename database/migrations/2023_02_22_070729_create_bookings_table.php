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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // kolom ini menunjukkan ID pengguna yang melakukan pemesanan
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('route_id'); // kolom ini menunjukkan ID rute yang dipesan oleh pengguna
            $table->foreign('route_id')->references('id')->on('routes');
            $table->unsignedBigInteger('bus_id'); // kolom ini menunjukkan ID bus yang dipesan oleh pengguna
            $table->foreign('bus_id')->references('id')->on('buses');
            $table->dateTime('departure_time'); // kolom ini menunjukkan waktu keberangkatan
            $table->integer('num_seats'); // kolom ini menunjukkan jumlah kursi yang dipesan
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
        Schema::dropIfExists('bookings');
    }
};
