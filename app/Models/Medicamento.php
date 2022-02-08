<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
    
    public function orcamentos() {
        return $this->belongsToMany('App\Models\Orcamento')
        ->withPivot('quant', 'soma_custo', 'soma_venda');
    }
}
