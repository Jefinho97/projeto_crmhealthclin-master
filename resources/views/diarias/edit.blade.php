@extends('layouts.main')

@section('title', 'Editar Diaria')

@section('content')

<div id="event-create-container" class="col-md-6 offset-md-3">
    <h1>Editar Diaria</h1>
    <form action="{{ route('diarias.update', [$diaria->id]) }}" method="POST" id="update" autocomplete="off">
        <div class="form-group">
            <label for="title">Descrição:</label>
            <input type="text" class="form-control" id="descricao" name="descricao" value="{{ $diaria->descricao }}">
        </div>
        <div class="form-group">
            <label for="title">Custo da Diaria:</label>
            <input type="number" step=".01" min="0" class="form-control" id="custo" name="custo" value="{{ $diaria->custo }}">
        </div>
        <div class="form-group">
            <label for="title">Preço da venda:</label>
            <input type="number" step=".01" min="0" class="form-control" id="venda" name="venda" value="{{ $diaria->venda }}">
        </div>
        <input type="submit" class="btn btn-primary" value="Editar Função">
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
                    window.location = "http://127.0.0.1:8000/diarias/dashboard";
                    }
            }
        );
    });
});
</script>
@endsection