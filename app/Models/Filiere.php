<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    use HasFactory;
    public function groupe(){
        return $this->hasMany(Groupe::class,'filiere_id','id');
    }
}
