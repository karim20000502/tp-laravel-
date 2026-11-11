@extends('rh.layout')
@section('title', 'Nouvelle demande de congé')
@section('content')
<h1 class="h3 mb-3">Nouvelle demande de congé</h1>
<div class="card shadow-sm border-0"><div class="card-body">
<form method="POST" action="{{ route('rh.conges.store') }}">
    @csrf
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Employé *</label>
            <select name="employe_id" class="form-select" required>
                <option value="">— Choisir —</option>
                @foreach ($employes as $e)
                    <option value="{{ $e->id }}" @selected(old('employe_id', $employe_id) == $e->id)>{{ $e->nom_complet }} ({{ $e->matricule }})</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Type *</label>
            <select name="type" class="form-select" required>
                @foreach (\App\Models\Conge::TYPES as $k => $v)
                    <option value="{{ $k }}" @selected(old('type') === $k)>{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6"><label class="form-label">Date de début *</label><input type="date" name="date_debut" class="form-control" value="{{ old('date_debut') }}" required></div>
        <div class="col-md-6"><label class="form-label">Date de fin *</label><input type="date" name="date_fin" class="form-control" value="{{ old('date_fin') }}" required></div>
        <div class="col-12"><label class="form-label">Motif</label><textarea name="motif" class="form-control" rows="3">{{ old('motif') }}</textarea></div>
    </div>
    <div class="mt-4">
        <button class="btn btn-primary">Enregistrer la demande</button>
        <a href="{{ route('rh.conges.index') }}" class="btn btn-link">Annuler</a>
    </div>
</form>
</div></div>
@endsection
