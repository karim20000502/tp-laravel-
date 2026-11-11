@extends('rh.layout')
@section('title', 'Employés')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Employés</h1>
    <a href="{{ route('rh.employes.create') }}" class="btn btn-primary"><i class="bi bi-person-plus"></i> Nouvel employé</a>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-5"><input name="q" class="form-control" placeholder="Rechercher (nom, matricule, CIN, poste)…" value="{{ request('q') }}"></div>
    <div class="col-md-3">
        <select name="departement_id" class="form-select" onchange="this.form.submit()">
            <option value="">Tous les départements</option>
            @foreach ($departements as $d)
                <option value="{{ $d->id }}" @selected(request('departement_id') == $d->id)>{{ $d->nom }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <select name="statut" class="form-select" onchange="this.form.submit()">
            <option value="">Tous statuts</option>
            @foreach (\App\Models\Employe::STATUTS as $k => $v)
                <option value="{{ $k }}" @selected(request('statut') === $k)>{{ $v }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2"><button class="btn btn-outline-secondary w-100"><i class="bi bi-search"></i> Filtrer</button></div>
</form>

<div class="card shadow-sm border-0">
    <div class="table-responsive">
    <table class="table table-hover mb-0 align-middle">
        <thead class="table-dark"><tr><th>Matricule</th><th>Nom complet</th><th>Poste</th><th>Département</th><th>Embauche</th><th>Statut</th><th class="text-end">Actions</th></tr></thead>
        <tbody>
        @forelse ($employes as $e)
            <tr>
                <td>{{ $e->matricule }}</td>
                <td><a href="{{ route('rh.employes.show', $e) }}">{{ $e->nom_complet }}</a></td>
                <td>{{ $e->poste }}</td>
                <td>{{ $e->departement->nom }}</td>
                <td>{{ $e->date_embauche->format('d/m/Y') }}</td>
                <td><span class="badge bg-{{ $e->statut === 'actif' ? 'success' : ($e->statut === 'suspendu' ? 'warning' : 'secondary') }}">{{ \App\Models\Employe::STATUTS[$e->statut] }}</span></td>
                <td class="text-end">
                    <a href="{{ route('rh.employes.edit', $e) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('rh.employes.destroy', $e) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cet employé ?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center text-muted py-4">Aucun employé trouvé.</td></tr>
        @endforelse
        </tbody>
    </table>
    </div>
</div>
<div class="mt-3">{{ $employes->links('pagination::bootstrap-5') }}</div>
@endsection
