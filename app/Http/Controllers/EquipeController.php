<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Orcamento;
use App\Models\Diaria;
use App\Models\Equipe;
use App\Models\Material;
use App\Models\User;

use Yajra\DataTables\Facades\DataTables as DataTables;

use BaconQrCode\Renderer\Color\Rgb;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use mysqli;

class EquipeController extends Controller
{

    public function dashboard(Request $request) {
        
        $user = Auth::user();
        $equipes = $user->equipes;

        if($request->ajax()) {
            return datatables::of($equipes)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<div style="text-align: center;"><button class="btn btn-sm btn-info" id="edit" data-id="'. route("equipes.edit", ['id' => $row->id]) .'"> Editar </button>';
   
                $btn = $btn.' <button class="btn btn-sm btn-danger" data-id="'. route("equipes.destroy", ["id" => $row->id]) .'" id="destroy">Delete</button> </div>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('equipes.dashboard', compact('equipes'));
        
    }

    public function store(Request $request) {
        
        $equipe = Equipe::updateOrCreate([
            'id' => $request->equipe_id
        ], [
            'funcao' => $request->funcao,
            'custo' => $request->custo,
            'venda' => $request->venda,
            'user_id' => Auth::id()
        ]);
 
            return;

    }

    public function edit($id) {

        $equipe = Equipe::findOrFail($id);

        return response()->json($equipe);
    
    }    

    public function destroy($id) {
        $equipe = Equipe::findOrFail($id);
        $equipe->orcamentos()->detach();
        $equipe->delete();

        return;
        
    }
}
