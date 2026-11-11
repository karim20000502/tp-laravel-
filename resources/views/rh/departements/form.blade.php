@extends('rh.layout')
@section('title', $departement->exists ? 'Modifier le département' : 'Nouveau département')
@section('content')
<h1 class="h3 mb-3">{{ $departement->exists ? 'Modifier le département' : 'Nouveau département' }}</h1>
<div class="card shadow-sm border-0"><div class="card-body">
<form method="POST" action="{{ $departement->exists ? route('rh.departements.update', $departement) : route('rh.departements.store') }}">
    @csrf
    @if ($departement->exists) @method('PUT') @endif
    <div class="mb-3">
        <label class="form-label">Nom *</label>
        <input name="nom" class="form-control" value="{{ old('nom', $departement->nom) }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description', $departement->description) }}</textarea>
    </div>
    <button class="btn btn-primary">Enregistrer</button>
    <a href="{{ route('rh.departements.index') }}" class="btn btn-link">Annuler</a>
</form>
</div></div>
@endsection
