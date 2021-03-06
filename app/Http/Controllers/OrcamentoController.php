<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Orcamento;
use App\Models\Diaria;
use App\Models\Dieta;
use App\Models\Equipamento;
use App\Models\Equipe;
use App\Models\Material;
use App\Models\Medicamento;
use App\Models\Medico;
use App\Models\User;

use BaconQrCode\Renderer\Color\Rgb;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use mysqli;
use PhpParser\Node\Stmt\Return_;
use Barryvdh\DomPDF\Facade as PDF;
use Yajra\DataTables\Facades\DataTables as DataTables;
use DateTime;

class OrcamentoController extends Controller
{
    // Paginas Principais

    public function index()
    {

        if (Auth::check()) {
            
            return redirect()->route('orcamentos.dashboard');
        
        }

        return view('auth.login');
    }

    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $orcamentos = $user->orcamentos;
        $solicitados = 0;
        $fechados = 0;
        $perdidos = 0;
        $abertos = 0;
        foreach($orcamentos as $orcamento){
            switch ($orcamento->status){
                case 'solicitado':
                    $solicitados++;
                    break;
                case 'fechado':
                    $fechados++;
                    break;
                case 'perdido':
                    $perdidos++;
                    break;
                case 'aberto':
                    $abertos++;
                    break;
            }
                
        };
        if ($request->ajax()) {
            if(!empty($request->min) ){
                $orcamentos = $orcamentos->whereBetween('created_at', [$request->min, $request->max]);
            } else {
                $orcamentos = $orcamentos;
            }
            return Datatables::of($orcamentos)
                ->addIndexColumn()
                ->addColumn('formData', function ($row) {
                    $btn = date('Y-m-d', strtotime($row->created_at));
                    return $btn;
                })
                ->addColumn('formProcedimento', function ($row) {
                    $btn = '<a href="./show/' . $row->id . ' class="btn btn-light" style="color: inherit;">'. $row->procedimento . '</a>';
                    return $btn;
                })
                ->addColumn('action', function ($row) {

                    $btn = '<div style="text-align: center;"><a href="./edit/' . $row->id . '" class="btn btn-sm btn-info"> Editar </a>';

                    $btn = $btn . ' <button class="btn btn-sm btn-danger" data-id="./' . $row->id . '" id="destroy">Delete</button> </div>';

                    return $btn;
                })
                ->addColumn('medico', function ($row){
                    return $row->medico_id;
                })
                ->rawColumns(['action', 'formData', 'formProcedimento', 'medico'])
                ->make(true);
        }

