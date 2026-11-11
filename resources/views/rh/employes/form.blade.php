@extends('rh.layout')
@section('title', $employe->exists ? 'Modifier l\'employé' : 'Nouvel employé')
@section('content')
<h1 class="h3 mb-3">{{ $employe->exists ? 'Modifier : '.$employe->nom_complet : 'Nouvel employé' }}</h1>
@if ($departements->isEmpty())
    <div class="alert alert-warning">Créez d'abord un <a href="{{ route('rh.departements.create') }}">département</a>.</div>
@endif
<div class="card shadow-sm border-0"><div class="card-body">
<form method="POST" action="{{ $employe->exists ? route('rh.employes.update', $employe) : route('rh.employes.store') }}">
    @csrf
    @if ($employe->exists) @method('PUT') @endif
    <div class="row g-3">
        <div class="col-md-4"><label class="form-label">Matricule *</label><input name="matricule" class="form-control" value="{{ old('matricule', $employe->matricule) }}" required></div>
        <div class="col-md-4"><label class="form-label">Nom *</label><input name="nom" class="form-control" value="{{ old('nom', $employe->nom) }}" required></div>
        <div class="col-md-4"><label class="form-label">Prénom *</label><input name="prenom" class="form-control" value="{{ old('prenom', $employe->prenom) }}" required></div>

        <div class="col-md-4"><label class="form-label">CIN *</label><input name="cin" class="form-control" value="{{ old('cin', $employe->cin) }}" required></div>
        <div class="col-md-4"><label class="form-label">Email *</label><input type="email" name="email" class="form-control" value="{{ old('email', $employe->email) }}" required></div>
        <div class="col-md-4"><label class="form-label">Téléphone</label><input name="telephone" class="form-control" value="{{ old('telephone', $employe->telephone) }}"></div>

        <div class="col-md-4">
            <label class="form-label">Genre *</label>
            <select name="genre" class="form-select" required>
                <option value="H" @selected(old('genre', $employe->genre) === 'H')>Homme</option>
                <option value="F" @selected(old('genre', $employe->genre) === 'F')>Femme</option>
            </select>
        </div>
        <div class="col-md-4"><label class="form-label">Date de naissance</label><input type="date" name="date_naissance" class="form-control" value="{{ old('date_naissance', $employe->date_naissance?->format('Y-m-d')) }}"></div>
        <div class="col-md-4"><label class="form-label">Date d'embauche *</label><input type="date" name="date_embauche" class="form-control" value="{{ old('date_embauche', $employe->date_embauche?->format('Y-m-d')) }}" required></div>

        <div class="col-md-4">
            <label class="form-label">Département *</label>
            <select name="departement_id" class="form-select" required>
                <option value="">— Choisir —</option>
                @foreach ($departements as $d)
                    <option value="{{ $d->id }}" @selected(old('departement_id', $employe->departement_id) == $d->id)>{{ $d->nom }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4"><label class="form-label">Poste *</label><input name="poste" class="form-control" value="{{ old('poste', $employe->poste) }}" required></div>
        <div class="col-md-2"><label class="form-label">Salaire (DH) *</label><input type="number" step="0.01" min="0" name="salaire" class="form-control" value="{{ old('salaire', $employe->salaire) }}" required></div>
        <div class="col-md-2">
            <label class="form-label">Statut *</label>
            <select name="statut" class="form-select" required>
                @foreach (\App\Models\Employe::STATUTS as $k => $v)
                    <option value="{{ $k }}" @selected(old('statut', $employe->statut) === $k)>{{ $v }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="mt-4">
        <button class="btn btn-primary">Enregistrer</button>
        <a href="{{ route('rh.employes.index') }}" class="btn btn-link">Annuler</a>
    </div>
</form>
</div></div>
@endsection
