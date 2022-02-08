<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    use HasFactory;

    protected $dates = [
        'data',
        'created_at',
        'updated_at'
    ];

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

    public function materiais() {
        return $this->belongsToMany('App\Models\Material')
        ->withPivot('quant', 'soma_custo', 'soma_venda');
    }

    public function dietas() {
        return $this->belongsToMany('App\Models\Dieta')
        ->withPivot('quant', 'soma_custo', 'soma_venda');
    }

    public function equipamentos() {
        return $this->belongsToMany('App\Models\Equipamento')
        ->withPivot('quant', 'soma_custo', 'soma_venda');
    }

    public function medicamentos() {
        return $this->belongsToMany('App\Models\Medicamento')
        ->withPivot('quant', 'soma_custo', 'soma_venda');
    }

}
