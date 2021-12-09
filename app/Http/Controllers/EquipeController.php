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

class EquipeController extends Controller
{
    public function create(){

        return view('equipes.create');

    }

    
    public function store(Request $request) {
        
        $equipe = new Equipe;

        $equipe->funcao = $request->funcao;
        $equipe->custo = $request->custo;
        $equipe->venda = $request->venda;
        $equipe->user_id = Auth::id();
           
        $equipe->save();
 
            return response()->json(['msg'=>'Equipe foi criada com sucesso!']);

    }
    public function destroy($id) {
        $equipe = Equipe::findOrFail($id);
        $equipe->orcamentos()->detach();
        $equipe->delete();

        return;
        
    }

    public function dashboard() {
        
        $user = Auth::user();

        $equipes = $user->equipes;

        return view('equipes.dashboard', ['equipes' => $equipes]);
        
    }

    public function edit($id) {

        $equipe = Equipe::findOrFail($id);

        return view('equipes.edit', ['equipe' => $equipe]);
    
    }

    public function update(Request $request) {

        Equipe::findOrFail($request->id)->update($request->all());

        return redirect()->route('equipes.dashboard')->with('msg', 'Equipe editada com sucesso!');
    }
}
