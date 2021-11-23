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
    

    $('#show').on('click',function() {
        $("#medprof").toggle(this.checked);
    });
});
</script>
@endsection