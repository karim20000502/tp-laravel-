@extends('rh.layout')
@section('title', 'Tableau de bord RH')
@section('content')
<h1 class="h3 mb-4">Tableau de bord</h1>

<div class="row g-3 mb-4">
    @foreach ([
        ['Employés', $stats['employes'], 'people', 'primary'],
        ['Actifs', $stats['actifs'], 'person-check', 'success'],
        ['Départements', $stats['departements'], 'diagram-3', 'info'],
        ['Congés en attente', $stats['conges_en_attente'], 'hourglass-split', 'warning'],
    ] as [$label, $value, $icon, $color])
    <div class="col-6 col-lg-3">
        <div class="card stat-card border-0 shadow-sm border-start border-4 border-{{ $color }}">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div><div class="text-muted small">{{ $label }}</div><div class="fs-3 fw-bold">{{ $value }}</div></div>
                <i class="bi bi-{{ $icon }} text-{{ $color }}"></i>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white d-flex justify-content-between">
                <strong>Demandes de congé en attente</strong>
                <a href="{{ route('rh.conges.index', ['statut' => 'en_attente']) }}">Tout voir</a>
            </div>
            <ul class="list-group list-group-flush">
                @forelse ($demandes as $c)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{ route('rh.employes.show', $c->employe) }}">{{ $c->employe->nom_complet }}</a>
                            <div class="small text-muted">{{ \App\Models\Conge::TYPES[$c->type] }} · {{ $c->date_debut->format('d/m/Y') }} → {{ $c->date_fin->format('d/m/Y') }} ({{ $c->nombreJours() }} j)</div>
                        </div>
                        @include('rh.conges._actions', ['conge' => $c])
                    </li>
                @empty
                    <li class="list-group-item text-muted">Aucune demande en attente.</li>
                @endforelse
            </ul>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white"><strong>En congé aujourd'hui</strong></div>
            <ul class="list-group list-group-flush">
                @forelse ($enConge as $c)
                    <li class="list-group-item">{{ $c->employe->nom_complet }}<div class="small text-muted">jusqu'au {{ $c->date_fin->format('d/m/Y') }}</div></li>
                @empty
                    <li class="list-group-item text-muted">Personne.</li>
                @endforelse
            </ul>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white"><strong>Effectif par département</strong></div>
            <ul class="list-group list-group-flush">
                @forelse ($departements as $d)
                    <li class="list-group-item d-flex justify-content-between"><a href="{{ route('rh.departements.show', $d) }}">{{ $d->nom }}</a><span class="badge bg-secondary">{{ $d->employes_count }}</span></li>
                @empty
                    <li class="list-group-item text-muted">Aucun département.</li>
                @endforelse
            </ul>
            <div class="card-footer bg-white small text-muted">Masse salariale mensuelle : <strong>{{ number_format($stats['masse_salariale'], 2, ',', ' ') }} DH</strong></div>
        </div>
    </div>
</div>
@endsection
