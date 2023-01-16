
@extends('layouts.app-master')


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left ">
                    <h2>Editar Producto</h2>
                </div>
            </div>
        </div>
        @if(session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{ route('Producto.update',$producto->id) }}" method="POST" enctype="multipart/form-data" class="form-control">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre: </label>
                    <input type="text" class="form-control" name="nombre"  placeholder="Nombre" value="{{$producto->nombre}}">
                    @error('nombre')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción: </label>
                    <input type="text" class="form-control" name="descripcion"  placeholder="Descripción" value="{{$producto->descripcion}}">
                    @error('descripcion')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="precio_venta" class="form-label">Precio Venta: </label>
                    <input type="number" class="form-control" name="precio_venta"  placeholder="" value="{{$producto->precio_venta}}">
                    @error('precio_venta')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="minimo" class="form-label">Minimo: </label>
                    <input type="number" class="form-control" name="minimo"  placeholder="" value="{{$producto->minimo}}">
                    @error('minimo')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="maximo" class="form-label">Máximo: </label>
                    <input type="number" class="form-control" name="maximo"  placeholder="" value="{{$producto->maximo}}">
                    @error('maximo')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="imagen" class="form-label">Imagen: </label>
                    <input type="file" class="form-control" name="imagen"  placeholder="">
                    @error('imagen')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="fecha_caducidad" class="form-label">Caducidad: </label>
                    <input type="date" class="form-control" name="fecha_caducidad"  placeholder="" value="{{$producto->fecha_caducidad}}">
                    @error('fecha_caducidad')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="id_categoria" class="form-label">Categoria: </label>
                    <select name="id_categoria" class="form-select" id="id_categoria">

                    </select>
                    @error('id_categoria')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 text-end">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
                <div class="col-md-6">
                    <a  class="btn btn-danger " href="{{ route('Producto.index') }}">Cancelar</a>
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
                        const value ='{{$producto->id_categoria}}';
                        $('#id_categoria').val(value);
                    }
                });
            });
        </script>
@endsection
