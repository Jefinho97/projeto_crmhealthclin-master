@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')


<div class="col-md-10 offset-md-1 dashboard-title-container">
<h1>Funções Cadastradas</h1> <a href="{{ route('equipes.create') }}"> cadastrar função</a>
</div>
<div class="col-md-10 offset-md-1 dashboard-events-container">
    @if( count($equipes) > 0)
    <table class="table">   
        <thead>
            <tr>
                <th scope="col">Função</th>
                <th scope="col">Custo</th>
                <th scope="col">Venda</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($equipes as $equipe)
                <tr>
                    <td>{{ $equipe->funcao }}</td>
                    <td>{{ $equipe->custo }}</td>
                    <td>{{ $equipe->venda }}</td>
                    <td>
                        <a href="{{ route('equipes.edit', [$equipe->id]) }}" class="btn btn-info edit-btn "><ion-icon name="create-outline"></ion-icon> Editar </a> 
                    </td>
                    <td>    
                    <button class="btn btn-sm btn-danger" data-id="{{ route('equipes.destroy', [$equipe->id]) }}" id="destroy">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>Não há nenhum Profissional cadastrado</p>
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
                title:'Excluir Profissional?',
                html:'Tem certeza que quer <b>deletar</b> o profissional',
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
                        toastr.success('Profissional foi deletado com sucesso!');
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