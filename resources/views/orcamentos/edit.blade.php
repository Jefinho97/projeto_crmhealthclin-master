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
            <div id="form-prof">
                @foreach($orcamento->equipes as $orcequ)
                <label for="title">Profissionais:</label>
                <select name="equipes[]" id="equipes" class="form-control">
                    <option >----</option> 
                    @foreach($equipes as $equipe) 
                    <option value="{{ $equipe->id }}" {{ $orcequ->id === $equipe->id ? 'selected' : '' }}>{{ $equipe->funcao }}</option> 
                    @endforeach 
                </select>
                <label for="title">Quantidade:</label>
                <input type="number" class="form-control" name="quant_equ[]" id="quant_equ" value="{{ $orcequ->pivot->quant }}">
                @endforeach
                <label for="title">Adicionar Profissionais:</label>
                <button type="button" id="add-prof"> + </button>
            </div>
        </div>

        <div class="form-group" id="form-mat">
            @foreach($orcamento->materials as $orcmat)
            <label for="title">Materiais e Medicamentos:</label>
            <select name="materials[]" id="materials" class="form-control" style="float: left;"> 
                <option value="">----</option>
                @foreach($materiais as $material)
                <option value="{{ $material->id }}" {{ $orcmat->id === $material->id? 'selected': ''}}>{{ $material->nome }}</option>
                @endforeach
            </select>
            <input type="number" class="form-control" name="quant_mat[]" id="quant_mat" placeholder="Quantidade" value="{{ $orcmat->pivot->quant }}">
            @endforeach
            <label for="title">Adicionar Materiais e Medicamentos:</label>
            <button type="button" id="add-mat" style="float: right;" > + </button>
        </div>       

        <div class="form-group" id="form-dia">
            @foreach($orcamento->diarias as $orcdia)
            <label for="title">Diarias:</label>
            <select name="diarias[]" id="diarias" class="form-control">
                <option value="">----</option> 
                @foreach($diarias as $diaria) 
                <option value="{{ $diaria->id }}" {{orcdia->id === $diaria->id? 'selected' : ''}}>{{ $diaria->descricao }}</option> 
                @endforeach 
            </select>
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
        <input type="submit" class="btn btn-primary" value="Editar Orcamento">
    </form>
</div>

<script>
toastr.options.preventDuplicates = true;

$.ajaxSetup({
    headers:{
        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
    }
});

$(function(){
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