@extends('rh.layout')
@section('title', $employe->nom_complet)
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">{{ $employe->nom_complet }} <small class="text-muted fs-6">{{ $employe->matricule }}</small></h1>
    <div>
        <a href="{{ route('rh.conges.create', ['employe_id' => $employe->id]) }}" class="btn btn-outline-success"><i class="bi bi-calendar-plus"></i> Demande de congé</a>
        <a href="{{ route('rh.employes.edit', $employe) }}" class="btn btn-outline-primary"><i class="bi bi-pencil"></i> Modifier</a>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white"><strong>Informations</strong></div>
            <table class="table mb-0">
                <tr><th>Poste</th><td>{{ $employe->poste }}</td></tr>
                <tr><th>Département</th><td><a href="{{ route('rh.departements.show', $employe->departement) }}">{{ $employe->departement->nom }}</a></td></tr>
                <tr><th>Statut</th><td>{{ \App\Models\Employe::STATUTS[$employe->statut] }}</td></tr>
                <tr><th>CIN</th><td>{{ $employe->cin }}</td></tr>
                <tr><th>Email</th><td>{{ $employe->email }}</td></tr>
                <tr><th>Téléphone</th><td>{{ $employe->telephone ?? '—' }}</td></tr>
                <tr><th>Genre</th><td>{{ $employe->genre === 'F' ? 'Femme' : 'Homme' }}</td></tr>
                <tr><th>Date de naissance</th><td>{{ $employe->date_naissance?->format('d/m/Y') ?? '—' }}</td></tr>
                <tr><th>Date d'embauche</th><td>{{ $employe->date_embauche->format('d/m/Y') }} <span class="text-muted small">({{ $employe->date_embauche->diffForHumans(null, true) }})</span></td></tr>
                <tr><th>Salaire</th><td>{{ number_format($employe->salaire, 2, ',', ' ') }} DH</td></tr>
            </table>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between">
                <strong>Congés</strong>
                <span>Solde annuel {{ now()->year }} : <strong class="{{ $solde > 0 ? 'text-success' : 'text-danger' }}">{{ $solde }}</strong> / {{ \App\Models\Conge::SOLDE_ANNUEL }} jours</span>
            </div>
            <table class="table mb-0 align-middle">
                <thead><tr><th>Type</th><th>Période</th><th>Jours</th><th>Statut</th><th></th></tr></thead>
                <tbody>
                @forelse ($employe->conges as $c)
                    <tr>
                        <td>{{ \App\Models\Conge::TYPES[$c->type] }}</td>
                        <td>{{ $c->date_debut->format('d/m/Y') }} → {{ $c->date_fin->format('d/m/Y') }}</td>
                        <td>{{ $c->nombreJours() }}</td>
                        <td><span class="badge bg-{{ $c->badgeClass() }}">{{ \App\Models\Conge::STATUTS[$c->statut] }}</span></td>
                        <td class="text-end">@include('rh.conges._actions', ['conge' => $c])</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-muted text-center">Aucun congé.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
