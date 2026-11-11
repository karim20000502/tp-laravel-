<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DepartementController extends Controller
{
    public function index()
    {
        $departements = Departement::withCount('employes')->orderBy('nom')->get();

        return view('rh.departements.index', compact('departements'));
    }

    public function create()
    {
        return view('rh.departements.form', ['departement' => new Departement()]);
    }

    public function store(Request $request)
    {
        Departement::create($this->validated($request));

        return redirect()->route('rh.departements.index')->with('status', 'Département ajouté avec succès.');
    }

    public function show(Departement $departement)
    {
        $departement->load('employes');

        return view('rh.departements.show', compact('departement'));
    }

    public function edit(Departement $departement)
    {
        return view('rh.departements.form', compact('departement'));
    }

    public function update(Request $request, Departement $departement)
    {
        $departement->update($this->validated($request, $departement));

        return redirect()->route('rh.departements.index')->with('status', 'Département modifié avec succès.');
    }

    public function destroy(Departement $departement)
    {
        if ($departement->employes()->exists()) {
            return back()->with('error', 'Impossible de supprimer un département qui contient des employés.');
        }

        $departement->delete();

        return redirect()->route('rh.departements.index')->with('status', 'Département supprimé.');
    }

    private function validated(Request $request, ?Departement $departement = null): array
    {
        return $request->validate([
            'nom' => ['required', 'string', 'max:255', Rule::unique('departements')->ignore($departement)],
            'description' => ['nullable', 'string'],
        ]);
    }
}
