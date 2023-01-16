
@extends('layouts.app-master')


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left ">
                    <h2>Editar Proveedor</h2>
                </div>
            </div>
        </div>
        @if(session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{ route('Proveedor.update',$proveedor->id) }}" method="POST" enctype="multipart/form-data" class="form-control">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="mb-3">
                    <label for="nombre_completo" class="form-label">Nombre: </label>
                    <input type="text" class="form-control" name="nombre_completo"  placeholder="Nombre" value="{{$proveedor->nombre_completo}}">
                    @error('nombre_completo')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo: </label>
                    <input type="email" class="form-control" name="email"  placeholder="Descripción" value="{{$proveedor->email}}">
                    @error('email')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo: </label>
                    <select name="tipo" id="tipo" class="form-select" >
                        <option value="FISICA" selected>Fisica</option>
                        <option value="MORAL">Moral</option>
                    </select>
                    @error('tipo')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción: </label>
                    <input type="text" class="form-control" name="descripcion"  placeholder="Descripción" value="{{$proveedor->descripcion}}">
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
                    <a  class="btn btn-danger " href="{{ route('Proveedor.index') }}">Cancelar</a>
                </div>
            </div>
        </form>
    <script>
        $(document).ready( function () {
            const value = '{{$proveedor->tipo}}'
            $('#tipo').val(value);
        });
    </script>
@endsection
