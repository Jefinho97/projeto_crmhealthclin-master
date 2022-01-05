@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')


<div class="col-md-10 offset-md-1 dashboard-title-container">
<h1>Materiais Cadastrados</h1> <button type="button" class="btn btn-success" id="add" style="float:right"> cadastrar material</button>
</div>
<div class="col-md-10 offset-md-1 dashboard-events-container">
    <table class="table table-hover data-table">   
        <thead>
            <tr>
                <th scope="col">Tipo</th>
                <th scope="col">Nome</th>
                <th scope="col">Unidade de Medida</th>
                <th scope="col">Custo do Produto</th>
                <th scope="col">Preço de Venda</th>
                <th scope="col" style="text-align: center;">Ações</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<div class="modal fade" id="modalMaterial" tabindex="-1" role="dialog" aria-labelledby="addMaterialLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form  id="materialForm" name="materialForm">
                <input type="hidden" id="material_id" name="material_id">            
                <div class="modal-body">
                    <div class="form-group">
                    <label for="title">Tipo:</label>
                        <select name="tipo" id="tipo" class="form-control"> 
                            <option value="">----</option>
                            <option value="material">Material</option>
                            <option value="medicamento">Medicamento</option>
                            <option value="dieta">Dieta</option>
                            <option value="equipamento">Equipamento</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="title">Nome:</label>
                        <input type="text" class="form-control" id="nome" name="nome">
                    </div>
                    <div class="form-group">
                        <label for="title">Unidade de Medida:</label>
                        <input type="text" class="form-control" id="uni_medida" name="uni_medida">
                    </div>
                    <div class="form-group">
                        <label for="title">Custo:</label>
                        <input type="number" step=".01" min="0" class="form-control" id="custo" name="custo">
                    </div>
                    <div class="form-group">
                        <label for="title">Preço de venda:</label>
                        <input type="number" step=".01" min="0" class="form-control" id="venda" name="venda">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="save">Salvar Material</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>

$(function(){
    toastr.options.preventDuplicates = true;
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });
    var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('materiais.dashboard') }}",
            columns: [
                {data: 'tipo', name: 'tipo'},
                {data: 'nome', name: 'nome'},
                {data: 'uni_medida', name: 'uni_medida'},
                {data: 'custo', name: 'custo'},
                {data: 'venda', name: 'venda'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    $('#add').click( function(){
        $('#material_id').val();
        $('#titulo').html("Cadastrar Novo Material");
        $('#materialForm').trigger('reset');
        $('#modalMaterial').modal('show')
    });   
    $(document).on('click', '#edit', function(){
        var url = $(this).data('id');
        
        $.get(url, function(data){
            $('#modalMaterial').modal('show');
            $('#titulo').html("Atualizar Material");
            $('#material_id').val(data.id);
            $('#tipo').val(data.tipo);
            $('#nome').val(data.nome);
            $('#uni_medida').val(data.uni_medida);
            $('#custo').val(data.custo);
            $('#venda').val(data.venda);
             
        });
        
    });
    $(document).on('click', '#save', function(){
        $.ajax({
            data: $("#materialForm").serialize(),
            url: "{{route('materiais.store')}}",
            type:"POST",
            success: function(){
                table.draw();
                toastr.success('Material cadastrado com sucesso!');
            },
            error: function(){
                toastr.error('Algo deu errado, ERRO!');
            }
        });
    });

    $(document).on('click','#destroy', function(){
        var url = $(this).data('id');
        swal.fire({
                title:'Excluir Material?',
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
                        table.draw();
                        toastr.success('material foi deletado com sucesso!');
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