@extends('rh.layout')
@section('title', 'Départements')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Départements</h1>
    <a href="{{ route('rh.departements.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Nouveau département</a>
</div>
<div class="card shadow-sm border-0">
    <table class="table table-hover mb-0 align-middle">
        <thead class="table-dark"><tr><th>Nom</th><th>Description</th><th>Employés</th><th class="text-end">Actions</th></tr></thead>
        <tbody>
        @forelse ($departements as $d)
            <tr>
                <td><a href="{{ route('rh.departements.show', $d) }}">{{ $d->nom }}</a></td>
                <td class="text-muted">{{ \Illuminate\Support\Str::limit($d->description, 80) }}</td>
                <td><span class="badge bg-secondary">{{ $d->employes_count }}</span></td>
                <td class="text-end">
                    <a href="{{ route('rh.departements.edit', $d) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('rh.departements.destroy', $d) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce département ?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4" class="text-center text-muted py-4">Aucun département.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
