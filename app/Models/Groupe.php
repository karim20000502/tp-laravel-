<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;
    public function filiere(){
        return $this->belongsTo(Filiere::class,'filiere_id','id');
    }
    public function stagiaire(){
        return $this->hasMany(Stagiaire::class,'groupe_id','id');
    }
}
