@extends('layout');
@section('content')
<h1 class="alert alert-primary text-center">Affichage Des Stagiaires</h1>
<form action="/" method="get">
    @csrf
<div class="d-flex justify-content-between align-items-center">
    <select name="filiere_id" id="" class="form-control mx-2" onchange="submit()">
        <option>filiere</option>
        @foreach ($filieres as $item)
        <option value="{{ $item->id }}" @if($item->id == $filiere_id)
            @selected(true)
            @endif>{{ $item->filiere}}</option>
        @endforeach
    </select><br>

    @if (count($groupes) > 0)
    <select name="groupe_id" id="" class="form-control mx-2" onchange="submit()">
        <option>Groupe</option>
        @foreach ($groupes as $item)
        <option value="{{ $item->id }}" @if($item->id == $groupe_id)
            @selected(true)
            @endif>{{ $item->groupe }}</option>
        @endforeach
    </select><br>

    @endif
</div>
</form>

@if (count($stagaires) > 0)
<table class="table table-hover container  shadow-lg p-3 my-3 bg-body rounded">
    <thead class="table-dark">
        <tr>
            <th>photo</th>
            <th>Cin</th>
            <th>Nom</th>
            <th>Prenom</th>
            <th>qrcode</th>
            <th>Classe</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ( $stagaires as $item )
        <tr>
            <td> <img src="{{ asset($item->photo) }}" alt="img" width="40" height="40" /> </td>
            <td>{{ $item->cin }}</td>
            <td>{{ $item->nom }}</td>
            <td>{{ $item->prenom }}</td>
            <td>{{ $item->product_code }}</td>
            <td>{{ $item->groupe->filiere->code }} {{ $item->groupe->groupe }}</td>
            <td>
                <a href="{{ url('show',$item->id) }}" class="btn btn-outline-warning">Voir plus</a>
            </td>
        </tr>

        @endforeach
    </tbody>
</table>
@endif
@endsection


