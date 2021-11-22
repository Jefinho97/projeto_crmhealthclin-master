@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')


<div class="col-md-10 offset-md-1 dashboard-title-container">
<h1>Diarias Cadastradas</h1> <a href="{{ route('diarias.create') }}"> cadastrar diaria</a>
</div>
<div class="col-md-10 offset-md-1 dashboard-events-container">
    @if( count($diarias) > 0)
    <table class="table">   
        <thead>
            <tr>
                <th scope="col">Descrição</th>
                <th scope="col">Custo</th>
                <th scope="col">Venda</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($diarias as $diaria)
                <tr>
                    <td>{{ $diaria->descricao }}</td>
                    <td>{{ $diaria->custo }}</td>
                    <td>{{ $diaria->venda }}</td>
                    <td>
                        <a href="{{ route('diarias.edit', [$diaria->id]) }}" class="btn btn-info edit-btn "><ion-icon name="create-outline"></ion-icon> Editar </a> 
                    </td>
                    <td>    
                        <button class="btn btn-sm btn-danger" data-id="{{ route('diarias.destroy', [$diaria->id]) }}" id="destroy">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>Não há nenhuma diaria cadastrada, <a href="{{ route('diarias.create') }}"> cadastrar diaria</a></p>
    @endif
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
        
    $(document).on('click','#destroy', function(){
        var url = $(this).data('id');
        swal.fire({
                title:'Excluir Diaria?',
                html:'Tem certeza que quer <b>deletar</b> a diaria',
                showCancelButton:true,
                showCloseButton:true,
                cancelButtonText:'Cancelar',
                confirmButtonText:'Confirmar',
                cancelButtonColor:'#d33',
                confirmButtonColor:'#556ee6',
                width:300,
                allowOutsideClick:false
        }).then(function(result){
            if(result.value){
                $.ajax({
                    url, 
                    type: "DELETE",
                    success: function(){
                        document.location.reload(true);
                        toastr.success('Diaria foi deletado com sucesso!');
                    },
                    error: function(){
                        toastr.error('Algo deu errado, ERRO!');
                    }
                });
            }
        });
    });
});
</script>
@endsection