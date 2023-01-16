
@extends('layouts.app-master')


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left ">
                    <h2>Editar Categoria</h2>
                </div>
            </div>
        </div>
        @if(session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{ route('Categoria.update',$categoria->id) }}" method="POST" enctype="multipart/form-data" class="form-control">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre: </label>
                    <input type="text" class="form-control" name="nombre"  placeholder="Nombre" value="{{ $categoria->nombre }}">
                    @error('nombre')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción: </label>
                    <input type="text" class="form-control" name="descripcion"  placeholder="Descripción" value="{{$categoria->descripcion}}">
                    @error('descripcion')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 text-end">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
                <div class="col-md-6">
                    <a  class="btn btn-danger " href="{{ route('Categoria.index') }}">Cancelar</a>
                </div>
            </div>
        </form>
@endsection
