<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Orcamento;
use App\Models\Diaria;
use App\Models\Equipe;
use App\Models\Material;
use App\Models\User;


use BaconQrCode\Renderer\Color\Rgb;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use mysqli;

class MaterialController extends Controller
{

    public function create(){

        return view('materiais.create');

    }

    
    public function store(Request $request) {
        
        $material = new Material;

        $material->tipo = $request->tipo;
        $material->nome = $request->nome;
        $material->uni_medida = $request->uni_medida;
        $material->custo = $request->custo;
        $material->venda = $request->venda;
        $material->user_id = Auth::id();
           
        $material->save();
 
            return response()->json(['msg'=>'Material criado com sucesso!']);

    }

    public function destroy($id) {
        $material = Material::findOrFail($id);
        $material->orcamentos()->detach();
        $material->delete();

        return;
        
    }

    public function dashboard() {
        
        $user = Auth::user();

        $materiais = $user->materials;

        $quant = count($materiais);

        return view('materiais.dashboard', ['materiais' => $materiais, 'quant' => $quant]);
        
    }

    public function edit($id) {
        $material = Material::findOrFail($id);

        return view('materiais.edit', ['material' => $material]);
    
    }

    public function update(Request $request) {

        Material::findOrFail($request->id)->update($request->all());

        return response()->json(['msg'=>'Material editado com sucesso!']);
    }
}
