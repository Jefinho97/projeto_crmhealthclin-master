@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')


<div class="col-md-10 offset-md-1 dashboard-title-container">
<h1>Materiais Cadastrados</h1> <a href="{{ route('materiais.create') }}"> cadastrar material</a>
</div>
<div class="col-md-10 offset-md-1 dashboard-events-container">
    @if( $quant > 0)
    <table class="table">   
        <thead>
            <tr>
                <th scope="col">Tipo</th>
                <th scope="col">Nome</th>
                <th scope="col">Unidade de Medida</th>
                <th scope="col">Custo do Produto</th>
                <th scope="col">Preço de Venda</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($materiais as $material)
                <tr>
                    <td>{{ $material->tipo }}</td>
                    <td>{{ $material->nome }}</a></td>
                    <td>{{ $material->uni_medida}}</td>
                    <td>{{ $material->custo }}</td>
                    <td>{{ $material->venda }}</td>
                    <td>
                        <a href="{{ route('materiais.edit', [$material->id]) }}" class="btn btn-info edit-btn "><ion-icon name="create-outline"></ion-icon> Editar </a> 
                    </td>
                    <td>    
                    <button class="btn btn-sm btn-danger" data-id="{{ route('materiais.destroy', [$material->id]) }}" id="destroy">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>Não há nenhum material cadastrado, <a href="{{ route('materiais.create') }}"> cadastrar material</a></p>
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
                html:'Tem certeza que quer <b>deletar</b> a material',
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
                        toastr.success('Material deletado com sucesso!');
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