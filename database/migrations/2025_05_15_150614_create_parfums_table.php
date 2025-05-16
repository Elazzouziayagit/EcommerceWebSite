<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('parfums', function (Blueprint $table) {
            $table->id('id_parfum');
            $table->string('nom', 100);
            $table->text('description');
            $table->decimal('prix', 10, 2);
            $table->integer('stock');
            $table->string('image', 255)->nullable();
            $table->unsignedBigInteger('id_categorie');
            $table->foreign('id_categorie')->references('id_categorie')->on('categories')->onDelete('cascade');
            $table->dateTime('date_ajout');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('parfums');
    }
};