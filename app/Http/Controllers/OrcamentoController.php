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
use PhpParser\Node\Stmt\Return_;
use Barryvdh\DomPDF\Facade as PDF;
use Yajra\DataTables\Facades\DataTables as DataTables;
class OrcamentoController extends Controller
{
    // Paginas Principais

    public function index() {
        
        if(Auth::check()) {

        return redirect()->route('orcamentos.dashboard');

        }

        return view('auth.login');

    }    

    public function dashboard(Request $request) {
        $user = Auth::user();
        $orcamentos = $user->orcamentos;

        if ($request->ajax()) {
            return Datatables::of($orcamentos)
                    ->addIndexColumn()
                    ->addColumn('formData', function($row){
                        $btn = date('d/m/y', strtotime($row->data));

                            return $btn;
                    })
                    ->addColumn('formStatus', function($row){
                        $btn = '<select name="status" id="status" data-id="./status/'. $row->id .'" class="form-control">   <option value="----">----</option><option value="novo" '. ($row->status === "novo"? "selected" :"") .'>Novo</option>  <option value="aguardando" '. ($row->status === "aguardando"? "selected" : "") .'>Aguardando</option> <option value="em andamento" '. ($row->status === "em andamento"? "selected" : "") .'>Em andamento</option> <option value="cancelado" '. ($row->status === "cancelado"? "selected" : "") .'>Cancelado</option> <option value="ganho" '. ($row->status === "ganho"? "selected" : "") .'>Ganho</option> <option value="perdido" '. ($row->status === "perdido"? "selected" : "") .'>Perdido</option> <option value="desistencia" '. ($row->status === "desistencia"? "selected" : "") .'>Desistencia</option>    </select>';
                        return $btn;
                    })
                    ->addColumn('formRazao', function($row){
                        $btn = '<select name="razao_status" id="razao_status" data-id="./razao_status/'. $row->id .'" class="form-control"> <option value="----">----</option>  <option value="na fila" '. ($row->razao_status === "na fila"? "selected" :"") .'>Na fila para atendimento</option> <option value="aguardando cliente" '. ($row->razao_status === "aguardando cliente"? "selected" : "") .'>Aguardando cliente</option>  <option value="aguardando envio" '. ($row->razao_status === "aguardando envio"? "selected" : "") .'>Aguardando envio do cirurgião</option>  </select>';
                        return $btn;
                    })
                    ->addColumn('action', function($row){
   
                           $btn = '<div style="text-align: center;"><a href="./edit/'. $row->id .'" class="btn btn-sm btn-info edit-btn "> Editar </a>';
   
                           $btn = $btn.' <button class="btn btn-sm btn-danger" data-id="./'. $row->id .'" id="destroy">Delete</button> </div>';
    
                            return $btn;
                    })
                    ->rawColumns(['action', 'formData', 'formStatus', 'formRazao'])
                    ->make(true);
        }
      
        return view('orcamentos.dashboard',compact('orcamentos'));
        /*$user = Auth::user();
        $orcamentos = $user->orcamentos;

        return view('orcamentos.dashboard', ['orcamentos' => $orcamentos]);*/
    }

    // Criar Orçamento

