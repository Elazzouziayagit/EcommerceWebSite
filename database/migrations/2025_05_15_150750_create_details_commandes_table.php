<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('details_commandes', function (Blueprint $table) {
            $table->id('id_detail');
            $table->unsignedBigInteger('id_commande');
            $table->foreign('id_commande')->references('id_commande')->on('commandes')->onDelete('cascade');
            $table->unsignedBigInteger('id_parfum');
            $table->foreign('id_parfum')->references('id_parfum')->on('parfums')->onDelete('cascade');
            $table->integer('quantite');
            $table->decimal('prix_unitaire', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('details_commandes');
    }
};