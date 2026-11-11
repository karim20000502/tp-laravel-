<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\Conge;
use App\Models\Employe;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CongeController extends Controller
{
    public function index(Request $request)
    {
        $conges = Conge::with('employe')
            ->when($request->filled('statut'), fn ($q) => $q->where('statut', $request->statut))
            ->latest('date_debut')
            ->paginate(10)
            ->withQueryString();

        return view('rh.conges.index', compact('conges'));
    }

    public function create(Request $request)
    {
        return view('rh.conges.create', [
            'employes' => Employe::where('statut', 'actif')->orderBy('nom')->get(),
            'employe_id' => $request->employe_id,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employe_id' => ['required', 'exists:employes,id'],
            'type' => ['required', Rule::in(array_keys(Conge::TYPES))],
            'date_debut' => ['required', 'date'],
            'date_fin' => ['required', 'date', 'after_or_equal:date_debut'],
            'motif' => ['nullable', 'string'],
        ]);

        $chevauchement = Conge::where('employe_id', $data['employe_id'])
            ->where('statut', '!=', 'refuse')
            ->whereDate('date_debut', '<=', $data['date_fin'])
            ->whereDate('date_fin', '>=', $data['date_debut'])
            ->exists();

        if ($chevauchement) {
            throw ValidationException::withMessages([
                'date_debut' => 'Cet employé a déjà une demande de congé sur cette période.',
            ]);
        }

        Conge::create($data + ['statut' => 'en_attente']);

        return redirect()->route('rh.conges.index')->with('status', 'Demande de congé enregistrée.');
    }

    public function approuver(Conge $conge)
    {
        if ($conge->type === 'annuel') {
            $solde = Conge::SOLDE_ANNUEL - $conge->employe->joursCongeAnnuelPris($conge->date_debut->year);
            if ($conge->nombreJours() > $solde) {
                return back()->with('error', "Solde insuffisant : il reste {$solde} jour(s) à {$conge->employe->nom_complet}.");
            }
        }

        $conge->update(['statut' => 'approuve']);

        return back()->with('status', 'Congé approuvé.');
    }

    public function refuser(Conge $conge)
    {
        $conge->update(['statut' => 'refuse']);

        return back()->with('status', 'Congé refusé.');
    }

    public function destroy(Conge $conge)
    {
        $conge->delete();

        return back()->with('status', 'Demande supprimée.');
    }
}
