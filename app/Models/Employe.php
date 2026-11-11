<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    use HasFactory;

    public const STATUTS = [
        'actif' => 'Actif',
        'suspendu' => 'Suspendu',
        'quitte' => 'A quitté',
    ];

    protected $fillable = [
        'matricule', 'nom', 'prenom', 'cin', 'email', 'telephone', 'genre',
        'date_naissance', 'date_embauche', 'poste', 'salaire', 'statut', 'departement_id',
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'date_embauche' => 'date',
        'salaire' => 'decimal:2',
    ];

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function conges()
    {
        return $this->hasMany(Conge::class);
    }

    public function getNomCompletAttribute(): string
    {
        return "{$this->prenom} {$this->nom}";
    }

    /** Jours de congé annuel approuvés pendant l'année donnée. */
    public function joursCongeAnnuelPris(?int $annee = null): int
    {
        $annee ??= now()->year;

        return $this->conges()
            ->where('type', 'annuel')
            ->where('statut', 'approuve')
            ->whereYear('date_debut', $annee)
            ->get()
            ->sum->nombreJours();
    }
}
