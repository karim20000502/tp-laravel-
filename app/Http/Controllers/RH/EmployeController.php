<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\Conge;
use App\Models\Departement;
use App\Models\Employe;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmployeController extends Controller
{
    public function index(Request $request)
    {
        $employes = Employe::with('departement')
            ->when($request->filled('q'), function ($query) use ($request) {
                $q = '%'.$request->q.'%';
                $query->where(fn ($w) => $w->where('nom', 'like', $q)
                    ->orWhere('prenom', 'like', $q)
                    ->orWhere('matricule', 'like', $q)
                    ->orWhere('cin', 'like', $q)
                    ->orWhere('poste', 'like', $q));
            })
            ->when($request->filled('departement_id'), fn ($q) => $q->where('departement_id', $request->departement_id))
            ->when($request->filled('statut'), fn ($q) => $q->where('statut', $request->statut))
            ->orderBy('nom')
            ->paginate(10)
            ->withQueryString();

        $departements = Departement::orderBy('nom')->get();

        return view('rh.employes.index', compact('employes', 'departements'));
    }

    public function create()
    {
        return view('rh.employes.form', [
            'employe' => new Employe(['statut' => 'actif', 'date_embauche' => today()]),
            'departements' => Departement::orderBy('nom')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $employe = Employe::create($this->validated($request));

        return redirect()->route('rh.employes.show', $employe)->with('status', 'Employé ajouté avec succès.');
    }

    public function show(Employe $employe)
    {
        $employe->load(['departement', 'conges' => fn ($q) => $q->latest('date_debut')]);
        $joursPris = $employe->joursCongeAnnuelPris();
        $solde = Conge::SOLDE_ANNUEL - $joursPris;

        return view('rh.employes.show', compact('employe', 'joursPris', 'solde'));
    }

    public function edit(Employe $employe)
    {
        return view('rh.employes.form', [
            'employe' => $employe,
            'departements' => Departement::orderBy('nom')->get(),
        ]);
    }

    public function update(Request $request, Employe $employe)
    {
        $employe->update($this->validated($request, $employe));

        return redirect()->route('rh.employes.show', $employe)->with('status', 'Employé modifié avec succès.');
    }

    public function destroy(Employe $employe)
    {
        $employe->delete();

        return redirect()->route('rh.employes.index')->with('status', 'Employé supprimé.');
    }

    private function validated(Request $request, ?Employe $employe = null): array
    {
        return $request->validate([
            'matricule' => ['required', 'string', 'max:50', Rule::unique('employes')->ignore($employe)],
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'cin' => ['required', 'string', 'max:20', Rule::unique('employes')->ignore($employe)],
            'email' => ['required', 'email', 'max:255', Rule::unique('employes')->ignore($employe)],
            'telephone' => ['nullable', 'string', 'max:20'],
            'genre' => ['required', Rule::in(['H', 'F'])],
            'date_naissance' => ['nullable', 'date', 'before:today'],
            'date_embauche' => ['required', 'date'],
            'poste' => ['required', 'string', 'max:255'],
            'salaire' => ['required', 'numeric', 'min:0'],
            'statut' => ['required', Rule::in(array_keys(Employe::STATUTS))],
            'departement_id' => ['required', 'exists:departements,id'],
        ]);
    }
}
