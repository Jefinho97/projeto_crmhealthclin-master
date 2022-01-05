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

class DiariaController extends Controller
{

    public function dashboard(Request $request) {
        
        $user = Auth::user();
        $diarias = $user->diarias;

        if($request->ajax()) {
            return datatables::of($diarias)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<div style="text-align: center;"><button class="btn btn-sm btn-info" id="edit" data-id="'. route("diarias.edit", ['id' => $row->id]) .'"> Editar </button>';
   
                $btn = $btn.' <button class="btn btn-sm btn-danger" data-id="'. route("diarias.destroy", ["id" => $row->id]) .'" id="destroy">Delete</button> </div>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('diarias.dashboard', compact('diarias'));
        
    }

    public function store(Request $request) {
        
        $diaria = Diaria::updateOrCreate([
            'id' => $request->diaria_id
        ], [
            'descricao' => $request->descricao,
            'custo' => $request->custo,
            'venda' => $request->venda,
            'user_id' => Auth::id()
        ]);
 
            return;

    }

    public function edit($id) {

        $diaria = Diaria::findOrFail($id);

        return response()->json($diaria);
    
    }    

    public function destroy($id) {
        $diaria = Diaria::findOrFail($id);
        $diaria->orcamentos()->detach();
        $diaria->delete();

        return;
        
    }

}