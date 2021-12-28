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
            {{-- @foreach($orcamentos as $orcamento)
                <tr>
                    <td scope="row">{{ date('d/m/y', strtotime($orcamento->data)) }}</td>
                    <td><a href="{{ route('orcamentos.show',[$orcamento->id]) }}">{{ $orcamento->procedimento }}</a></td>
                    <td>
                        <form action="{{ route('orcamentos.status',[$orcamento->id]) }}" method="POST">
                        @csrf
                        @method('PUT')  
                            <select name="status" id="status" class="form-control" onchange="this.form.submit()"> 
                                <option value="----">----</option>
                                <option value="novo" {{ $orcamento->status === "novo"? "selected" :"" }}>Novo</option>
                                <option value="aguardando" {{ $orcamento->status === "aguardando"? "selected" : "" }}>Aguardando</option>
                                <option value="em andamento" {{ $orcamento->status === "em andamento"? "selected" : "" }}>Em andamento</option>
                                <option value="cancelado" {{ $orcamento->status === "cancelado"? "selected" : "" }}>Cancelado</option>
                                <option value="ganho" {{ $orcamento->status === "ganho"? "selected" : "" }}>Ganho</option>
                                <option value="perdido" {{ $orcamento->status === "perdido"? "selected" : "" }}>Perdido</option>
                                <option value="desistencia" {{ $orcamento->status === "desistencia"? "selected" : "" }}>Desistencia</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('orcamentos.razao_status',[$orcamento->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                            <select name="razao_status" id="razao_status" class="form-control" onchange="this.form.submit()" > 
                                <option value="----">----</option>
                                <option value="na fila" {{ $orcamento->razao_status === "na fila"? "selected" :"" }}>Na fila para atendimento</option>
                                <option value="aguardando cliente" {{ $orcamento->razao_status === "aguardando cliente"? "selected" : "" }}>Aguardando cliente</option>
                                <option value="aguardando envio" {{ $orcamento->razao_status === "aguardando envio"? "selected" : "" }}>Aguardando envio do cirurgião</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <a href="{{ route('orcamentos.edit', [$orcamento->id]) }}" class="btn btn-info edit-btn "> Editar </a> 
                    </td>
                    <td>    
                        <a href="javascript:void(0)" class="btn btn-sm btn-danger" data-id="{{ route('orcamentos.destroy', [$orcamento->id]) }}" id="destroy">Delete</button>
                    </td>
                </tr>
            @endforeach --}}
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
            ]
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