        return view('orcamentos.dashboard', [compact('orcamentos'), 'solicitados' => $solicitados, 'fechados' => $fechados, 'perdidos' => $perdidos, 'abertos' => $abertos, 'user' => $user]);
    }

    // Criar Or??amento

    public function store(Request $request)
    {

        $orcamento = new Orcamento;

        $orcamento->procedimento = $request->procedimento;
        $orcamento->paciente = $request->paciente;
        $orcamento->email_pac = $request->email_pac;
        $orcamento->telefone_1 = $request->telefone_1;
        $orcamento->telefone_2 = $request->telefone_2;

        $orcamento->user_id = Auth::user()->id;
        $orcamento->save();

        return;
    }

    // Apagar Or??amento

    public function destroy($id)
    {
        $orcamento = Orcamento::find($id);
        $orcamento->diarias()->detach();
        $orcamento->equipes()->detach();
        $orcamento->materiais()->detach();
        $orcamento->dietas()->detach();
        $orcamento->equipamentos()->detach();
        $orcamento->medicamentos()->detach();
        $orcamento->delete();

        return;
    }

    // Editar Or??amento

    public function edit($id)
    {
        $user = Auth::user();
        $orcamento = Orcamento::findOrFail($id);
        foreach($user->equipes as $equipe){
            $a = [
                0 => $equipe->id,
                1 => $equipe->funcao,
            ];
            $b = implode("!",$a);
            $equipes[] = $b;
        }
        if(isset($orcamento->equipes) && $orcamento->equipes->count() > 0){
            foreach ($orcamento->equipes as $pivot) {
                $a = [
                    0 => $pivot->pivot->equipe_id,
                    1 => $pivot->pivot->quant,
                ];
                $b = implode("!",$a);
                $orcequ[] = $b;
            }     
        }
        $string_orcequ = isset($orcequ)?implode("|", $orcequ):null;   
        $string_equipes = implode("|",$equipes);

        foreach($user->medicamentos as $medicamento){
            $a = [
                0 => $medicamento->id,
                1 => $medicamento->nome,
            ];
            $b = implode("!",$a);
            $medicamentos[] = $b;
        }
        if(isset($orcamento->medicamentos) && $orcamento->medicamentos->count() > 0){
            foreach ($orcamento->medicamentos as $pivot) {
                $a = [
                    0 => $pivot->pivot->medicamento_id,
                    1 => $pivot->pivot->quant,
                ];
                $b = implode("!",$a);
                $orcmed[] = $b;
            }
            
        }
        $string_orcmed = isset($orcmed)?implode("|", $orcmed):null;
        $string_medicamentos = implode("|",$medicamentos);
        
        foreach($user->equipamentos as $equipamento){
            $a = [
                0 => $equipamento->id,
                1 => $equipamento->nome,
            ];
            $b = implode("!",$a);
            $equipamentos[] = $b;
        }
        if(isset($orcamento->equipamentos) && $orcamento->equipamentos->count() > 0){
            foreach ($orcamento->equipamentos as $pivot) {
                $a = [
                    0 => $pivot->pivot->equipamento_id,
                    1 => $pivot->pivot->quant,
                ];
                $b = implode("!",$a);
                $orcequipa[] = $b;
            }

        }
        $string_orcequipa = isset($orcequipa)?implode("|", $orcequipa):null;
        $string_equipamentos = implode("|",$equipamentos);

        foreach($user->dietas as $dieta){
            $a = [
                0 => $dieta->id,
                1 => $dieta->nome,
            ];
            $b = implode("!",$a);
            $dietas[] = $b;
        }
        if(isset($orcamento->dietas) && $orcamento->dietas->count() > 0){
            foreach ($orcamento->dietas as $pivot) {
                $a = [
                    0 => $pivot->pivot->dieta_id,
                    1 => $pivot->pivot->quant,
                ];
                $b = implode("!",$a);
                $orcdie[] = $b;
            }
        }
        $string_orcdie = isset($orcdie)?implode("|", $orcdie):null;
        $string_dietas = implode("|",$dietas);

        foreach($user->materiais as $material){
            $a = [
                0 => $material->id,
                1 => $material->nome,
            ];
            $b = implode("!",$a);
            $materiais[] = $b;
        }
        if(isset($orcamento->materiais) && $orcamento->materiais->count() > 0){
            foreach ($orcamento->materiais as $pivot) {
                $a = [
                    0 => $pivot->pivot->material_id,
                    1 => $pivot->pivot->quant,
                ];
                $b = implode("!",$a);
                $orcmat[] = $b;
            }
        }            
        $string_orcmat = isset($orcmat)?implode("|", $orcmat):null;
        $string_materiais = implode("|",$materiais);

        foreach($user->diarias as $diaria){
            $a = [
                0 => $diaria->id,
                1 => $diaria->descricao,
            ];
            $b = implode("!",$a);
            $diarias[] = $b;
        }
        if(isset($orcamento->diarias) && $orcamento->diarias->count() > 0){
            foreach ($orcamento->diarias as $pivot) {
                $orcdia[] = $pivot->pivot->diaria_id;
            }
        }
        $string_orcdia = isset($orcdia)?implode("|", $orcdia):null;
        $string_diarias = implode("|",$diarias);

        return view('orcamentos.edit',['user' => $user, 'orcamento' => $orcamento, 'string_orcequ' => $string_orcequ, 'string_equipes' => $string_equipes,'string_orcmed' => $string_orcmed, 'string_medicamentos' => $string_medicamentos,'string_orcdia' => $string_orcdia, 'string_diarias' => $string_diarias,'string_orcdie' => $string_orcdie, 'string_dietas' => $string_dietas,'string_orcequipa' => $string_orcequipa, 'string_equipamentos' => $string_equipamentos,'string_orcmat' => $string_orcmat, 'string_materiais' => $string_materiais]);
    }

    public function update(Request $request)
    {
        $orcamento = Orcamento::findOrFail($request->id);
        $x = new Orcamento;

        // update tipo, medico, equipe
        if ($request->tipo == true) {
            $orcamento->equipes()->detach();
            $equipes = $request->equipes;
            $quant = (is_array($equipes) ? count($equipes) : 0);
            if ($quant > 0) {
                for ($equ = 0; $equ < $quant; $equ++) {
                    $equipe = Equipe::findOrFail($equipes[$equ]);
                    if (is_null($equipe) == false) {
                        $q = $request->quant_equ[$equ];
                        $soma_custo = $equipe->custo * $q;
                        $soma_venda = $equipe->venda * $q;
                        $x->custo_equipe += $soma_custo;
                        $x->venda_equipe += $soma_venda;
                        $orcamento->equipes()->attach($equipe->id, ['quant' => $q, 'soma_custo' => $soma_custo, 'soma_venda' => $soma_venda]);
                    }
                }
                $orcamento->update(['custo_equipe' => $x->custo_equipe, 'venda_equipe' => $x->venda_equipe]);
            } else {
                $orcamento->update(['custo_equipe' => 0, 'venda_equipe' => 0]);
            }
            $orcamento->update(['tipo' => true]);
        } else {
            if ($orcamento->tipo == true) {
                $orcamento->update(['tipo' => false, 'custo_equipe' => 0, 'venda_equipe' => 0]);
            }
        }

        // update material
        $orcamento->materiais()->detach();
        $materiais = $request->materiais;
        $quant = (is_array($materiais) ? count($materiais) : 0);

        if ($quant > 0) {
            for ($mat = 0; $mat < $quant; $mat++) {
                $material = Equipe::findOrFail($materiais[$mat]);
                if (is_null($material) == false) {
                    $q = $request->quant_mat[$mat];
                    $soma_custo = $material->custo * $q;
                    $soma_venda = $material->venda * $q;
                    $x->venda_material += $soma_venda;
                    $x->custo_material += $soma_custo;

                    $orcamento->materiais()->attach($material->id, ['quant' => $q, 'soma_custo' => $soma_custo, 'soma_venda' => $soma_venda]);
                }
            }

            $orcamento->update(['venda_material' => $x->venda_material, 'custo_material' => $x->custo_material]);
        } else {
            $orcamento->update(['venda_material' => 0, 'custo_material' => 0]);
        }

        // update dieta
        $orcamento->dietas()->detach();
        $dietas = $request->dietas;
        $quant = (is_array($dietas) ? count($dietas) : 0);

        if ($quant > 0) {
            for ($die = 0; $die < $quant; $die++) {
                $dieta = Dieta::findOrFail($dietas[$die]);
                if (is_null($dieta) == false) {
                    $q = $request->quant_die[$die];
                    $soma_custo = $dieta->custo * $q;
                    $soma_venda = $dieta->venda * $q;
                    $x->venda_dieta += $soma_venda;
                    $x->custo_dieta += $soma_custo;

                    $orcamento->dietas()->attach($dieta->id, ['quant' => $q, 'soma_custo' => $soma_custo, 'soma_venda' => $soma_venda]);
                }
            }
            $orcamento->update(['venda_dieta' => $x->venda_dieta, 'custo_dieta' => $x->custo_dieta]);
        } else {
            $orcamento->update(['venda_dieta' => 0, 'custo_dieta' => 0]);
        }

        // update equipamento
        $orcamento->equipamentos()->detach();
        $equipamentos = $request->equipamentos;
        $quant = (is_array($equipamentos) ? count($equipamentos) : 0);

        if ($quant > 0) {
            for ($equipa = 0; $equipa < $quant; $equipa++) {
                $equipamento = Equipamento::findOrFail($equipamentos[$equipa]);
                if (is_null($equipamento) == false) {
                    $q = $request->quant_equipa[$equipa];
                    $soma_custo = $equipamento->custo * $q;
                    $soma_venda = $equipamento->venda * $q;
                    $x->venda_equipamento += $soma_venda;
                    $x->custo_equipamento += $soma_custo;

                    $orcamento->equipamentos()->attach($equipamento->id, ['quant' => $q, 'soma_custo' => $soma_custo, 'soma_venda' => $soma_venda]);
                }
            }
            $orcamento->update(['venda_equipamento' => $x->venda_equipamento, 'custo_equipamento' => $x->custo_equipamento]);
        } else {
            $orcamento->update(['venda_equipamento' => 0, 'custo_equipamento' => 0]);
        }

        // update medicamento
        $orcamento->medicamentos()->detach();
        $medicamentos = $request->medicamentos;
        $quant = (is_array($medicamentos) ? count($medicamentos) : 0);

        if ($quant > 0) {
            for ($med = 0; $med < $quant; $med++) {
                $medicamento = Medicamento::findOrFail($medicamentos[$med]);
                if (is_null($medicamento) == false) {
                    $q = $request->quant_med[$med];
                    $soma_custo = $medicamento->custo * $q;
                    $soma_venda = $medicamento->venda * $q;
                    $x->venda_medicamento += $soma_venda;
                    $x->custo_medicamento += $soma_custo;

                    $orcamento->medicamentos()->attach($medicamento->id, ['quant' => $q, 'soma_custo' => $soma_custo, 'soma_venda' => $soma_venda]);
                }
            }
            $orcamento->update(['venda_medicamento' => $x->venda_medicamento, 'custo_medicamento' => $x->custo_medicamento]);
        } else {
            $orcamento->update(['venda_medicamento' => 0, 'custo_medicamento' => 0]);
        }

        // update diaria
        $orcamento->diarias()->detach();
        $diarias = $request->diarias;
        $quant = (is_array($diarias) ? count($diarias) : 0);

        if ($quant > 0) {
            for ($dia = 0; $dia < $quant; $dia++) {
                $diaria = Diaria::findOrFail($diarias[$dia]);
                if (is_null($diaria) == false) {
                    $x->venda_diaria += $diaria->venda;
                    $x->custo_diaria += $diaria->custo;

                    $orcamento->diarias()->attach($diaria->id);
                }
            }
            $orcamento->update(['venda_diaria' => $x->venda_diaria, 'custo_diaria' => $x->custo_diaria]);
        } else {
            $orcamento->update(['venda_diaria' => 0, 'custo_diaria' => 0]);
        }

        //update resto
        if (is_null($orcamento->valor_inicial)) {
            $x->valor_inicial = $request->preco_medico + $x->venda_equipe + $x->venda_material + $x->venda_equipamento + $x->venda_medicamento + $x->venda_dieta + $x->venda_diaria;
            $orcamento->update(['valor_inicial' => $x->valor_inicial, 'valor_final' => $x->valor_inicial]);
        } else {
            $x->valor_final = $request->preco_medico + $x->venda_equipe + $x->venda_material + $x->venda_equipamento + $x->venda_medicamento + $x->venda_dieta + $x->venda_diaria;
            $orcamento->update(['valor_final' => $x->valor_final]);
        }

        $orcamento->update([
            'procedimento' => $request->procedimento, 'solicitante' => $request->solicitante, 'paciente' => $request->paciente,
            'email_pac' => $request->email_pac, 'telefone_1' => $request->telefone_1, 'telefone_2' => $request->telefone_2,
            'termos_condicoes' => $request->termos_condicoes, 'convenios' => $request->convenios,
            'condicoes_pag' => $request->condicoes_pag, 'data' => $request->data,
            'status' => $request->status,'razao_status' => $request->razao_status, 'medico_id' => $request->medico, 'preco_medico' => $request->preco_medico
        ]);

        return redirect()->route('orcamentos.dashboard')->with('msg', 'Or??amentos   editado com sucesso!');
    }

    // Detalhar Or??amento

    public function show($id)
    {
        $orcamento = Orcamento::findOrFail($id);
        
        return view('orcamentos.show', ['orcamento' => $orcamento]);
    }

    public function gerarpdf($id)
    {
        $orcamento = Orcamento::findOrFail($id);
        $pdf = PDF::loadView('orcamentos.pdf', ['orcamento' => $orcamento]);
        return $pdf->setPaper('a4')->stream('pdf.pdf');
    }

    public function up_show(Request $request)
    {
        Orcamento::findOrFail($request->id)->update(['desconto' => $request->desconto]);

        return;
    }
}
