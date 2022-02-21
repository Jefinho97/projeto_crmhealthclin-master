@extends('layouts.main')

@section('title', 'Editar Orcamento')

@section('content')

<div id="event-create-container" class="col-md-6 offset-md-3" onload="tables()">
    <h1>Editar Orçamento</h1>
    <form action="{{ route('orcamentos.update', [$orcamento->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Procedimento:</label>
            <input type="text" class="form-control" id="procedimento" name="procedimento" value="{{ $orcamento->procedimento }}">
        </div>

        <div class="form-group">
            <label for="title">Solicitante:</label>
            <input type="text" class="form-control" id="solicitante" name="solicitante" value="{{ $orcamento->solicitante }}">
        </div>

        <div class="form-group" >
            Orçamento com equipe médica:<input type="checkbox" name="tipo" id="show" {{$orcamento->tipo == true? 'checked' : ''}}>
        </div>

        <div class="form-group" id="medprof" style="display: {{$orcamento->tipo == true? 'box' : 'none'}}">
                <label for="title">Medico:</label>
                <input type="text" class="form-control" id="medico" name="medico" placeholder="Nome do médico:" value="{{ $orcamento->medico }}">
                <input type="number" step=".01" min="0" class="form-control" id="preco_medico" name="preco_medico" placeholder="Preço do médico" value="{{ $orcamento->preco_medico }}">
            <table class="table table-hover" id="data-table-equipe"> 
                <thead>
                    <tr>
                        <th scope="col">Função</th>
                        <th scope="col">Quantidade</th>
                        <th scope="col">Ação</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

        <div class="form-group">
            <table class="table table-hover" id="data-table-medicamento"> 
                <thead>
                    <tr>
                        <th scope="col">Medicamentos</th>
                        <th scope="col">Quantidade</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>           
        </div>       
        
        <div class="form-group">
            <table class="table table-hover" id="data-table-equipamento"> 
                <thead>
                    <tr>
                        <th scope="col">Equipamentos</th>
                        <th scope="col">Quantidade</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>           
        </div>       

        <div class="form-group">
            <table class="table table-hover" id="data-table-dieta"> 
                <thead>
                    <tr>
                        <th scope="col">Dietas</th>
                        <th scope="col">Quantidade</th>
                    </tr>
                </thead>
                <tbody>
      
                </tbody>           
        </div>    

        <div class="form-group">
            <table class="table table-hover" id="data-table-material"> 
                <thead>
                    <tr>
                        <th scope="col">Materiais</th>
                        <th scope="col">Quantidade</th>
                    </tr>
                </thead>
                <tbody>
        
                </tbody>           
        </div>       

        <div class="form-group">
            <table class="table table-hover" id="data-table-diaria">
                <thead>
                    <tr>
                        <th scope="col">Diarias</th>
                    </tr>
                </thead>
                <tbody>
    
                </tbody>
            </table>
        </div>

        <label for="title">Informações do Paciente {{ $orcamento->paciente}}:</label>
        <div class="form-group">
            <input type="text" class="form-control" id="paciente" name="paciente" value="{{ $orcamento->paciente }}">
        </div>
        <div class="form-group">
            <input type="email" class="form-control" id="email_pac" name="email_pac" value="{{ $orcamento->email_pac}}">
        </div>
        <div class="form-group">    
            <input type="tel" class="form-control" id="telefone_1" name="telefone_1" value="{{ $orcamento->telefone_1 }}">
        </div>
        <div class="form-group">    
            <input type="tel" class="form-control" id="telefone_2" name="telefone_2" value="{{ $orcamento->telefone_2 }}">
        </div>
        
        <div class="form-group">
            <label for="title">Data do Procedimento:</label>
            <input type="date" class="form-control" id="data" name="data" >
        </div>
        <div class="form-group">
            <label for="title">Termos e condições:</label>
            <textarea name="termos_condicoes" id="termos_condicoes" class="form-control">{{ $orcamento->termos_condicoes }}</textarea>    
        </div>
        <div class="form-group">
            <label for="title">Convenios:</label>
            <textarea name="convenios" id="convenios" class="form-control" >{{ $orcamento->convenios }}</textarea>    
        </div>
        <div class="form-group">
            <label for="title">Condições de pagamento:</label>
            <textarea name="condicoes_pag" id="condicoes_pag" class="form-control">{{ $orcamento->condicoes_pag }}</textarea>    
        </div>
        <input type="submit" class="btn btn-primary" value="Editar Orcamento">
    </form>
