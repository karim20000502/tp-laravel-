<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Groupe;
use App\Models\Stagiaire;
use Illuminate\Http\Request;

class StagiaireController extends Controller
{
    public function index(Request $request){
        $filieres = Filiere::all();
        $filiere_id = $request->filiere_id;
        $groupes = Groupe::where('filiere_id','=',$filiere_id)->get();
        $groupe_id = $request->groupe_id;
        if ($groupe_id !='' && $filiere_id !='') {
            $stagaires = Stagiaire::where('groupe_id','=',$groupe_id)->get();
        }else{
            $stagaires = Stagiaire::all();
        }
        return view('stagiaires.index', compact('filieres', 'groupes', 'groupe_id','filiere_id', 'stagaires'));
    }
    public function create(Request $request){
        $filieres = Filiere::all();
        $filiere_id = $request->filiere_id;
        $groupes = Groupe::where('filiere_id','=',$filiere_id)->get();
        return view('stagiaires.create', compact('filieres', 'groupes','filiere_id'));
    }
    public function store(Request $request){
        $stagiaire = new Stagiaire();
        $stagiaire->cin = $request->cin;
        $stagiaire->nom = $request->nom;
        $stagiaire->prenom = $request->prenom;
        $stagiaire->date_nais=  $request->date_nais ;
        $stagiaire->genre=  $request->genre ;
        $stagiaire->groupe_id=  $request->groupe_id ;
        $file=$request->file('photo');
        if ($file != '') {
            $ext=$file->getClientOriginalExtension();
            $filename=time().".".$ext;
            $stagiaire->photo="images/".$filename;
            $file->move('images/',$filename);
        }else{
            $nom = $request->nom;
            $stagiaire->photo="default/".$nom[0].".png";
        }

        $stagiaire->save();
        return redirect('/create')->with('status','Stagiaire added successfully');
    }
    public function show($id){
        $stagiaire = Stagiaire::find($id);
        return view('stagiaires.show',compact('stagiaire'));
    }
}
