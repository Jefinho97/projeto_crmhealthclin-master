<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    use HasFactory;

    protected $dates = ['data'];

    protected $guarded = [];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function equipes() {
        return $this->belongsToMany('App\Models\Equipe')
        ->withPivot('quant', 'soma_custo', 'soma_venda');
    }

    public function diarias() {
        return $this->belongsToMany('App\Models\Diaria');
    }

    public function materials() {
        return $this->belongsToMany('App\Models\Material')
        ->withPivot('quant', 'soma_custo', 'soma_venda');
    }
}
