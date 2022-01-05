<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Material;
use App\Models\User;

use Yajra\DataTables\Facades\DataTables as DataTables;
use Illuminate\Support\Facades\Auth;
use mysqli;

class MaterialController extends Controller
{

    public function dashboard(Request $request) {
        
        $user = Auth::user();
        $materiais = $user->materials;

        if($request->ajax()) {
            return datatables::of($materiais)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<div style="text-align: center;"><button class="btn btn-sm btn-info" id="edit" data-id="'. route("materiais.edit", ['id' => $row->id]) .'"> Editar </button>';
   
                $btn = $btn.' <button class="btn btn-sm btn-danger" data-id="'. route("materiais.destroy", ["id" => $row->id]) .'" id="destroy">Delete</button> </div>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('materiais.dashboard', compact('materiais'));
        
    }

    public function store(Request $request) {
        
        $material = Material::updateOrCreate([
            'id' => $request->material_id
        ], [
            'tipo' => $request->tipo,
            'nome' => $request->nome,
            'uni_medida' => $request->uni_medida,
            'custo' => $request->custo,
            'venda' => $request->venda,
            'user_id' => Auth::id()
        ]);
 
            return;

    }

    public function edit($id) {

        $material = Material::findOrFail($id);

        return response()->json($material);
    
    }    

    public function destroy($id) {
        $material = Material::findOrFail($id);
        $material->orcamentos()->detach();
        $material->delete();

        return;
        
    }

}
