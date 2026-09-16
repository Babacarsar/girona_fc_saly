<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('joueurs', function (Blueprint $table) {
            $table->unsignedInteger('ordre')->default(0)->after('photo');
        });

        Schema::table('actualites', function (Blueprint $table) {
            $table->unsignedInteger('ordre')->default(0)->after('date_publication');
            $table->string('statut', 20)->default('draft')->after('ordre');
            $table->boolean('a_la_une')->default(false)->after('statut');
        });

        DB::table('actualites')->update(['statut' => 'published']);

        Schema::create('matchs', function (Blueprint $table) {
            $table->id();
            $table->string('adversaire');
            $table->dateTime('date_match');
            $table->string('lieu')->nullable();
            $table->string('score_domicile')->nullable();
            $table->string('score_exterieur')->nullable();
            $table->string('type', 30)->default('amical');
            $table->foreignId('categorie_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->unsignedInteger('ordre')->default(0);
            $table->timestamps();
        });

        Schema::create('pre_inscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('prenom');
            $table->string('nom');
            $table->date('date_naissance');
            $table->foreignId('categorie_id')->constrained('categories')->cascadeOnDelete();
            $table->string('email_parent');
            $table->string('telephone')->nullable();
            $table->text('message')->nullable();
            $table->boolean('traite')->default(false);
            $table->timestamps();
        });

        Schema::create('partenaires', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('logo');
            $table->string('description')->nullable();
            $table->string('url')->nullable();
            $table->unsignedInteger('ordre')->default(0);
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partenaires');
        Schema::dropIfExists('pre_inscriptions');
        Schema::dropIfExists('matchs');

        Schema::table('actualites', function (Blueprint $table) {
            $table->dropColumn(['ordre', 'statut', 'a_la_une']);
        });

        Schema::table('joueurs', function (Blueprint $table) {
            $table->dropColumn('ordre');
        });
    }
};
