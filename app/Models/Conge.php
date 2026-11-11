<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conge extends Model
{
    use HasFactory;

    public const TYPES = [
        'annuel' => 'Congé annuel',
        'maladie' => 'Congé maladie',
        'maternite' => 'Congé maternité / paternité',
        'sans_solde' => 'Congé sans solde',
        'autre' => 'Autre',
    ];

    public const STATUTS = [
        'en_attente' => 'En attente',
        'approuve' => 'Approuvé',
        'refuse' => 'Refusé',
    ];

    /** Droit annuel au congé payé (jours). */
    public const SOLDE_ANNUEL = 18;

    protected $fillable = ['employe_id', 'type', 'date_debut', 'date_fin', 'motif', 'statut'];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
    ];

    public function employe()
    {
        return $this->belongsTo(Employe::class);
    }

    public function nombreJours(): int
    {
        return $this->date_debut->diffInDays($this->date_fin) + 1;
    }

    public function badgeClass(): string
    {
        return match ($this->statut) {
            'approuve' => 'success',
            'refuse' => 'danger',
            default => 'warning',
        };
    }
}
