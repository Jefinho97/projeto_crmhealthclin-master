<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Dieta;

use Yajra\DataTables\Facades\DataTables as DataTables;
use BaconQrCode\Renderer\Color\Rgb;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use mysqli;

class DietaController extends Controller
{
    public function dashboard(Request $request) {
        
        $user = Auth::user();
        $dietas = $user->dietas;

        if($request->ajax()) {
            return datatables::of($dietas)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<div style="text-align: center;"><button class="btn btn-sm btn-info" id="edit" data-id="'. route("dietas.edit", ["id" => $row->id]) .'"> Editar </button>';
   
                $btn = $btn.' <button class="btn btn-sm btn-danger" data-id="'. route("dietas.destroy", ["id" => $row->id]) .'" id="destroy">Delete</button> </div>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('dietas.dashboard', compact('dietas'));
        
    }

    public function store(Request $request) {
        
        $dieta = Dieta::updateOrCreate([
            'id' => $request->dieta_id
        ], [
            'nome' => $request->nome,
            'uni_medida' => $request->uni_medida,
            'custo' => $request->custo,
            'venda' => $request->venda,
            'user_id' => Auth::id()
        ]);
 
            return;

    }

    public function edit($id) {

        $dieta = Dieta::findOrFail($id);

        return response()->json($dieta);
    
    }    

    public function destroy($id) {
        $dieta = Dieta::findOrFail($id);
        $dieta->orcamentos()->detach();
        $dieta->delete();

        return;
        
    }
}
