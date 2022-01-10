@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')


<div class="col-md-10 offset-md-1 dashboard-title-container">
<h1>Orçamentos Cadastrados</h1>
</div>
<div class="col-md-10 offset-md-1 dashboard-events-container">
    @if( count($orcamentos) > 0)
    <table class="table table-hover data-table">   
        <thead>
            <tr>
                <th scope="col">Data</th>
                <th scope="col">Procedimento</th>
                <th scope="col">Status</th>
                <th scope="col">Razão do Status</th>
                <th scope="col" style="text-align: center;">Ações</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    @else
    <p>Não há nenhum orçamento cadastrado, <a href="{{ route('orcamentos.create') }}"> criar orçamento</a></p>
    @endif
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
            ajax: "{{ route('orcamentos.dashboard') }}",
            columns: [
                {data: 'formData', name: 'formData'},
                {data: 'procedimento', name: 'procedimento'},
                {data: 'formStatus', name: 'formStatus'},
                {data: 'formRazao', name: 'formRazao'},
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
        $(document).on('change','#status', function(){
            var url = $(this).data('id');
            var status = $(this).val();
            swal.fire({
                    title:'Alterar Status?',
                    html:'Tem certeza que quer <b>alterar</b> o status',
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
                        data: {status: status},
                        type: "PUT",
                        success: function(){
                            table.draw();
                            toastr.success('Status alterado com sucesso!');
                        },
                        error: function(){
                            toastr.error('Algo deu errado, ERRO!');
                        }
                    });
                }
            });
        });
        $(document).on('change','#razao_status', function(){
            var url = $(this).data('id');
            var razao_status = $(this).val();
            swal.fire({
                    title:'Alterar Razao?',
                    html:'Tem certeza que quer <b>alterar</b> a razão',
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
                        data: {razao_status: razao_status},
                        type: "PUT",
                        success: function(){
                            table.draw();
                            toastr.success('Razão alterada com sucesso!');
                        },
                        error: function(){
                            toastr.error('Algo deu errado, ERRO!');
                        }
                    });
                }
            });
        });
        $(document).on('click','#destroy', function(){
            var url = $(this).data('id');
            swal.fire({
                    title:'Excluir Orçamento?',
                    html:'Tem certeza que quer <b>deletar</b> o orçamento',
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
                            toastr.success('Orçamento foi deletado com sucesso!');
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