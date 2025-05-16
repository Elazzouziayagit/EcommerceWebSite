<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('actions_admin', function (Blueprint $table) {
            $table->id('id_action');
            $table->unsignedBigInteger('id_admin');
            $table->foreign('id_admin')->references('id_admin')->on('administrateurs')->onDelete('cascade');
            $table->text('action');
            $table->dateTime('date_action');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('actions_admin');
    }
};