@extends('layouts.main')

@section('title', 'Editar Orcamento')

@section('content')

<div id="event-create-container" class="col-md-6 offset-md-3">
    <h1>Editar Orçamento</h1>
    <form action="{{ route('orcamentos.update', [$orcamento->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Procedimento:</label>
            <input type="text" class="form-control" id="procedimento" name="procedimento" value="{{ $orcamento->procedimento }}">
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
                    </tr>
                </thead>
                <tbody>
                    @foreach($orcamento->equipes as $orcequ)
                    <tr>
                        <td>
                            <select name="equipes[]" id="equipes" class="form-control">
                                <option >----</option> 
                                @foreach($user->equipes as $equipe) 
                                <option value="{{ $equipe->id }}" {{ $orcequ->id === $equipe->id ? 'selected' : '' }}>{{ $equipe->funcao }}</option> 
                                @endforeach 
                            </select>
                        </td>
                        <td>
                            <input type="number" class="form-control" name="quant_equ[]" id="quant_equ" value="{{ $orcequ->pivot->quant }}">    
                        </td>
                    </tr>
                    @endforeach
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
                    @foreach($orcamento->medicamentos as $orcmed)
                    <tr>
                        <td>
                        <select name="madicamentos[]" id="medicamentos" class="form-control"> 
                            <option value="">----</option>
                            @foreach($user->medicamentos as $medicamento)
                            <option value="{{ $medicamento->id }}" {{ $orcmed->id === $medicamento->id? 'selected': ''}}>{{ $medicamento->nome }}</option>
                            @endforeach
                        </select>
                        </td>
                        <td>
                            <input type="number" class="form-control" name="quant_med[]" id="quant_med" placeholder="Quantidade" value="{{ $orcmed->pivot->quant }}">
                        </td>
                    </tr>
                    @endforeach 
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
                    @foreach($orcamento->equipamentos as $orcequipa)
                    <tr>
                        <td>
                        <select name="equipamentos[]" id="equipamentos" class="form-control" style="float: left;"> 
                            <option value="">----</option>
                            @foreach($user->equipamentos as $equipamento)
                            <option value="{{ $equipamento->id }}" {{ $orcequipa->id === $equipamento->id? 'selected': ''}}>{{ $equipamento->nome }}</option>
                            @endforeach
                        </select>
                        </td>
                        <td>
                            <input type="number" class="form-control" name="quant_equipa[]" id="quant_equipa" placeholder="Quantidade" value="{{ $orcequipa->pivot->quant }}">
                        </td>
                    </tr>
                    @endforeach 
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
                    @foreach($orcamento->dietas as $orcdie)
                    <tr>
                        <td>
                        <select name="dietas[]" id="dietas" class="form-control"> 
                            <option value="">----</option>
                            @foreach($user->dietas as $dieta)
                            <option value="{{ $dieta->id }}" {{ $orcdie->id === $dieta->id? 'selected': ''}}>{{ $dieta->nome }}</option>
                            @endforeach
                        </select>
                        </td>
                        <td>
                            <input type="number" class="form-control" name="quant_die[]" id="quant_die" placeholder="Quantidade" value="{{ $orcdie->pivot->quant }}">
                        </td>
                    </tr>
                    @endforeach 
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
                    @foreach($orcamento->materiais as $orcmat)
                    <tr>
                        <td>
                        <select name="materiais[]" id="materiais" class="form-control"> 
                            <option value="">----</option>
                            @foreach($user->materiais as $material)
                            <option value="{{ $material->id }}" {{ $orcmat->id === $material->id? 'selected': ''}}>{{ $material->nome }}</option>
                            @endforeach
                        </select>
                        </td>
                        <td>
                            <input type="number" class="form-control" name="quant_mat[]" id="quant_mat" placeholder="Quantidade" value="{{ $orcmat->pivot->quant }}">
                        </td>
                    </tr>
                    @endforeach 
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
                    @foreach($orcamento->diarias as $orcdia)
                    <tr>
                        <td>
                        <select name="diarias[]" id="diarias" class="form-control">
                            <option value="">----</option> 
                            @foreach($user->diarias as $diaria) 
                            <option value="{{ $diaria->id }}" {{$orcdia->id === $diaria->id? 'selected' : ''}}>{{ $diaria->descricao }}</option> 
                            @endforeach 
                        </select>
                        </td>
                    </tr>
                    @endforeach
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
            <label for="date">Data do Procedimento:</label>
            <input type="date" class="form-control" id="data" name="data" value="{{ $orcamento->data->format('Y-m-d') }}">
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
        dom: 'Bfrtip',
        buttons: {
            dom: {
                button: {
                className: 'btn btn-success'
                }
            },
            buttons:[{
                text: 'Adicionar Profissional',
                action: function (){
                        table_equipe.row.add([
                            '<select name="equipes[]" id="equipes" class="form-control"><option selected>----</option> @foreach($equipes as $equipe) <option value="{{ $equipe->id }}">{{ $equipe->funcao }}</option> @endforeach </select>',
                            '<input type="number" class="form-control" name="quant_equ[]" id="quant_equ">'
                        ]).draw(false);
                },
            }
            ]
        }
    });

    var table_medicamento = $('#data-table-medicamento').DataTable({
        dom: 'Bfrtip',
        buttons: {
            dom: {
                button: {
                className: 'btn btn-success'
                }
            },
            buttons:[{
                text: 'Adicionar Medicamento',
                action: function (){
                        table_equipe.row.add([
                            '<select name="medicamentos[]" id="medicamentos" class="form-control"><option selected>----</option> @foreach($medicamentos as $medicamento) <option value="{{ $medicamento->id }}">{{ $medicamento->nome }}</option> @endforeach </select>',
                            '<input type="number" class="form-control" name="quant_med[]" id="quant_med">'
                        ]).draw(false);
                },
            }
            ]
        }
    });

    var table_equipamento = $('#data-table-equipamento').DataTable({
        dom: 'Bfrtip',
        buttons: {
            dom: {
                button: {
                className: 'btn btn-success'
                }
            },
            buttons:[{
                text: 'Adicionar Equipamento',
                action: function (){
                        table_equipamento.row.add([
                            '<select name="equipamentos[]" id="equipamentos" class="form-control"><option selected>----</option> @foreach($equipamentos as $equipamento) <option value="{{ $equipamento->id }}">{{ $equipamento->nome }}</option> @endforeach </select>',
                            '<input type="number" class="form-control" name="quant_equipa[]" id="quant_equipa">'
                        ]).draw(false);
                },
            }
            ]
        }
    });

    var table_dieta = $('#data-table-dieta').DataTable({
        dom: 'Bfrtip',
        buttons: {
            dom: {
                button: {
                className: 'btn btn-success'
                }
            },
            buttons:[{
                text: 'Adicionar Dieta',
                action: function (){
                        table_dieta.row.add([
                            '<select name="dietas[]" id="dietas" class="form-control"><option selected>----</option> @foreach($dietas as $dieta) <option value="{{ $dieta->id }}">{{ $dieta->nome }}</option> @endforeach </select>',
                            '<input type="number" class="form-control" name="quant_die[]" id="quant_die">'
                        ]).draw(false);
                },
            }
            ]
        }
    });

    var table_material = $('#data-table-material').DataTable({
        dom: 'Bfrtip',
        buttons: {
            dom: {
                button: {
                className: 'btn btn-success'
                }
            },
            buttons:[{
                text: 'Adicionar Material',
                action: function (){
                        table_material.row.add([
                            '<select name="materials[]" id="materials" class="form-control"><option value="" selected>----</option>@foreach($materiais as $material)<option value="{{ $material->id }}">{{ $material->nome }}</option> @endforeach </select>',
                            '<input type="number" class="form-control" name="quant_mat[]" id="quant_mat" placeholder="Quantidade">>'
                        ]).draw(false);
                },
            }
            ]
        }
    });

    var table_diaria = $('#data-table-diaria').DataTable({
        dom: 'Bfrtip',
        buttons: {
            dom: {
                button: {
                className: 'btn btn-success'
                }
            },
            buttons:[{
                text: 'Adicionar Diaria',
                action: function (){
                        table_diaria.row.add([
                            '<select name="diarias[]" id="diarias" class="form-control"><option value="" selected>----</option> @foreach($diarias as $diaria) <option value="{{ $diaria->id }}">{{ $diaria->descricao }}</option> @endforeach </select>'
                        ]).draw(false);
                },
            }
            ]
        }
    });  
        
    $('#show').on('click',function() {
        $("#medprof").toggle(this.checked);
    });
});
</script>
@endsection