    public function create(){
        $materiais = Material::all();
        $diarias = Diaria::all();
        $equipes = Equipe::all();
        
        return view('orcamentos.create', ['materiais' => $materiais, 'diarias' => $diarias, 'equipes' => $equipes]);

    }

    
    public function store(Request $request) {
        
        $orcamento = new Orcamento;

        $orcamento->procedimento = $request->procedimento;
        $orcamento->paciente = $request->paciente;
        $orcamento->email_pac = $request->email_pac;
        $orcamento->telefone_1 = $request->telefone_1;
        $orcamento->telefone_2 = $request->telefone_2;
        $orcamento->termos_condicoes = $request->termos_condicoes;
        $orcamento->convenios = $request->convenios;
        $orcamento->condicoes_pag = $request->condicoes_pag;
        $orcamento->data = $request->data;
        $orcamento->tipo = $request->has('tipo');  
        
        $orcamento->user_id = Auth::user()->id;
        $orcamento->save();
        $orcamento = Orcamento::all()->last();

        if($orcamento->tipo == true){
            $orcamento->medico = $request->medico;
            $orcamento->preco_medico = $request->preco_medico;

            $equipes = $request->equipes;
            $quant = (is_array($equipes) ? count($equipes) : 0);

        for ($equ=0; $equ < $quant; $equ++) { 
            $equipe = Equipe::findOrFail($equipes[$equ]);
            if (is_null($equipe) == false){
            $q = $request->quant_equ[$equ];
            $soma_custo = $equipe->custo * $q;
            $soma_venda = $equipe->venda * $q;
            $orcamento->custo_equipe += $soma_custo;
            $orcamento->venda_equipe += $soma_venda;

            $orcamento->equipes()->attach($equipe->id, ['quant' => $q, 'soma_custo' => $soma_custo, 'soma_venda' => $soma_venda]);
            }
        }
        }
        $materials = $request->materials;
        $diarias = $request->diarias;

        $quant = (is_array($materials) ? count($materials) : 0);

        for ($mat=0; $mat < $quant; $mat++) {
            $material = Material::findOrFail($materials[$mat]);
            if (is_null($material) == false){
            $q = $request->quant_mat[$mat];
            $soma_custo = $material->custo * $q;
            $soma_venda = $material->venda * $q;
            switch($material->tipo){
                case "material":
                    $orcamento->venda_material += $soma_venda;
                    $orcamento->custo_material += $soma_custo;
                    break;
                case "medicamento":
                    $orcamento->venda_medicamento += $soma_venda;
                    $orcamento->custo_medicamento += $soma_custo;
                    break;
                case "dieta":
                    $orcamento->venda_dieta += $soma_venda;
                    $orcamento->custo_dieta += $soma_custo;
                    break;
                case "equipamento":
                    $orcamento->venda_equipamento += $soma_venda;
                    $orcamento->custo_equipamento += $soma_custo;
                    break;  
            }
            

            $orcamento->materials()->attach($material->id, ['quant' => $q, 'soma_custo' => $soma_custo, 'soma_venda' => $soma_venda]);
            }
        }

        $quant = (is_array($diarias) ? count($diarias) : 0);

        for ($dia=0; $dia < $quant; $dia++) { 
            $diaria = Diaria::findOrFail($diarias[$dia]);
            if (is_null($diaria) == false){
            $orcamento->venda_diaria += $diaria->venda;
            $orcamento->custo_diaria += $diaria->custo;

            $orcamento->diarias()->attach($diaria->id);
            }
        }
        $orcamento->valor_inicial = $orcamento->venda_material + $orcamento->venda_diaria 
        + $orcamento->venda_medicamento + $orcamento->venda_dieta + $orcamento->venda_equipamento
        + $orcamento->preco_medico + $orcamento->venda_equipe;

        $orcamento->update([
            'custo_material' => $orcamento->custo_material, 'venda_material' => $orcamento->venda_material,
            'custo_medicamento' => $orcamento->custo_medicamento, 'venda_medicamento' => $orcamento->venda_medicamento, 
            'custo_dieta' => $orcamento->custo_dieta, 'venda_dieta' => $orcamento->venda_dieta,
            'custo_equipamento' => $orcamento->custo_equipamento, 'venda_equipamento' => $orcamento->venda_equipamento, 
            'custo_diaria' => $orcamento->custo_diaria, 'venda_diaria' => $orcamento->venda_diaria,
            'valor_inicial' => $orcamento->valor_inicial, 'valor_final' => $orcamento->valor_inicial,
            'medico' => $orcamento->medico, 'preco_medico' => $orcamento->preco_medico,
            'custo_equipe' => $orcamento->custo_equipe, 'venda_equipe' => $orcamento->venda_equipe 
        ]);
    
            return response()->json(['msg'=>'Orçamento foi criado com sucesso!']);
        
    }

    // Apagar Orçamento

    public function destroy($id) {
        $orcamento = Orcamento::find($id);
        $orcamento->diarias()->detach();
        $orcamento->equipes()->detach();
        $orcamento->materials()->detach();
        $orcamento->delete();

            return;
    }

    // Editar Orçamento

    public function edit($id) {

        $orcamento = Orcamento::findOrFail($id);
        $materiais = Material::all();
        $diarias = Diaria::all();
        $equipes = Equipe::all();

        return view('orcamentos.edit', ['orcamento' => $orcamento, 'materiais' => $materiais, 'diarias' => $diarias, 
        'equipes' => $equipes]);
    
    }

