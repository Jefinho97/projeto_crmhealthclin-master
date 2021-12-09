@extends('layouts.main')

@section('title', 'Editar Material')

@section('content')

<div id="event-create-container" class="col-md-6 offset-md-3">
    <h1>Editar Material</h1>
    <form action="{{ route('materiais.update', [$material->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
        <label for="title">Tipo:</label>
        <select name="tipo" id="tipo" class="form-control"> 
            <option value="----">----</option>
            <option value="material" {{ $material->tipo === "material"? "selected" :"" }}>Material</option>
            <option value="medicamento" {{ $material->tipo === "medicamento"? "selected" : "" }}>Medicamento</option>
            <option value="dieta" {{ $material->tipo === "dieta"? "selected" : "" }}>Dieta</option>
            <option value="equipamento" {{ $material->tipo === "equipamento"? "selected" : "" }}>Equipamento</option>
        </select>
        </div>
        <div class="form-group">
            <label for="title">Nome:</label>
            <input type="text" class="form-control" id="nome" name="nome" value="{{ $material->nome}}">
        </div>
        <div class="form-group">
            <label for="title">Unidade de Medida:</label>
            <input type="text" class="form-control" id="uni_medida" name="uni_medida" value="{{ $material->uni_medida }}">
        </div>
        <div class="form-group">
            <label for="title">Custo do Produto:</label>
            <input type="number" step=".01" min="0" class="form-control" id="custo" name="custo" value="{{ $material->custo }}">
        </div>
        <div class="form-group">
            <label for="title">Preço da venda:</label>
            <input type="number" step=".01" min="0" class="form-control" id="venda" name="venda" value="{{ $material->venda }}">
        </div>
        <input type="submit" class="btn btn-primary" value="Editar Material">
    </form>
</div>
@endsection