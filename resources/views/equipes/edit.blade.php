@extends('layouts.main')

@section('title', 'Editar Função')

@section('content')

<div id="event-create-container" class="col-md-6 offset-md-3">
    <h1>Editar Função</h1>
    <form action="{{ route('equipes.update', [$equipe->id]) }}" method="POST"  enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Função:</label>
            <input type="text" class="form-control" id="funcao" name="funcao" value="{{ $equipe->funcao}}">
        </div>
        <div class="form-group">
            <label for="title">Custo da Função:</label>
            <input type="number" step=".01" min="0" class="form-control" id="custo" name="custo" value="{{ $equipe->custo }}">
        </div>
        <div class="form-group">
            <label for="title">Preço da venda:</label>
            <input type="number" step=".01" min="0" class="form-control" id="venda" name="venda" value="{{ $equipe->venda }}">
        </div>
        <input type="submit" class="btn btn-primary" value="Editar Função">
    </form>
</div>
@endsection