</div>
<script>
toastr.options.preventDuplicates = true;

$(document).ready( function () {
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });
    
    var table_equipe = $('#data-table-equipe').DataTable({
        "pageLength": 6,
        "language": {
            "zeroRecords": "Nenhum registro encontrado",
            "emptyTable": "Nenhum Registro",
            "processing": "Processando...",
            "paginate": {
                "first":      "Primeiro",
                "last":       "Ultimo",
                "next":       "Proximo",
                "previous":   "Anterior"
            },
        },
        dom: 'Btp',
        buttons: {
            dom: {
                button: {
                className: 'btn btn-success'
                }
            },
            buttons:[{
                text: 'Adicionar Profissional',
                action: function (){
                        equipeAdd();
                },
            }
            ]
        },
    });
    function fistTdEqu(equipes,id){
        var html = '<select name="equipes[]" id="equipes" class="form-control" ><option>----</option>';
        for(let i=0; i < equipes.length; i++){
            let b = equipes[i].split('!');
            var html = html+'<option value="'+b[0]+'" '+(id === b[0]? 'selected' : '')+'>'+b[1]+'</option>';
        }
        return html+'</select>';
    }
    function equipeAdd(equipes,a){
        table_equipe.row.add([
            fistTdEqu(equipes,a[0]),
            '<input type="number" class="form-control" name="quant_equ[]" id="quant_equ" value="'+a[1]+'">',
            '<div style="text-align: center;"><button class="btn btn-sm btn-danger" id="delEquipe">Delete</button></div>'
        ]).draw(false);
    }
    $('#data-table-equipe').on("click", "#delEquipe", function(){
        console.log($(this).parent());
        table_equipe.row($(this).parents('tr')).remove().draw(false);
    });
  
    var table_medicamento = $('#data-table-medicamento').DataTable({
        "pageLength": 6,
        "language": {
            "zeroRecords": "Nenhum registro encontrado",
            "emptyTable": "Nenhum Registro",
            "processing": "Processando...",
            "paginate": {
                "first":      "Primeiro",
                "last":       "Ultimo",
                "next":       "Proximo",
                "previous":   "Anterior"
            },
        },
        dom: 'Btp',
        buttons: {
            dom: {
                button: {
                className: 'btn btn-success'
                }
            },
            buttons:[{
                text: 'Adicionar Medicamento',
                action: function (){
                        medicamentoAdd();
                },
            }
            ]
        }
    });
    function fistTdMed(medicamentos,id){
        var html = '<select name="medicamentos[]" id="medicamentos" class="form-control" ><option>----</option>';
        for(let i=0; i < medicamentos.length; i++){
            let b = medicamentos[i].split('!');
            var html = html+'<option value="'+b[0]+'" '+(id === b[0]? 'selected' : '')+'>'+b[1]+'</option>';
        }
        return html+'</select>';
    }
    function medicamentoAdd(medicamentos,a){
        table_medicamento.row.add([
            fistTdMed(medicamentos,a[0]),
            '<input type="number" class="form-control" name="quant_med[]" id="quant_med" value="'+a[1]+'">',
            '<div style="text-align: center;"><button class="btn btn-sm btn-danger" id="delMedicamento">Delete</button></div>'
        ]).draw(false);
    }
    $('#data-table-medicamento').on("click", "#delMedicamento", function(){
        console.log($(this).parent());
        table_medicamento.row($(this).parents('tr')).remove().draw(false);
    });

    var table_equipamento = $('#data-table-equipamento').DataTable({
        "pageLength": 6,
        "language": {
            "zeroRecords": "Nenhum registro encontrado",
            "emptyTable": "Nenhum Registro",
            "processing": "Processando...",
            "paginate": {
                "first":      "Primeiro",
                "last":       "Ultimo",
                "next":       "Proximo",
                "previous":   "Anterior"
            },
        },
        dom: 'Btp',
        buttons: {
            dom: {
                button: {
                className: 'btn btn-success'
                }
            },
            buttons:[{
                text: 'Adicionar Equipamento',
                action: function (){
                        equipamentoAdd;
                },
            }
            ]
        }
    });
    function fistTdEquipa(equipamentos,id){
        var html = '<select name="equipamentos[]" id="equipamentos" class="form-control" ><option>----</option>';
        for(let i=0; i < equipamentos.length; i++){
            let b = equipamentos[i].split('!');
            var html = html+'<option value="'+b[0]+'" '+(id === b[0]? 'selected' : '')+'>'+b[1]+'</option>';
        }
        return html+'</select>';
    }
    function equipamentoAdd(equipamentos,a){
        table_equipamento.row.add([
            fistTdEquipa(equipamentos,a[0]),
            '<input type="number" class="form-control" name="quant_equipa[]" id="quant_equipa" value="'+a[1]+'">',
            '<div style="text-align: center;"><button class="btn btn-sm btn-danger" id="delEquipamento">Delete</button></div>'
        ]).draw(false);
    }
    $('#data-table-equipamento').on("click", "#delEquipamento", function(){
        console.log($(this).parent());
        table_equipamento.row($(this).parents('tr')).remove().draw(false);
    });

    var table_dieta = $('#data-table-dieta').DataTable({
        "pageLength": 6,
        "language": {
            "zeroRecords": "Nenhum registro encontrado",
            "emptyTable": "Nenhum Registro",
            "processing": "Processando...",
            "paginate": {
                "first":      "Primeiro",
                "last":       "Ultimo",
                "next":       "Proximo",
                "previous":   "Anterior"
            },
        },
        dom: 'Btp',
        buttons: {
            dom: {
                button: {
                className: 'btn btn-success'
                }
            },
            buttons:[{
                text: 'Adicionar Dieta',
                action: function (){
                        dietaAdd();
                },
            }
            ]
        }
    });
    function fistTdDie(dietas,id){
        var html = '<select name="dietas[]" id="dietas" class="form-control" ><option>----</option>';
        for(let i=0; i < dietas.length; i++){
            let b = dietas[i].split('!');
            var html = html+'<option value="'+b[0]+'" '+(id === b[0]? 'selected' : '')+'>'+b[1]+'</option>';
        }
        return html+'</select>';
    }
    function dietaAdd(dietas,a){
        table_dieta.row.add([
            fistTdDie(dietas,a[0]),
            '<input type="number" class="form-control" name="quant_die[]" id="quant_die" value="'+a[1]+'">',
            '<div style="text-align: center;"><button class="btn btn-sm btn-danger" id="delDieta">Delete</button></div>'
        ]).draw(false);
    }
    $('#data-table-dieta').on("click", "#delDieta", function(){
        console.log($(this).parent());
        table_dieta.row($(this).parents('tr')).remove().draw(false);
    });

    var table_material = $('#data-table-material').DataTable({
        "pageLength": 6,
        "language": {
            "zeroRecords": "Nenhum registro encontrado",
            "emptyTable": "Nenhum Registro",
            "processing": "Processando...",
            "paginate": {
                "first":      "Primeiro",
                "last":       "Ultimo",
                "next":       "Proximo",
                "previous":   "Anterior"
            },
        },
        dom: 'Btp',
        buttons: {
            dom: {
                button: {
                className: 'btn btn-success'
                }
            },
            buttons:[{
                text: 'Adicionar Material',
                action: function (){
                        materialAdd();
                },
            }
            ]
        }
    });
    function fistTdMat(materiais,id){
        var html = '<select name="materiais[]" id="materiais" class="form-control" ><option>----</option>';
        for(let i=0; i < materiais.length; i++){
            let b = materiais[i].split('!');
            var html = html+'<option value="'+b[0]+'" '+(id === b[0]? 'selected' : '')+'>'+b[1]+'</option>';
        }
        return html+'</select>';
    }
    function materialAdd(materiais,a){
        table_material.row.add([
            fistTdMat(materiais,a[0]),
            '<input type="number" class="form-control" name="quant_mat[]" id="quant_mat" value="'+a[1]+'">',
            '<div style="text-align: center;"><button class="btn btn-sm btn-danger" id="delMaterial">Delete</button></div>'
        ]).draw(false);
    }
    $('#data-table-material').on("click", "#delMaterial", function(){
        console.log($(this).parent());
        table_material.row($(this).parents('tr')).remove().draw(false);
    });

    var table_diaria = $('#data-table-diaria').DataTable({
        "pageLength": 6,
        "language": {
            "zeroRecords": "Nenhum registro encontrado",
            "emptyTable": "Nenhum Registro",
            "processing": "Processando...",
            "paginate": {
                "first":      "Primeiro",
                "last":       "Ultimo",
                "next":       "Proximo",
                "previous":   "Anterior"
            },
        },
        dom: 'Btp',
        buttons: {
            dom: {
                button: {
                className: 'btn btn-success'
                }
            },
            buttons:[{
                text: 'Adicionar Diaria',
                action: function (){
                        diariaAdd();
                },
            }
            ]
        }
    }); 
    function fistTdDia(diarias,id){
        var html = '<select name="diarias[]" id="diarias" class="form-control" ><option>----</option>';
        for(let i=0; i < diarias.length; i++){
            let b = diarias[i].split('!');
            var html = html+'<option value="'+b[0]+'" '+(id === b[0]? 'selected' : '')+'>'+b[1]+'</option>';
        }
        return html+'</select>';
    }
    function diariaAdd(diarias,a){
        table_diaria.row.add([
            fistTdDia(diarias,a),
            '<div style="text-align: center;"><button class="btn btn-sm btn-danger" id="delDiaria">Delete</button></div>'
        ]).draw(false);
    } 
    $('#data-table-diaria').on("click", "#delDiaria", function(){
        console.log($(this).parent());
        table_diaria.row($(this).parents('tr')).remove().draw(false);
    });    

    $('#show').on('click',function() {
        $("#medprof").toggle(this.checked);
    });
    tables();
    function tables(){
        var string_orcequ = "<?php echo $string_orcequ;?>";
        var orcequ = string_orcequ.split('|');
        var string_equipes = "<?php echo $string_equipes;?>";
        var equipes = string_equipes.split('|');
        for(let i=0; i < orcequ.length; i++){
            var a = orcequ[i].split('!');
            equipeAdd(equipes,a);
        }
        
        var string_orcmed = "<?php echo $string_orcmed;?>";
        var orcmed = string_orcmed.split('|');
        var string_medicamentos = "<?php echo $string_medicamentos;?>";
        var medicamentos = string_medicamentos.split('|');
        for(let i=0; i < orcmed.length; i++){
            var a = orcmed[i].split('!');
            medicamentoAdd(medicamentos,a);
        }

        var string_orcequipa = "<?php echo $string_orcequipa;?>";
        var orcequipa = string_orcequipa.split('|');
        var string_equipamentos = "<?php echo $string_equipamentos;?>";
        var equipamentos = string_equipamentos.split('|');
        for(let i=0; i < orcequipa.length; i++){
            var a = orcequipa[i].split('!');
            equipamentoAdd(equipamentos,a);
        }

        var string_orcdie = "<?php echo $string_orcdie;?>";
        var orcdie = string_orcdie.split('|');
        var string_dietas = "<?php echo $string_dietas;?>";
        var dietas = string_dietas.split('|');
        for(let i=0; i < orcdie.length; i++){
            var a = orcdie[i].split('!');
            dietaAdd(dietas,a);
        }

        var string_orcmat = "<?php echo $string_orcmat;?>";
        var orcmat = string_orcmat.split('|');
        var string_materiais = "<?php echo $string_materiais;?>";
        var materiais = string_materiais.split('|');
        for(let i=0; i < orcmat.length; i++){
            var a = orcmat[i].split('!');
            materialAdd(materiais,a);
        }

        var string_orcdia = "<?php echo $string_orcdia;?>";
        var orcdia = string_orcdia.split('|');
        var string_diarias = "<?php echo $string_diarias;?>";
        var diarias = string_diarias.split('|');
        for(let i=0; i < orcdia.length; i++){
            diariaAdd(diarias,orcdia[i]);
        }
    }
});
</script>
@endsection