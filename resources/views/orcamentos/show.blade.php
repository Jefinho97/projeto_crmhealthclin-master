@extends('layouts.main')

@section('title', 'Orcamento')

@section('content')

<div id="event-create-container" class="col-md-6 offset-md-3">
    <h1>Orçamento</h1>
    <div class="container-fluid">
        <div class="row">
            <div class="form-group col-sm">
                <label for="title">Status</label>
                <select name="status" id="status" class="form-control">   <option value="----">----</option><option value="novo" {{ ($orcamento->status === "novo" ? "selected" : "") }}>Novo</option>  <option value="aguardando" {{($orcamento->status === "aguardando" ? "selected" : "")}}>Aguardando</option> <option value="em andamento" {{($orcamento->status === "em andamento" ? "selected" : "")}}>Em andamento</option> <option value="cancelado" {{($orcamento->status === "cancelado" ? "selected" : "")}}>Cancelado</option> <option value="ganho" {{($orcamento->status === "ganho" ? "selected" : "")}}>Ganho</option> <option value="perdido" {{($orcamento->status === "perdido" ? "selected" : "")}}>Perdido</option> <option value="desistencia" {{($orcamento->status === "desistencia" ? "selected" : "")}}>Desistencia</option>    </select>
            </div>
            <div class="form-group col-sm">
                <label for="title">Razão Status</label>
                <select name="razao_status" id="razao_status" data-id="./razao_status/{{$orcamento->id}}" class="form-control"> <option value="----">----</option>  <option value="na fila" {{($orcamento->razao_status === "na fila" ? "selected" : "")}}>Na fila para atendimento</option> <option value="aguardando cliente" {{($orcamento->razao_status === "aguardando cliente" ? "selected" : "")}}>Aguardando cliente</option>  <option value="aguardando envio" {{($orcamento->razao_status === "aguardando envio" ? "selected" : "")}}>Aguardando envio do cirurgião</option>  </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm">
                <label for="title">Procedimento:</label>
                <input type="text" class="form-control show" id="procedimento" name="procedimento" value="{{ $orcamento->procedimento }}" readonly>
            </div>
            <div class="form-group col-sm">
                <label for="title">Data do Procedimento:</label>
                <input type="text" class="form-control" id="data" name="data" value="{{ date('d/m/y', strtotime($orcamento->data)) }}" readonly>
            </div>
            <div class="form-group col-sm">
                <label for="title">Solicitante:</label>
                <input type="text" class="form-control" id="solicitante" name="solicitante" value="{{ $orcamento->solicitante }}" readonly>
            </div>
        </div>
        <label for="title">Informações do Paciente {{ $orcamento->paciente}}:</label>
        <div class="row">
            <div class="form-group col-sm">
                <input type="text" class="form-control" id="paciente" name="paciente" value="{{ $orcamento->paciente }}" readonly>
            </div>
            <div class="form-group col-sm">
                <input type="email" class="form-control" id="email_pac" name="email_pac" value="{{ $orcamento->email_pac}}" readonly>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm">    
                <input type="tel" class="form-control" id="telefone_1" name="telefone_1" value="{{ $orcamento->telefone_1 }}" readonly>
            </div>
            <div class="form-group col-sm">    
                <input type="tel" class="form-control" id="telefone_2" name="telefone_2" value="{{ $orcamento->telefone_2 }}"readonly>
            </div>
        </div>      
        @if($orcamento->tipo == true)
        <div class="row">
            <div class="form-group col-sm">
            <label for="title">Medico:</label>
            <input type="text" class="form-control" id="medico" name="medico" value="{{ $orcamento->medico }}" readonly>
            </div>
            <div class="form-group col-sm">
            <label for= title>Valor</label>
            <input type="number" class="form-control" id="preco_medico" name="preco_medico" value="{{ $orcamento->preco_medico }}" readonly>
            </div>
        </div>

        @if(count($orcamento->equipes) > 0)
        <div class="form-group">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Honorarios da Equipe</th>
                        <th scope="col">Quant</th>
                        <th scope="col">Custo</th>
                        <th scope="col">Custo Total</th>
                        <th scope="col">Preço Venda</th>
                        <th scope="col">Preço Venda Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orcamento->equipes as $equipe)
                    <tr>
                        <td scope="row">{{ $equipe->funcao }}</td>
                        <td>{{ $equipe->pivot->quant }}</td>
                        <td>{{ $equipe->custo }}</td>
                        <td>{{ $equipe->pivot->soma_custo }}</td>
                        <td>{{ $equipe->venda }}</td>
                        <td>{{ $equipe->pivot->soma_venda }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td scope="row">Total</td>
                        <td></td>
                        <td></td>
                        <td>{{ $orcamento->custo_equipe }}</td>
                        <td></td>
                        <td>{{ $orcamento->venda_equipe }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endif
        @endif

        @if(count($orcamento->materiais) > 0)
        <div class="form-group">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Materiais</th>
                        <th scope="col">Quant</th>
                        <th scope="col">Custo</th>
                        <th scope="col">Custo Total</th>
                        <th scope="col">Preço Venda</th>
                        <th scope="col">Preço Venda Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orcamento->materiais as $material)
                    <tr>
                        <td scope="row">{{ $material->nome }}</td>
                        <td>{{ $material->pivot->quant }}</td>
                        <td>{{ $material->custo }}</td>
                        <td>{{ $material->pivot->soma_custo }}</td>
                        <td>{{ $material->venda }}</td>
                        <td>{{ $material->pivot->soma_venda }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td scope="row">Total</td>
                        <td></td>
                        <td></td>
                        <td>{{ $orcamento->custo_material }}</td>
                        <td></td>
                        <td>{{ $orcamento->venda_material }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endif

        @if(count($orcamento->medicamentos) > 0)
        <div class="form-group">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Medicamento</th>
                        <th scope="col">Quant</th>
                        <th scope="col">Custo</th>
                        <th scope="col">Custo Total</th>
                        <th scope="col">Preço Venda</th>
                        <th scope="col">Preço Venda Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orcamento->medicamentos as $medicamento)
                    <tr>
                        <td scope="row">{{ $medicamento->nome }}</td>
                        <td>{{ $medicamento->pivot->quant }}</td>
                        <td>{{ $medicamento->custo }}</td>
                        <td>{{ $medicamento->pivot->soma_custo }}</td>
                        <td>{{ $medicamento->venda }}</td>
                        <td>{{ $medicamento->pivot->soma_venda }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td scope="row">Total</td>
                        <td></td>
                        <td></td>
                        <td>{{ $orcamento->custo_medicamento }}</td>
                        <td></td>
                        <td>{{ $orcamento->venda_medicamento }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endif

        @if(count($orcamento->dietas) > 0)
        <div class="form-group">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Dietas</th>
                        <th scope="col">Quant</th>
                        <th scope="col">Custo</th>
                        <th scope="col">Custo Total</th>
                        <th scope="col">Preço Venda</th>
                        <th scope="col">Preço Venda Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orcamento->dietas as $dieta)
                    <tr>
                        <td scope="row">{{ $dieta->nome }}</td>
                        <td>{{ $dieta->pivot->quant }}</td>
                        <td>{{ $dieta->custo }}</td>
                        <td>{{ $dieta->pivot->soma_custo }}</td>
                        <td>{{ $dieta->venda }}</td>
                        <td>{{ $dieta->pivot->soma_venda }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td scope="row">Total</td>
                        <td></td>
                        <td></td>
                        <td>{{ $orcamento->custo_dieta }}</td>
                        <td></td>
                        <td>{{ $orcamento->venda_dieta }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endif

        @if(count($orcamento->equipamentos) > 0)
        <div class="form-group">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Equipamentos</th>
                        <th scope="col">Quant</th>
                        <th scope="col">Custo</th>
                        <th scope="col">Custo Total</th>
                        <th scope="col">Preço Venda</th>
                        <th scope="col">Preço Venda Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orcamento->equipamentos as $equipamento)
                    <tr>
                        <td scope="row">{{ $equipamento->nome }}</td>
                        <td>{{ $equipamento->pivot->quant }}</td>
                        <td>{{ $equipamento->custo }}</td>
                        <td>{{ $equipamento->pivot->soma_custo }}</td>
                        <td>{{ $equipamento->venda }}</td>
                        <td>{{ $equipamento->pivot->soma_venda }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td scope="row">Total</td>
                        <td></td>
                        <td></td>
                        <td>{{ $orcamento->custo_equipamento }}</td>
                        <td></td>
                        <td>{{ $orcamento->venda_equipamento }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endif

        @if(count($orcamento->diarias) > 0)
        <div class="form-group">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Diarias</th>
                        <th scope="col">Valor Base</th>
                        <th scope="col">Adicional</th>
                        <th scope="col">Valor Unitario Venda</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orcamento->diarias as $diaria)
                    <tr>
                        <td scope="row">{{ $diaria->descricao }}</td>
                        <td>{{ $diaria->custo }}</td>
                        <td>{{ $diaria->venda - $diaria->custo }}</td>
                        <td>{{ $diaria->venda }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td scope="row">Total</td>
                        <td>{{ $orcamento->custo_diaria }}</td>
                        <td></td>
                        <td>{{ $orcamento->venda_diaria }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        @endif
        <div class="row">
            <div class="form-group col-sm">
                <label for="title">Termos e condições:</label>
                <textarea name="termos_condicoes" id="termos_condicoes" class="form-control" readonly>{{ $orcamento->termos_condicoes }}</textarea>    
            </div>
            <div class="form-group col-sm">
                <label for="title">Convenios:</label>
                <textarea name="convenios" id="convenios" class="form-control" readonly>{{ $orcamento->convenios }}</textarea>    
            </div>
            <div class="form-group col-sm">
                <label for="title">Condições de pagamento:</label>
                <textarea name="condicoes_pag" id="condicoes_pag" class="form-control" readonly>{{ $orcamento->condicoes_pag }}</textarea>    
            </div>
        </div>
        <div class="form-group">
            <label for="title">Total</label>
            <table class="table table-striped table-bordered">
                <tbody>
                    <tr>
                        <td scope="row">Valor</td>
                        <td>{{ $orcamento->valor_final }}</td>
                    </tr>
                    <tr>
                        <td scope="row">Desconto</td>
                        <td><input type="number" class="form-control" id="desconto" name="desconto" value="{{ $orcamento->desconto }}"></td>
                    </tr>
                    <tr>
                        <td scope="row">Total</td>
                        <td>{{ $orcamento->valor_final - $orcamento->desconto }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
toastr.options.preventDuplicates = true;

$(document).ready( function () {
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#desconto').on('change',function() {
        $.ajax({
            data: { desconto : $(this).val()},
            url: "{{route('orcamentos.up_show',[$orcamento->id])}}",
            type:"PUT",
            success: function(){
                location.reload()
                toastr.success('Desconto aplicado com sucesso!');
                $('#modal').modal('hide');
                
            },
            error: function(){
                toastr.error('Algo deu errado, ERRO!');
                $('#modal').modal('hide');
            }
        });
    });
    $('#status').on('change', function(){
        $.ajax({
            url: "{{route('orcamentos.status',[$orcamento->id])}}", 
            data: {status : $(this).val()},
            type: "PUT",
            success: function(){
                toastr.success('Status alterado com sucesso!');
            },
            error: function(){
                toastr.error('Algo deu errado, ERRO!');
            }
        });
    });
    $('#razao_status').on('change',function(){
        $.ajax({
            url: "{{route('orcamentos.razao_status',[$orcamento->id])}}", 
            data: {razao_status: $(this).val()},
            type: "PUT",
            success: function(){
                toastr.success('Razão alterada com sucesso!');
            },
            error: function(){
                toastr.error('Algo deu errado, ERRO!');
            }
        });
    });
});
</script>
@endsection