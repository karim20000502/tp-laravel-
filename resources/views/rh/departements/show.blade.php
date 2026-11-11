@extends('rh.layout')
@section('title', $departement->nom)
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">{{ $departement->nom }}</h1>
    <a href="{{ route('rh.departements.edit', $departement) }}" class="btn btn-outline-primary"><i class="bi bi-pencil"></i> Modifier</a>
</div>
@if ($departement->description)<p class="text-muted">{{ $departement->description }}</p>@endif
<div class="card shadow-sm border-0">
    <div class="card-header bg-white"><strong>Employés ({{ $departement->employes->count() }})</strong></div>
    <table class="table mb-0">
        <thead><tr><th>Matricule</th><th>Nom</th><th>Poste</th><th>Statut</th></tr></thead>
        <tbody>
        @forelse ($departement->employes as $e)
            <tr>
                <td>{{ $e->matricule }}</td>
                <td><a href="{{ route('rh.employes.show', $e) }}">{{ $e->nom_complet }}</a></td>
                <td>{{ $e->poste }}</td>
                <td>{{ \App\Models\Employe::STATUTS[$e->statut] }}</td>
            </tr>
        @empty
            <tr><td colspan="4" class="text-muted text-center">Aucun employé.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
