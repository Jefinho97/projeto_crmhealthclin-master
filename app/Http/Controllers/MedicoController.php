<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables as DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\medico;
use Illuminate\Http\Request;

class MedicoController extends Controller
{
    public function dashboard(Request $request) {
        
        $user = Auth::user();
        $medicos = $user->medicos;

        if($request->ajax()) {
            return datatables::of($medicos)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<div style="text-align: center;"><button class="btn btn-sm btn-info" id="edit" data-id="'. route("medicos.edit", ['id' => $row->id]) .'"> Editar </button>';
   
                $btn = $btn.' <button class="btn btn-sm btn-danger" data-id="'. route("medicos.destroy", ["id" => $row->id]) .'" id="destroy">Delete</button> </div>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('medicos.dashboard', compact('medicos'));
        
    }

    public function store(Request $request) {
        
        $medico = Medico::updateOrCreate([
            'id' => $request->medico_id
        ], [
            'nome' => $request->nome,
            'crm' => $request->uni_medida,
            'uf' => $request->custo,
            'user_id' => Auth::id()
        ]);
 
            return;

    }

    public function edit($id) {

        $medico = Medico::findOrFail($id);

        return response()->json($medico);
    
    }    

    public function destroy($id) {
        $medico = Medico::findOrFail($id);
        $medico->orcamentos()->detach();
        $medico->delete();

        return;
        
    }
}
