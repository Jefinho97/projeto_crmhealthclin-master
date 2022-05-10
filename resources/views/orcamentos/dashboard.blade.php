@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')

<div class="container overflow-hidden col-md-10 offset-md-1" style="padding-top: 20px;">
    <div class="row gx-5">
        <div class="col">
            <div class="p-3 border bg-light">Solicitados: {{$solicitados}}</div>
        </div>
        <div class="col">
            <div class="p-3 border bg-light">Fechados: {{$fechados}}</div>
        </div>
        <div class="col">
            <div class="p-3 border bg-light">Perdidos: {{$perdidos}}</div>
        </div>
        <div class="col">
            <div class="p-3 border bg-light">Abertos: {{$abertos}}</div>
        </div>
    </div>
</div>

<div class="col-md-10 offset-md-1 dashboard-title-container">
<h1>Orçamentos Cadastrados</h1>
<button type="button" class="btn btn-success" id="add" style="float:right"> criar orçamento</button>
</div>
<div class="col-md-10 offset-md-1 dashboard-events-container">
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
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="addLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Criar Orçamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form  id="form" name="form">          
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Procedimento:</label>
                        <input type="text" class="form-control" id="procedimento" name="procedimento">
                    </div>

                    <label for="title">Informações do Paciente:</label>
                    <div class="form-group">
                        <input type="text" class="form-control" id="paciente" name="paciente" placeholder="Nome do Paciente">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" id="email_pac" name="email_pac" placeholder="E-mail do Paciente">
                    </div>
                    <div class="form-group">    
                        <input type="tel" class="form-control" id="telefone_1" name="telefone_1" placeholder="Telefone do Paciente">
                    </div>
                    <div class="form-group">    
                        <input type="tel" class="form-control" id="telefone_2" name="telefone_2" placeholder="Telefone Opcional do Paciente">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="save">Criar Orçamento</button>
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
        ajax: "{{ route('orcamentos.dashboard') }}",
        columns: [
            {data: 'formData', name: 'formData'},
            {data: 'formProcedimento', name: 'formProcedimento'},
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
    
    $('#add').click( function(){
        $('#Form').trigger('reset');
        $('#modal').modal('show')
    });
    
    $(document).on('click', '#save', function(){
        var procedimento = form.procedimento;
        var paciente = form.paciente;
        var email_pac = form.email_pac;
        var telefone_1 = form.telefone_1;
        var telefone_2 = form.telefone_2;

        if((procedimento.value == "") | (paciente.value == "") | (email_pac.value == "") | (telefone_1.value == "") | (telefone_2.value == "")){
            if(procedimento.value == ""){
                toastr.error('Procedimento não informada');
                procedimento.focus();
                return;
            }
            if(paciente.value == ""){
                toastr.error('Paciente não informada');
                paciente.focus();
                return;
            }
            if(email_pac.value == ""){
                toastr.error('E-mail não informado');
                email_pac.focus();
                return;
            }
            if(telefone_1.value == ""){
                toastr.error('Telefone não informado');
                telefone_1.focus();
                return;
            }
            if(telefone_2.value == ""){
                toastr.error('Telefone não informado');
                telefone_2.focus();
                return;
            }
        } else {
            $.ajax({
                data: $("#form").serialize(),
                url: "{{route('orcamentos.store')}}",
                type:"POST",
                success: function(){
                    table.draw();
                    toastr.success('Orçamento criado com sucesso!');
                    $('#modal').modal('hide');
                },
                error: function(){
                    toastr.error('Algo deu errado, ERRO!');
                    $('#modal').modal('hide');
                }
            });
        }
    });
});
</script>
@endsection