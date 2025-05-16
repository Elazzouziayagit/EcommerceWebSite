<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('panier', function (Blueprint $table) {
            $table->id('id_panier');
            $table->unsignedBigInteger('id_client');
            $table->foreign('id_client')->references('id_client')->on('clients')->onDelete('cascade');
            $table->unsignedBigInteger('id_parfum');
            $table->foreign('id_parfum')->references('id_parfum')->on('parfums')->onDelete('cascade');
            $table->integer('quantite');
            $table->dateTime('date_ajout');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('panier');
    }
};