    public function update(Request $request) {
        $orcamento = Orcamento::findOrFail($request->id);
        $x = new Orcamento;
        // update tipo, medico, equipe
        if($request->tipo == true){
            $equipes = $request->equipes;
            $quant = (is_array($equipes) ? count($equipes) : 0);
            if($quant > 0){
                for ($equ=0; $equ < $quant; $equ++) {
                    $equipe = Equipe::findOrFail($equipes[$equ]);
                    $pivot = $orcamento->equipes()->where('equipe_id', $equipe->id)->get();
                    if (is_null($pivot)){
                        if (is_null($equipe) == false){
                            $q = $request->quant_equ[$equ];
                            $soma_custo = $equipe->custo * $q;
                            $soma_venda = $equipe->venda * $q;
                            $x->custo_equipe += $soma_custo;
                            $x->venda_equipe += $soma_venda;
                            $orcamento->equipes()->attach($equipe->id, ['quant' => $q, 'soma_custo' => $soma_custo, 'soma_venda' => $soma_venda]);
                        }
                    } else {
                        $q = $request->quant_equ[$equ];
                        $soma_custo = $equipe->custo * $q;
                        $soma_venda = $equipe->venda * $q;
                        $x->custo_equipe += $soma_custo;
                        $x->venda_equipe += $soma_venda;
                    
                        $pivot->updateExistingPivot($equipe->id, ['quant' => $q, 'soma_custo' => $soma_custo, 'soma_venda' => $soma_venda]);
                    }
                }
                $orcamento->update(['medico' => $request->medico, 'preco_medico' => $request->preco_medico, 'custo_equipe' => $x->custo_equipe, 'venda_equipe' => $x->venda_equipe]);
            } else {
                $orcamento->update(['medico' => $request->medico, 'preco_medico' => $request->preco_medico]);
                if(count($orcamento->equipes) > 0){
                    $orcamento->equipes()->detach();
                    $orcamento->update(['custo_equipe' => 0, 'venda_equipe' => 0]);
                }
            }
        } else {
            if($orcamento->tipo == true){
                $orcamento->update(['medico' => null, 'preco_medico' => 0, 'tipo' => false]);
                if(count($orcamento->equipes) > 0){
                    $orcamento->equipes()->detach();
                    $orcamento->update(['custo_equipe' => 0, 'venda_equipe' => 0]);
                }
            }
        }

        // update material
        $materials = $request->materials;
        $quant = (is_array($materials) ? count($materials) : 0);

        if($quant > 0){
            for ($mat=0; $mat < $quant; $mat++) {
                $material = Equipe::findOrFail($materials[$mat]);
                $pivot = $orcamento->materials()->where('material_id', $material->id)->get();
                if (is_null($pivot)){
                    if (is_null($material) == false){
                        $q = $request->quant_mat[$equ];
                        $soma_custo = $material->custo * $q;
                        $soma_venda = $material->venda * $q;
                        switch($material->tipo){
                            case "material":
                                $x->venda_material += $soma_venda;
                                $x->custo_material += $soma_custo;
                                break;
                            case "medicamento":
                                $x->venda_medicamento += $soma_venda;
                                $x->custo_medicamento += $soma_custo;
                                break;
                            case "dieta":
                                $x->venda_dieta += $soma_venda;
                                $x->custo_dieta += $soma_custo;
                                break;
                            case "equipamento":
                                $x->venda_equipamento += $soma_venda;
                                $x->custo_equipamento += $soma_custo;
                                break;  
                        }
                        $orcamento->materials()->attach($equipe->id, ['quant' => $q, 'soma_custo' => $soma_custo, 'soma_venda' => $soma_venda]);
                    }
                } else {
                    $q = $request->quant_equ[$equ];
                    $soma_custo = $material->custo * $q;
                    $soma_venda = $material->venda * $q;
                    switch($material->tipo){
                        case "material":
                            $x->venda_material += $soma_venda;
                            $x->custo_material += $soma_custo;
                            break;
                        case "medicamento":
                            $x->venda_medicamento += $soma_venda;
                            $x->custo_medicamento += $soma_custo;
                            break;
                        case "dieta":
                            $x->venda_dieta += $soma_venda;
                            $x->custo_dieta += $soma_custo;
                            break;
                        case "equipamento":
                            $x->venda_equipamento += $soma_venda;
                            $x->custo_equipamento += $soma_custo;
                            break;  
                    }
                
                    $pivot->updateExistingPivot($material->id, ['quant' => $q, 'soma_custo' => $soma_custo, 'soma_venda' => $soma_venda]);
                }
            }
        
            $orcamento->update(['venda_material' => $x->venda_material, 'custo_material' => $x->custo_material,
            'venda_medicamento' => $x->venda_medicamento, 'custo_medicamento' => $x->custo_medicamento,
            'venda_dieta' => $x->venda_dieta, 'custo_dieta' => $x->custo_dieta,
            'venda_equipamento' => $x->venda_equipamento, 'custo_equipamento' => $x->custo_equipamento]);
        } else {
            if(count($orcamento->materials) > 0){
                $orcamento->materials()->detach();
                $orcamento->update(['venda_material' => 0, 'custo_material' => 0, 'venda_medicamento' => 0, 'custo_medicamento' => 0,
                'venda_dieta' => 0, 'custo_dieta' => 0, 'venda_equipamento' => 0, 'custo_equipamento' => 0]);
            }
        }

        // update diaria
        $diarias = $request->diarias;
        $quant = (is_array($diarias) ? count($diarias) : 0);
        if($quant > 0){
            for ($dia=0; $dia < $quant; $dia++) {
                $diaria = Equipe::findOrFail($materials[$dia]);
                $pivot = $orcamento->diarias()->where('diaria_id', $diaria->id)->get();
                if (is_null($pivot)){
                    if (is_null($diaria) == false){
                        $x->custo_diaria = $diaria->custo;
                        $x->venda_diaria = $diaria->venda;
                        $orcamento->materials()->attach($diaria->id);
                    }
                } else {
                    $x->custo_diaria = $diaria->custo;
                    $x->venda_diaria = $diaria->venda;
                }
            }
            $orcamento->update(['custo_diaria' => $x->custo_diaria, 'venda_diaria' => $x->venda_diaria]);
        } else {
            if(count($orcamento->diarias) > 0){
                $orcamento->diarias()->detach();
                $orcamento->update(['custo_diaria' => 0, 'venda_diaria' => 0]);
            }
        }
        
        //update resto
        $orcamento->valor_final = $request->preco_medico + $x->venda_equipe + $x->venda_material + $x->venda_equipamento + $x->venda_medicamento + $x->venda_dieta + $x->venda_diaria;
        
        $orcamento->update(['procedimento' => $request->procedimento, 'paciente' => $request->paciente, 
        'email_pac' => $request->email_pac, 'telefone_1' => $request->telefone_1, 'telefone_2' => $request->telefone_2, 
        'termos_condicoes' => $request->termos_condicoes, 'convenios' => $request->convenios, 
        'condicoes_pag' => $request->condicoes_pag, 'data' => $request->data, 'valor_final' => $orcamento->valor_final]);
        
        return redirect()->route('orcamentos.dashboard')->with('msg', 'Orçamentos   editado com sucesso!');
    }

