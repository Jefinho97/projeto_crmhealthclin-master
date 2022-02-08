@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')


<div class="col-md-10 offset-md-1 dashboard-title-container">
<h1>Equipamentos Cadastrados</h1>  <button type="button" class="btn btn-success" id="add" style="float:right"> Cadastrar Equipamentos</button>
</div>
<div class="col-md-10 offset-md-1 dashboard-events-container">
    <table class="table table-hover data-table">   
        <thead>
            <tr>
                <th scope="col">Equipamento</th>
                <th scope="col">Marca/Modelo</th>
                <th scope="col">Unidade de medida</th>
                <th scope="col">Preço Aquisição</th>
                <th scope="col">Depreciação (meses)</th>
                <th scope="col">Custo Diaria</th>
                <th scope="col">Valor Diaria</th>
                <th scope="col"style="text-align: center;" >Ações</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="addLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form  id="form" name="form">
                <input type="hidden" id="equipamento_id" name="equipamento_id">            
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Equipamento:</label>
                        <input type="text" class="form-control" id="nome" name="nome">
                    </div>
                    <div class="form-group">
                        <label for="title">Marca/Modelo:</label>
                        <input type="text" class="form-control" id="marca_modelo" name="marca_modelo">
                    </div>
                    <div class="form-group">
                        <label for="title">Unidade de Medida:</label>
                        <input type="text" class="form-control" id="uni_medida" name="uni_medida">
                    </div>
                    <div class="form-group">
                        <label for="title">Preço Aquisição:</label>
                        <input type="number" step=".01" min="0" class="form-control" id="preco" name="preco">
                    </div>
                    <div class="form-group">
                        <label for="title">Depreciação (meses):</label>
                        <input type="number" step=".01" min="0" class="form-control" id="depreciacao" name="depreciacao">
                    </div>
                    <div class="form-group">
                        <label for="title">Custo Dia:</label>
                        <input type="number" step=".01" min="0" class="form-control" id="custo_dia" name="custo_dia">
                    </div>
                    <div class="form-group">
                        <label for="title">Valor Diaria:</label>
                        <input type="number" step=".01" min="0" class="form-control" id="valor_dia" name="valor_dia">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="save">Salvar Equipamento</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
toastr.options.preventDuplicates = true;
$(function(){
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });  
    var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('equipamentos.dashboard') }}",
            columns: [
                {data: 'nome', name: 'nome'},
                {data: 'marca_modelo', name: 'marca_modelo'},
                {data: 'uni_medida', name: 'uni_medida'},
                {data: 'preco', name: 'preco'},
                {data: 'depreciacao', name: 'depreciacao'},
                {data: 'custo_dia', name: 'custo_dia'},
                {data: 'valor_dia', name: 'valor_dia'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "language": {
                "search": "Buscar:",
                "lengthMenu": "Mostrar _MENU_ Registros",
                "zeroRecords": "Nenhum registro encontrado",
                "emptyTable": "Nenhum Registro",
                "info": "Mostrando pagina _PAGE_ de _PAGES_",
                "infoEmpty": "",
                "processing": "Processando...",
                "paginate": {
                    "first":      "Primeiro",
                    "last":       "Ultimo",
                    "next":       "Proximo",
                    "previous":   "Anterior"
                },
            }
        });

    $('#add').click( function(){
        $('#equipamento_id').val();
        $('#titulo').html("Cadastrar Novo Equipamento");
        $('#form').trigger('reset');
        $('#modal').modal('show')
    });

    $(document).on('click', '#edit', function(){
        var url = $(this).data('id');
        
        $.get(url, function(data){
            $('#modal').modal('show');
            $('#titulo').html("Atualizar função");
            $('#equipamento_id').val(data.id);
            $('#nome').val(data.nome);
            $('#marca_modelo').val(data.marca_modelo);
            $('#uni_medida').val(data.uni_medida)
            $('#preco').val(data.preco);
            $('#depreciacao').val(data.depreciacao);
            $('#custo_dia').val(data.custo_dia);
            $('#valor_dia').val(data.valor_dia);
        });
        
    });
    $(document).on('click', '#save', function(){
        
        $.ajax({
            data: $("#form").serialize(),
            url: "{{route('equipamentos.store')}}",
            type:"POST",
            success: function(){
                table.draw();
                toastr.success('Equipamento criado com sucesso!');
                $('#modal').modal('hide');
            },
            error: function(){
                toastr.error('Algo deu errado, ERRO!');
                $('#modal').modal('hide');
            }
        });
    });
    $(document).on('click','#destroy', function(){
        var url = $(this).data('id');
        swal.fire({
                title:'Excluir Dieta?',
                html:'Tem certeza que quer <b>deletar</b> a dieta',
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
                        toastr.success('Equipamento deletada com sucesso!');
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