@extends('layouts.main')

@section('title', 'Criar Orcamento')

@section('content')

<div id="event-create-container" class="col-md-6 offset-md-3">
    <h1>Crie o seu Orçamento</h1>
    <form action="{{ route('orcamentos.store') }}" method="POST" id="add"  autocomplete="off">
        <div class="form-group">
            <label for="title">Procedimento:</label>
            <input type="text" class="form-control" id="procedimento" name="procedimento" placeholder="Qual o procedimento?">
        </div>
        <div class="form-group" >
            Orçamento com equipe médica:<input type="checkbox" name="tipo" id="show">
        </div>
        <div class="form-group" id="medprof" style="display: none;">
                <label for="title">Medico:</label>
                <input type="text" class="form-control" id="medico" name="medico" placeholder="Nome do médico:">
                <input type="number" step=".01" min="0" class="form-control" id="preco_medico" name="preco_medico" placeholder="Preço do médico">
            <div id="form-prof">
                <label for="title">Adicionar Profissionais:</label>
                <button type="button" id="add-prof"> + </button>
            </div>
        </div>

        <div class="form-group" id="form-mat">
            <label for="title">Adicionar Materiais e Medicamentos:</label>
            <button type="button" id="add-mat" style="float: right;" > + </button>
        </div>       

        <div class="form-group" id="form-dia">
            <label for="title">Adicionar Diarias:</label>
            <button type="button" id="add-dia"> + </button>
        </div>

        <label for="title">Informações do Paciente:</label>
        <div class="form-group">
            <input type="text" class="form-control" id="paciente" name="paciente" placeholder="Nome do Paciente">
        </div>
        <div class="form-group">
            <input type="email" class="form-control" id="email_pac" name="email_pac" placeholder="E-mail do Paciente">
        </div>
        <div class="form-group">    
            <input type="tel" class="form-control" id="telefone_1" name="telefone_1" placeholder="Telefone do Paciente">
        </div>
        <div class="form-group">    
            <input type="tel" class="form-control" id="telefone_2" name="telefone_2" placeholder="Telefone Opcional do Paciente">
        </div>
        
        <div class="form-group">
            <label for="date">Data do Procedimento:</label>
            <input type="date" class="form-control" id="data" name="data">
        </div>
        <div class="form-group">
            <label for="title">Termos e condições:</label>
            <textarea name="termos_condicoes" id="termos_condicoes" class="form-control" placeholder="Termos e Condições"></textarea>    
        </div>
        <div class="form-group">
            <label for="title">Convenios:</label>
            <textarea name="convenios" id="convenios" class="form-control" placeholder="Convenios"></textarea>    
        </div>
        <div class="form-group">
            <label for="title">Condições de pagamento:</label>
            <textarea name="condicoes_pag" id="condicoes_pag" class="form-control" placeholder="O que vai acontecer no evento?"></textarea>    
        </div>
        <button type="submit" class="btn btn-block btn-success">Criar Orcamento</button>
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

    //ADD NEW COUNTRY
    $('#add').on('submit', function(e){
                e.preventDefault();
                var form = this;
                $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
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