@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')


<div class="col-md-10 offset-md-1 dashboard-title-container">
<h1>Diarias Cadastradas</h1> <button type="button" class="btn btn-success" id="add" style="float:right"> cadastrar diaria</button>
</div>
<div class="col-md-10 offset-md-1 dashboard-events-container">
    <table class="table table-hover data-table">   
        <thead>
            <tr>
                <th scope="col">Descrição</th>
                <th scope="col">Custo</th>
                <th scope="col">Venda</th>
                <th scope="col" style="text-align: center;">Ações</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<div class="modal fade" id="modalDiaria" tabindex="-1" role="dialog" aria-labelledby="addDiariaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form  id="diariaForm" name="diariaForm">
                <input type="hidden" id="diaria_id" name="diaria_id">            
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Descrição:</label>
                        <input type="text" class="form-control" id="descricao" name="descricao">
                    </div>
                    <div class="form-group">
                        <label for="title">Custo da Diaria:</label>
                        <input type="number" step=".01" min="0" class="form-control" id="custo" name="custo">
                    </div>
                    <div class="form-group">
                        <label for="title">Preço de venda:</label>
                        <input type="number" step=".01" min="0" class="form-control" id="venda" name="venda">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="save">Salvar Diaria</button>
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
            ajax: "{{ route('diarias.dashboard') }}",
            columns: [
                {data: 'descricao', name: 'descricao'},
                {data: 'custo', name: 'custo'},
                {data: 'venda', name: 'venda'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    $('#add').click( function(){
        $('#diaria_id').val();
        $('#titulo').html("Criar nova diaria");
        $('#diariaForm').trigger('reset');
        $('#modalDiaria').modal('show')
    });   
    $(document).on('click', '#edit', function(){
        var url = $(this).data('id');
        
        $.get(url, function(data){
            $('#modalDiaria').modal('show');
            $('#titulo').html("Atualizar diaria");
            $('#diaria_id').val(data.id);
            $('#descricao').val(data.descricao);
            $('#custo').val(data.custo);
            $('#venda').val(data.venda);
             
        });
        
    });
    $(document).on('click', '#save', function(){
        $.ajax({
            data: $("#diariaForm").serialize(),
            url: "{{route('diarias.store')}}",
            type:"POST",
            success: function(){
                table.draw();
                toastr.success('Diaria criada com sucesso!');
            },
            error: function(){
                toastr.error('Algo deu errado, ERRO!');
            }
        });
    });
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
                        table.draw();
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