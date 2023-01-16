@extends('layouts.app-master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left ">
                    <h2>Agregar un nuevo Usuario</h2>
                </div>
            </div>
        </div>
        @if(session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{ route('Usuario.store') }}" method="POST" enctype="multipart/form-data" class="form-control">
            @csrf
            <div class="row">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre: </label>
                    <input type="text" class="form-control" name="nombre"  placeholder="Nombre">
                    @error('nombre')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido: </label>
                    <input type="text" class="form-control" name="apellido"  placeholder="Apellido">
                    @error('apellido')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo: </label>
                    <input type="email" class="form-control" name="email"  placeholder="">
                    @error('email')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Usuario: </label>
                    <input type="text" class="form-control" name="username"  placeholder="">
                    @error('username')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña: </label>
                    <input type="password" class="form-control" name="password"  placeholder="">
                    @error('password')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo: </label>
                    <select name="tipo" id="tipo" class="form-select">
                        <option value="ADMIN" selected> Administrador</option>
                        <option value="USER"> Usuario</option>
                        <option value="VENDEDOR"> Vendedor</option>
                    </select>
                    @error('tipo')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i>
                        Guardar
                    </button>

                </div>
                <div class="col-md-6">
                    <a  class="btn btn-danger " href="{{ route('Usuario.index') }}">
                        <i class="fa fa-ban"></i>
                        Cancelar
                    </a>
                </div>
            </div>
        </form>

@endsection
