<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables as DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\medicamento;
use Illuminate\Http\Request;

class MedicamentoController extends Controller
{
    public function dashboard(Request $request) {
        
        $user = Auth::user();
        $medicamentos = $user->medicamentos;

        if($request->ajax()) {
            return datatables::of($medicamentos)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<div style="text-align: center;"><button class="btn btn-sm btn-info" id="edit" data-id="'. route("medicamentos.edit", ['id' => $row->id]) .'"> Editar </button>';
   
                $btn = $btn.' <button class="btn btn-sm btn-danger" data-id="'. route("medicamentos.destroy", ["id" => $row->id]) .'" id="destroy">Delete</button> </div>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('medicamentos.dashboard', compact('medicamentos'));
        
    }

    public function store(Request $request) {
        
        $medicamento = Medicamento::updateOrCreate([
            'id' => $request->medicamento_id
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

        $medicamento = Medicamento::findOrFail($id);

        return response()->json($medicamento);
    
    }    

    public function destroy($id) {
        $medicamento = Medicamento::findOrFail($id);
        $medicamento->orcamentos()->detach();
        $medicamento->delete();

        return;
        
    }
}
