@extends('layouts.main')

@section('title', 'Criar Orcamento')

@section('content')

<div id="event-create-container" class="col-md-6 offset-md-3">
    <h1>Cadastrar Diaria</h1>
    <form action="{{ route('diarias.store') }}" method="POST" id="add"  autocomplete="off">
        <div class="form-group">
            <label for="title">Descrição:</label>
            <input type="text" class="form-control" id="descricao" name="descricao">
        </div>
        <div class="form-group">
            <label for="title">Preço base:</label>
            <input type="number" step=".01" min="0" class="form-control" id="custo" name="custo">
        </div>
        <div class="form-group">
            <label for="title">Preço final:</label>
            <input type="number" step=".01" min="0" class="form-control" id="venda" name="venda">
        </div>
        <button type="submit" class="btn btn-block btn-success">Cadastrar Diaria</button>
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
                            window.location = "http://127.0.0.1:8000/diarias/dashboard";
                            }
                    }
                );
            });

});
</script>  
@endsection