@extends('layout')
@section('content')

<h1 class="alert alert-warning">stagaire Info</h1>

<div class="container w-50">
    <div class="card">
        <div class="card-title">
    
        </div>
        <div class="card-body">
              
                    <img src="../../{{ $stagiaire->photo }}" alt="img" class="card-img-top rounded" width="200" height="200">
                
                <h2 class="card-title">Full name:{{ $stagiaire->nom }} {{ $stagiaire->prenom }}</h2>
                   
                <div>
                    <p class="card-text">Date:{{ $stagiaire->date_nais }}</p>
                    <p class="card-text">CIN:{{ $stagiaire->cin }}</p>
                    <p class="card-text">Groupe:{{ $stagiaire->groupe->filiere->code }} {{ $stagiaire->groupe->groupe }}</p>
                </div><br>
                <a href="/" class="btn btn-danger">Back</a>
        </div>
    </div>
</div>


@stop