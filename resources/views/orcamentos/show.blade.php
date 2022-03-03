@extends('layouts.main')

@section('title', 'Orcamento')

@section('content')

<div id="event-create-container" class="col-md-6 offset-md-3">
    <h1>Orçamento</h1>

        <div class="form-group">
            <label for="title">Procedimento:</label>
            <input type="text" class="form-control show" id="procedimento" name="procedimento" value="{{ $orcamento->procedimento }}" readonly>
        </div>
        <div class="form-group">
            <label for="title">Data do Procedimento:</label>
            <input type="text" class="form-control" id="data" name="data" value="{{ date('d/m/y', strtotime($orcamento->data)) }}" readonly>
        </div>
        <div class="form-group">
            <label for="title">Solicitante:</label>
            <input type="text" class="form-control" id="solicitante" name="solicitante" value="{{ $orcamento->solicitante }}" readonly>
        </div>
        <label for="title">Informações do Paciente {{ $orcamento->paciente}}:</label>
        <div class="form-group">
            <input type="text" class="form-control" id="paciente" name="paciente" value="{{ $orcamento->paciente }}" readonly>
        </div>
        <div class="form-group">
            <input type="email" class="form-control" id="email_pac" name="email_pac" value="{{ $orcamento->email_pac}}" readonly>
        </div>
        <div class="form-group">    
            <input type="tel" class="form-control" id="telefone_1" name="telefone_1" value="{{ $orcamento->telefone_1 }}" readonly>
        </div>
        <div class="form-group">    
            <input type="tel" class="form-control" id="telefone_2" name="telefone_2" value="{{ $orcamento->telefone_2 }}"readonly>
        </div>

        @if($orcamento->tipo == true)
        <div class="form-group">
            <label for="title">Medico:</label>
            <input type="text" class="form-control" id="medico" name="medico" value="{{ $orcamento->medico }}" readonly>
            <input type="number" class="form-control" id="preco_medico" name="preco_medico" value="{{ $orcamento->preco_medico }}" readonly>
        </div>
        @if(count($orcamento->equipes) > 0)
        <div class="form-group">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Honorarios</th>
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
            <label for="title">Diarias</label>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Descrição</th>
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
        
        <div class="form-group">
            <label for="title">Termos e condições:</label>
            <textarea name="termos_condicoes" id="termos_condicoes" class="form-control" readonly>{{ $orcamento->termos_condicoes }}</textarea>    
        </div>
        <div class="form-group">
            <label for="title">Convenios:</label>
            <textarea name="convenios" id="convenios" class="form-control" readonly>{{ $orcamento->convenios }}</textarea>    
        </div>
        <div class="form-group">
            <label for="title">Condições de pagamento:</label>
            <textarea name="condicoes_pag" id="condicoes_pag" class="form-control" readonly>{{ $orcamento->condicoes_pag }}</textarea>    
        </div>
        
        <div class="form-group">
            <label for="title">Total</label>
            <table class="table table-striped table-bordered">
                <tbody>
                    <tr>
                        <td scope="row">Valor Inicial</td>
                        <td>{{ $orcamento->valor_inicial }}</td>
                    </tr>
                        <input type="hidden" name="valor_inicial" value="{{ $orcamento->valor_inicial }}">
                    <tr>
                        <td scope="row">Total</td>
                        <td><input type="number" class="form-control" id="desconto" name="desconto" value="{{ $orcamento->desconto }}"></td>
                    </tr>
                    <tr>
                        <td scope="row">Total</td>
                        <td>{{ $orcamento->valor_final }}</td>
                    </tr>
                </tbody>
            </table>
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
                table.draw();
                toastr.success('Desconto aplicado com sucesso!');
                $('#modal').modal('hide');
            },
            error: function(){
                toastr.error('Algo deu errado, ERRO!');
                $('#modal').modal('hide');
            }
        });
    });
});
</script>
@endsection