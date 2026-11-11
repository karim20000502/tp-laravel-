<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employe_id')->constrained('employes')->cascadeOnDelete();
            $table->string('type'); // annuel | maladie | maternite | sans_solde | autre
            $table->date('date_debut');
            $table->date('date_fin');
            $table->text('motif')->nullable();
            $table->string('statut')->default('en_attente'); // en_attente | approuve | refuse
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conges');
    }
};
