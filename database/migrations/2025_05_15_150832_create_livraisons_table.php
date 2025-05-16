<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('livraisons', function (Blueprint $table) {
            $table->id('id_livraison');
            $table->unsignedBigInteger('id_commande');
            $table->foreign('id_commande')->references('id_commande')->on('commandes')->onDelete('cascade');
            $table->text('adresse_livraison');
            $table->dateTime('date_livraison')->nullable();
            $table->string('transporteur', 100);
            $table->string('statut', 50);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('livraisons');
    }
};