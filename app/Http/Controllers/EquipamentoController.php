<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Dieta;
use App\Models\Equipamento;
use Yajra\DataTables\Facades\DataTables as DataTables;
use BaconQrCode\Renderer\Color\Rgb;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use mysqli;

class EquipamentoController extends Controller
{
    public function dashboard(Request $request) {
        
        $user = Auth::user();
        $equipamentos = $user->equipamentos;

        if($request->ajax()) {
            return datatables::of($equipamentos)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<div style="text-align: center;"><button class="btn btn-sm btn-info" id="edit" data-id="'. route("equipamentos.edit", ["id" => $row->id]) .'"> Editar </button>';
   
                $btn = $btn.' <button class="btn btn-sm btn-danger" data-id="'. route("equipamentos.destroy", ["id" => $row->id]) .'" id="destroy">Delete</button> </div>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('equipamentos.dashboard', compact('equipamentos'));
        
    }

    public function store(Request $request) {
        
        $equipamento = Equipamento::updateOrCreate([
            'id' => $request->equipamento_id
        ], [
            'nome' => $request->nome,
            'marca_modelo' => $request->marca_modelo,
            'uni_medida' => $request->uni_medida,
            'preco' => $request->preco,
            'depreciacao' => $request->depreciacao,
            'custo_dia' => $request->custo_dia,
            'valor_dia' => $request->valor_dia,
            'user_id' => Auth::id()
        ]);
 
            return;

    }

    public function edit($id) {

        $equipamento = Equipamento::findOrFail($id);

        return response()->json($equipamento);
    
    }    

    public function destroy($id) {
        $equipamento = Equipamento::findOrFail($id);
        $equipamento->orcamentos()->detach();
        $equipamento->delete();

        return;
        
    }
}
