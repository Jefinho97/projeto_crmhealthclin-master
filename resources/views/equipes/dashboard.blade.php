@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')


<div class="col-md-10 offset-md-1 dashboard-title-container">
<h1>Funções Cadastradas</h1>  <button type="button" class="btn btn-success" id="add" style="float:right"> cadastrar função</button>
</div>
<div class="col-md-10 offset-md-1 dashboard-events-container">
    <table class="table table-hover data-table">   
        <thead>
            <tr>
                <th scope="col">Função</th>
                <th scope="col">Custo</th>
                <th scope="col">Venda</th>
                <th scope="col"style="text-align: center;" >Ações</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<div class="modal fade" id="modalEquipe" tabindex="-1" role="dialog" aria-labelledby="addEquipeLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form  id="equipeForm" name="equipeForm">
                <input type="hidden" id="equipe_id" name="equipe_id">            
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Função:</label>
                        <input type="text" class="form-control" id="funcao" name="funcao">
                    </div>
                    <div class="form-group">
                        <label for="title">Custo do funcionario:</label>
                        <input type="number" step=".01" min="0" class="form-control" id="custo" name="custo">
                    </div>
                    <div class="form-group">
                        <label for="title">Preço final:</label>
                        <input type="number" step=".01" min="0" class="form-control" id="venda" name="venda">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="save">Salvar Diaria</button>
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
            ajax: "{{ route('equipes.dashboard') }}",
            columns: [
                {data: 'funcao', name: 'funcao'},
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
        $('#equipe_id').val();
        $('#titulo').html("Criar nova função");
        $('#equipeForm').trigger('reset');
        $('#modalEquipe').modal('show')
    });

    $(document).on('click', '#edit', function(){
        var url = $(this).data('id');
        
        $.get(url, function(data){
            $('#modalEquipe').modal('show');
            $('#titulo').html("Atualizar função");
            $('#equipe_id').val(data.id);
            $('#funcao').val(data.funcao);
            $('#custo').val(data.custo);
            $('#venda').val(data.venda);
             
        });
        
    });
    $(document).on('click', '#save', function(){
        var funcao = equipeForm.funcao;
        var custo = equipeForm.custo;
        var venda = equipeForm.venda;

        if((funcao.value == "") | (custo.value == "") | (venda.value == "")){
            if(funcao.value == ""){
                toastr.error('Função não informada');
                descricao.focus();
                return;
            }
            if(custo.value == ""){
                toastr.error('Custo do Funcionario não informada');
                descricao.focus();
                return;
            }
            if(venda.value == ""){
                toastr.error('Preço Final não informado');
                descricao.focus();
                return;
            }
        } else {
            $.ajax({
                data: $("#equipeForm").serialize(),
                url: "{{route('equipes.store')}}",
                type:"POST",
                success: function(){
                    table.draw();
                    toastr.success('Função criada com sucesso!');
                    $('#modalEquipe').modal('hide');
                },
                error: function(){
                    toastr.error('Algo deu errado, ERRO!');
                    $('#modalEquipe').modal('hide');
                }
            });
        }
    });
    $(document).on('click','#destroy', function(){
        var url = $(this).data('id');
        swal.fire({
                title:'Excluir Função?',
                html:'Tem certeza que quer <b>deletar</b> a funçãp',
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
                        toastr.success('Função foi deletado com sucesso!');
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