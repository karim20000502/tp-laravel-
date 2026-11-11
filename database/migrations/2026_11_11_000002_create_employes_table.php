<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employes', function (Blueprint $table) {
            $table->id();
            $table->string('matricule')->unique();
            $table->string('nom');
            $table->string('prenom');
            $table->string('cin')->unique();
            $table->string('email')->unique();
            $table->string('telephone')->nullable();
            $table->string('genre');
            $table->date('date_naissance')->nullable();
            $table->date('date_embauche');
            $table->string('poste');
            $table->decimal('salaire', 10, 2);
            $table->string('statut')->default('actif'); // actif | suspendu | quitte
            $table->foreignId('departement_id')->constrained('departements')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employes');
    }
};
