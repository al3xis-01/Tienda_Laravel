
@extends('layouts.app-master')


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left ">
                    <h2>Editar Usuario</h2>
                </div>
            </div>
        </div>
        @if(session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{ route('Usuario.update',$usuario->id) }}" method="POST" enctype="multipart/form-data" class="form-control">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre: </label>
                    <input type="text" class="form-control" name="nombre"  placeholder="Nombre" value="{{$usuario->nombre}}">
                    @error('nombre')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido: </label>
                    <input type="text" class="form-control" name="apellido"  placeholder="Apellido" value="{{$usuario->apellido}}">
                    @error('apellido')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo: </label>
                    <input type="email" class="form-control" name="email"  placeholder="" value="{{$usuario->nombre}}">
                    @error('email')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Usuario: </label>
                    <input type="text" class="form-control" name="username"  placeholder="" value="{{$usuario->username}}">
                    @error('username')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo: </label>
                    <select name="tipo" id="tipo" value="{{$usuario->tipo}}">
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
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
                <div class="col-md-6">
                    <a  class="btn btn-danger " href="{{ route('Usuario.index') }}">Cancelar</a>
                </div>
            </div>
        </form>
        <script type="text/javascript">
            $(document).ready( function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{url('Categoria-Lista')}}",
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('#id_categoria').empty();
                        for (const dataValue of data) {
                            $('#id_categoria').append("<option value='"+dataValue.id+"'>"+dataValue.nombre+"</option>");
                        }
                        const value ='{{$usuario->id_categoria}}';
                        $('#id_categoria').val(value);
                    }
                });
            });
        </script>
@endsection
