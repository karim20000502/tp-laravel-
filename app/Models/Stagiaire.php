<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stagiaire extends Model
{
    use HasFactory;

    public function groupe(){
        return $this->belongsTo(Groupe::class,'groupe_id','id');
    }
    protected $fillable=["product_code"];
}

