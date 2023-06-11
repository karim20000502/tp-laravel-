@extends('layout');
@section('content')
<div class="container">


    <h1 class="alert alert-primary text-center"></h1>
@if (session('status'))
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        {{ session('status') }} <a href='/'>click</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif


    <form action="/" method="post" class="container  w-50  shadow-lg p-3 my-5 bg-body rounded" enctype="multipart/form-data">
        @csrf
        <select name="filiere_id" id="" class="form-control" onchange="submit()">
            <option>Filiere</option>
            @foreach ($filieres as $item)
            <option value="{{ $item->id }}" @if($item->id == $filiere_id)
                @selected(true)
                @endif
                >{{ $item->filiere }}</option>
            @endforeach
        </select><br>

        <select name="groupe_id" id="" class="form-control">
            <option>Groupe</option>
            @foreach ($groupes as $item)
            <option value="{{ $item->id }}" >{{ $item->groupe }}</option>
            @endforeach
        </select><br>

        <input type="text" name="cin" class="form-control" placeholder="votre Cin"><br>
        <input type="text" name="nom" class="form-control" placeholder="votre Nom"><br>
        <input type="text" name="prenom" class="form-control" placeholder="votre prenom"><br>
        <input type="date" name="date_nais" class="form-control"><br>
        <input type="file" name="photo" class="form-control"><br>
        <label>Genre : </label><br>
        <input type="radio" name="genre" value="Homme" id="homme">
        <label for="homme">Homme</label><br>
        <input type="radio" name="genre" value="Femme" id="femme">
        <label for="femme">Femme</label><br><br>




        <button class="btn btn-primary" formaction="create">Save</button>
        <a href="/" class="btn btn-outline-primary float-end" >Back</a>



    </form>
</div>
@endsection


