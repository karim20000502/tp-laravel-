<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\Conge;
use App\Models\Departement;
use App\Models\Employe;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $stats = [
            'employes' => Employe::count(),
            'actifs' => Employe::where('statut', 'actif')->count(),
            'departements' => Departement::count(),
            'conges_en_attente' => Conge::where('statut', 'en_attente')->count(),
            'masse_salariale' => Employe::where('statut', 'actif')->sum('salaire'),
        ];

        $enConge = Conge::with('employe')
            ->where('statut', 'approuve')
            ->whereDate('date_debut', '<=', today())
            ->whereDate('date_fin', '>=', today())
            ->get();

        $demandes = Conge::with('employe')
            ->where('statut', 'en_attente')
            ->orderBy('date_debut')
            ->take(5)
            ->get();

        $departements = Departement::withCount('employes')->orderBy('nom')->get();

        return view('rh.dashboard', compact('stats', 'enConge', 'demandes', 'departements'));
    }
}
