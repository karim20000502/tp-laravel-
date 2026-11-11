@extends('rh.layout')
@section('title', 'Congés')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Congés</h1>
    <a href="{{ route('rh.conges.create') }}" class="btn btn-primary"><i class="bi bi-calendar-plus"></i> Nouvelle demande</a>
</div>

<ul class="nav nav-pills mb-3">
    <li class="nav-item"><a class="nav-link @if(!request('statut')) active @endif" href="{{ route('rh.conges.index') }}">Toutes</a></li>
    @foreach (\App\Models\Conge::STATUTS as $k => $v)
        <li class="nav-item"><a class="nav-link @if(request('statut') === $k) active @endif" href="{{ route('rh.conges.index', ['statut' => $k]) }}">{{ $v }}</a></li>
    @endforeach
</ul>

<div class="card shadow-sm border-0">
    <div class="table-responsive">
    <table class="table table-hover mb-0 align-middle">
        <thead class="table-dark"><tr><th>Employé</th><th>Type</th><th>Du</th><th>Au</th><th>Jours</th><th>Motif</th><th>Statut</th><th class="text-end">Actions</th></tr></thead>
        <tbody>
        @forelse ($conges as $c)
            <tr>
                <td><a href="{{ route('rh.employes.show', $c->employe) }}">{{ $c->employe->nom_complet }}</a></td>
                <td>{{ \App\Models\Conge::TYPES[$c->type] }}</td>
                <td>{{ $c->date_debut->format('d/m/Y') }}</td>
                <td>{{ $c->date_fin->format('d/m/Y') }}</td>
                <td>{{ $c->nombreJours() }}</td>
                <td class="text-muted small">{{ \Illuminate\Support\Str::limit($c->motif, 40) }}</td>
                <td><span class="badge bg-{{ $c->badgeClass() }}">{{ \App\Models\Conge::STATUTS[$c->statut] }}</span></td>
                <td class="text-end text-nowrap">
                    @include('rh.conges._actions', ['conge' => $c])
                    <form action="{{ route('rh.conges.destroy', $c) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette demande ?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-secondary" title="Supprimer"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="8" class="text-center text-muted py-4">Aucune demande.</td></tr>
        @endforelse
        </tbody>
    </table>
    </div>
</div>
<div class="mt-3">{{ $conges->links('pagination::bootstrap-5') }}</div>
@endsection
