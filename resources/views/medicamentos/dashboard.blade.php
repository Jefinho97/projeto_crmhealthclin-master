@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')


<div class="col-md-10 offset-md-1 dashboard-title-container">
<h1>Medicamentos Cadastrados</h1>  <button type="button" class="btn btn-success" id="add" style="float:right"> Cadastrar medicamento</button>
</div>
<div class="col-md-10 offset-md-1 dashboard-events-container">
    <table class="table table-hover data-table">   
        <thead>
            <tr>
                <th scope="col">Medicamento</th>
                <th scope="col">Unidade de medida</th>
                <th scope="col">Custo</th>
                <th scope="col">Preço Venda</th>
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
                <input type="hidden" id="medicamento_id" name="medicamento_id">            
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Medicamento:</label>
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
                        <label for="title">Preço Venda:</label>
                        <input type="number" step=".01" min="0" class="form-control" id="venda" name="venda">
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
            ajax: "{{ route('medicamentos.dashboard') }}",
            columns: [
                {data: 'nome', name: 'nome'},
                {data: 'uni_medida', name: 'uni_medida'},
                {data: 'custo', name: 'custo'},
                {data: 'venda', name: 'venda'},
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
        $('#medicamento_id').val();
        $('#titulo').html("Cadastrar Novo Medicamentos");
        $('#form').trigger('reset');
        $('#modal').modal('show')
    });

    $(document).on('click', '#edit', function(){
        var url = $(this).data('id');
        
        $.get(url, function(data){
            $('#modal').modal('show');
            $('#titulo').html("Atualizar função");
            $('#medicamento_id').val(data.id);
            $('#nome').val(data.nome);
            $('#uni_medida').val(data.uni_medida)
            $('#custo').val(data.custo);
            $('#venda').val(data.venda);
        });
        
    });
    $(document).on('click', '#save', function(){
        
        $.ajax({
            data: $("#form").serialize(),
            url: "{{route('medicamentos.store')}}",
            type:"POST",
            success: function(){
                table.draw();
                toastr.success('Medicamento criado com sucesso!');
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
                html:'Tem certeza que quer <b>deletar</b> o medicamento',
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
                        toastr.success('Medicamento deletada com sucesso!');
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