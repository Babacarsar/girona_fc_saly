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
    Schema::create('actualites', function (Blueprint $table) {
        $table->id();
        $table->string('titre');
        $table->text('contenu');
        $table->string('image')->nullable(); // URL de l'image Cloudinary
        $table->string('image_public_id')->nullable(); // Pour suppression sur Cloudinary
        $table->string('auteur')->nullable(); // (Optionnel) nom du journaliste ou admin
        $table->date('date_publication')->nullable(); // pour un affichage par date
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
        Schema::dropIfExists('actualites');
    }
};