    // Detalhar Orçamento

    public function show($id){
        $orcamento = Orcamento::findOrFail($id);
        $user = auth()->user();

        if($user->id == $orcamento->user_id) {
            $materiais = null;
            $medicamentos = null;
            $dietas = null;
            $equipamentos = null;
            foreach($orcamento->materials as $material){
                switch($material->tipo){
                    case "material":
                        $materiais[] = $material;
                        break;
                    case "medicamento":
                        $medicamentos[] = $material;
                        break;
                    case "dieta":
                        $dietas[] = $material;
                        break;
                    case "equipamento":
                        $equipamentos[] = $material;
                        break;
                }
            }

            return view('orcamentos.show', ['orcamento' => $orcamento, 'materiais' => $materiais, 'dietas' => $dietas, 'medicamentos' => $medicamentos, 'equipamentos' => $equipamentos]);
        } else {
            return redirect()->route('index');
        }

    }

    public function gerarpdf($id){
        $orcamento = Orcamento::findOrFail($id);
        $pdf = PDF::loadView('orcamentos.pdf', ['orcamento' => $orcamento]);
        return $pdf->setPaper('a4')->stream('pdf.pdf');
    }

    public function up_show(Request $request){
        Orcamento::findOrFail($request->id)->update([ 'desconto' => $request->desconto, 'valor_final' => ($request->valor_inicial - $request->desconto)]);

        return redirect()->route('orcamentos.up_show', ['id' => $request->id])->with('msg', 'Desconto atualizado com sucesso!');
    }

    public function status(Request $request) {
        Orcamento::findOrFail($request->id)->update([ 'status' => $request->status]);
        
        return;
        
    }

    public function razao_status(Request $request) {

        Orcamento::findOrFail($request->id)->update([ 'razao_status' => $request->razao_status]);

        return;

    }
}
