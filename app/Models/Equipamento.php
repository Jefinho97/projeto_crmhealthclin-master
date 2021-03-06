<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipamento extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
    
    public function orcamentos() {
        return $this->belongsToMany('App\Models\Orcamento');
    }
}
