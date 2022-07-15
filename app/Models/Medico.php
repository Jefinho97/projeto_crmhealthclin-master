<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
    public function orcamentos() {
        return $this->hasMany('App\Models\Orcamento')
            ->withPivot('preco_medico');
    }
}
