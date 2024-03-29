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
    Schema::create('lokets', function (Blueprint $table) {
      $table->id();
      $table->string('nama_loket');
      $table->string('lokasi_loket');
      $table->unsignedBigInteger('admin_id');
      $table->foreign('admin_id')->references('id')->on('users');
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
    Schema::dropIfExists('lokets');
  }
};
