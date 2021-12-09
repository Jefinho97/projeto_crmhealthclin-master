@extends('layouts.main')

@section('title', 'Editar Diaria')

@section('content')

<div id="event-create-container" class="col-md-6 offset-md-3">
    <h1>Editar Diaria</h1>
    <form action="{{ route('diarias.update', [$diaria->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Descrição:</label>
            <input type="text" class="form-control" id="descricao" name="descricao" value="{{ $diaria->descricao }}">
        </div>
        <div class="form-group">
            <label for="title">Custo da Diaria:</label>
            <input type="number" step=".01" min="0" class="form-control" id="custo" name="custo" value="{{ $diaria->custo }}">
        </div>
        <div class="form-group">
            <label for="title">Preço da venda:</label>
            <input type="number" step=".01" min="0" class="form-control" id="venda" name="venda" value="{{ $diaria->venda }}">
        </div>
        <input type="submit" class="btn btn-primary" value="Editar Função">
    </form>
</div>
@endsection