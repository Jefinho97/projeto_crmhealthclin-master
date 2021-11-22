@extends('layouts.main')

@section('title', 'Editar Orcamento')

@section('content')

<div id="event-create-container" class="col-md-6 offset-md-3">
    <h1>Editar Orçamento</h1>
    <form action="{{ route('orcamentos.update', [$orcamento->id])  }}" method="POST" id="update" autocomplete="off">
        <div class="form-group">
            <label for="title">Procedimento:</label>
            <input type="text" class="form-control" id="procedimento" name="procedimento" value="{{ $orcamento->procedimento }}">
        </div>
        <div class="form-group" >
            Orçamento com equipe médica:<input type="checkbox" name="tipo" value="1" id="show" {{ $orcamento->tipo == true ? "checked" : "" }}>
        </div>
        
        <div class="form-group" id="medprof" style="display:{{ $orcamento->tipo == true ? 'box' : 'none' }}">
            <label for="title">Medico:</label>
            <input type="text" class="form-control" id="medico" name="medico" placeholder="Nome do médico:" value="{{ $orcamento->medico }}">
            <input type="number" step=".01" min="0" class="form-control" id="preco_medico" name="preco_medico" placeholder="Preço do médico" value="{{ $orcamento->preco_medico }}">
            
            <div class="form-group" id="form-prof">
                @foreach($orcamento->equipes as $orcequ)
                <div class="clone-form-prof">
                    <select name="equipes[]" id="equipes" class="form-control">
                        <option value="">----</option>
                        @foreach($equipes as $equipe)
                        <option value="{{ $equipe->id }}" {{ $equipe->id == $orcequ->pivot->equipe_id ? "selected" : "" }}>{{ $equipe->funcao }}</option>
                        @endforeach
                    </select>
                    <label for="title">Quantidade:</label>
                    <input type="number" class="form-control" name="quant_equ[]" id="quant_equ" value="{{ $orcequ->pivot->quant}}">
                </div>
                @endforeach
                <label for="title">Adicionar Profissionais:</label>
                    <button type="button" id="add-prof"> + </button>
            </div>
        </div>

        <div class="form-group" id="form-mat">
            @foreach($orcamento->materials as $orcmat)
            <div class="clone-form-mat">
                <select name="materials[]" id="materials" class="form-control">
                    <option value="">----</option>
                    @foreach($materiais as $material)
                    <option value="{{ $material->id }}" {{ $material->id == $orcmat->pivot->material_id ? "selected" : "" }}>{{ $material->nome }}</option>
                    @endforeach
                </select>
                <label for="title">Quantidade:</label>
                <input type="number" class="form-control" name="quant_mat[]" id="quant_mat" value="{{ $orcmat->pivot->quant}}">
            </div>
            @endforeach
            <label for="title">Adicionar Materiais e Medicamentos:</label>
            <button type="button" id="add-mat" style="float: right;" > + </button>
        </div>       

        <div class="form-group" id="form-dia">
            @foreach($orcamento->diarias as $orcdia)
            <div class="clone-form-dia">
                <select name="diarias[]" id="diarias" class="form-control">
                    <option value="">----</option>
                    @foreach($diarias as $diaria)
                    <option value="{{ $diaria->id }}" {{ $diaria->id == $orcdia->pivot->diaria_id ? "selected" : "" }}>{{ $diaria->descricao }}</option>
                    @endforeach
                </select>
            </div>
            @endforeach
            <label for="title">Adicionar Diarias:</label>
            <button type="button" id="add-dia"> + </button>
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
        <input type="hidden" id="valor_final" name="valor_final" value="{{ $orcamento->valor_final }}">
        <input type="submit" class="btn btn-primary" value="Editar Orcamento">
    </form>
</div>

@extends('layouts.scripts')
<script>
toastr.options.preventDuplicates = true;

$.ajaxSetup({
    headers:{
        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
    }
});

$(function(){
    $('#update').on('submit', function(e){
        e.preventDefault();
        var form = this;
        $.ajax({
            url:$(form).attr('action'),
            type:'put',
            data:new FormData(form),
            processData:false,
            dataType:'json',
            contentType:false,
            success:function(data){
                    toastr.success(data.msg);
                    window.location = "http://127.0.0.1:8000/orcamentos/dashboard";
                    }
            }
        );
    });
    // ADD materiais
    $("#add-mat").click(function() {
            $("#form-mat").before('<label for="title">Materiais e Medicamentos:</label>'
                +                       '<select name="materials[]" id="materials" class="form-control" style="float: left;">' 
                +                           '<option value="" selected>----</option>' 
                +                           '@foreach($materiais as $material)'
                +                           '<option value="{{ $material->id }}">{{ $material->nome }}</option>'
                +                           '@endforeach' 
                +                     '</select>'
                +                     '<input type="number" class="form-control" name="quant_mat[]" id="quant_mat" placeholder="Quantidade">');
    });
    // ADD diarias
    $("#add-dia").click(function() {
        $("#form-dia").before('<label for="title">Diarias:</label><select name="diarias[]" id="diarias" class="form-control"><option value="" selected>----</option> @foreach($diarias as $diaria) <option value="{{ $diaria->id }}">{{ $diaria->descricao }}</option> @endforeach </select>');
    });

    // ADD profissionais 
    $("#add-prof").click(function() {
        $("#form-prof").before('<label for="title">Profissionais:</label><select name="equipes[]" id="equipes" class="form-control"><option selected>----</option> @foreach($equipes as $equipe) <option value="{{ $equipe->id }}">{{ $equipe->funcao }}</option> @endforeach </select><label for="title">Quantidade:</label><input type="number" class="form-control" name="quant_equ[]" id="quant_equ">');
    });

    $('#show').on('click',function() {
        $("#medprof").toggle(this.checked);
    });
});
</script>
@endsection