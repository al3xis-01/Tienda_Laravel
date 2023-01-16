@extends('layouts.app-master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left ">
                    <h2>Agregar un nuevo AltaProducto</h2>
                </div>
            </div>
        </div>
        @if(session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{ route('AltaProducto.store') }}" method="POST" enctype="multipart/form-data" class="form-control">
            @csrf
            <div class="row">
                <div class="mb-3">
                    <label for="motivo" class="form-label">Motivo: </label>
                    <select name="motivo" id="motivo" class="form-select">
                        <option value="COMPRA_PROVEEDOR" selected> Compra a Proveedor</option>
                        <option value="REGALO"> Regalo</option>
                    </select>
                    @error('tipo')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="id_proveedor" class="form-label">Proveedor: </label>
                    <select name="id_proveedor" id="id_proveedor" class="form-select">
                    </select>
                    @error('tipo')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 container-fluid">
                    <div class="row">
                        <div class="col-md-10">
                            <input type="text" name="buscar" id="buscar" class="form-control" placeholder="Ingrese el dato a buscar">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-secondary" onclick="buscarProducto()">
                                <i class="fa fa-search"></i>
                                Buscar
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mb-3 container-fluid">
                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Descuento</th>
                                <th>Subtotal</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="body_table">

                        </tbody>
                    </table>
                </div>

                <div class="mb-3">
                    <label for="descuento" class="form-label">Descuento: </label>
                    <input type="number" name="descuento" id="descuento" class="form-control" value="0">
                    <label for="subtotal" class="form-label">Subtotal: </label>
                    <input type="number" name="subtotal" id="subtotal" class="form-control" readonly>
                    <label for="total" class="form-label">Total: </label>
                    <input type="number" name="total" id="total" class="form-control" readonly>
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
                    <a  class="btn btn-danger " href="{{ route('AltaProducto.index') }}">
                        <i class="fa fa-ban"></i>
                        Cancelar
                    </a>
                </div>
            </div>
        </form>

        <div class="modal fade " id="modalProducto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Buscar Producto</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row text-center" id="contenido">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        @endsection

@push('scripts')
            <script type="text/javascript">
                const total_in = $('#total');
                const subtotal_in = $('#subtotal');
                const descuento_in = $('#descuento');
                const buscar = $('#buscar');
                const modalProducto = $('#modalProducto');
                const contenido = $('#contenido');
                const body_table = $('#body_table');
                const myTable = $('#myTable');

                let total = 0;
                let subtotal = 0;
                let descuento = 0;

                const calcular = () => {
                    const precio_v = $('.precio_venta');
                    const existencia = $('.existencia');
                    const _descuento = $('._descuento');
                    const _subtotal = $('._subtotal');
                    const _total = $('._total');
                    total = 0;
                    subtotal = 0;

                    $.each(precio_v, (i, val) => {
                       const p = Number($(precio_v[i]).val());
                       const e = Number($(existencia[i]).val());

                       const res = p * e;

                       $(_subtotal[i]).val(res);
                        $(_total[i]).val(res);
                        total += res;
                        subtotal += res;
                    });

                    total_in.val(total) ;
                    subtotal_in.val(subtotal);
                    descuento_in.val(descuento);
                }


                myTable.on('click','.btn-delete', function () {
                    $(this).closest('tr').remove();
                    calcular();
                });

                const agregarProducto = (producto) => {
                    producto = JSON.parse($(producto).attr('data-json'));

                    const id = producto.id;
                    const html = '<tr id="tr_'+id+'" onclick="calcular()">' +
                        '<td> '+producto.nombre+'</td>'+
                        '<td> <input type="hidden" class="form-control producto" name="producto[]" id="producto'+id+'" value="'+producto.id+'">' +
                        '<input type="number" class="form-control precio_venta" name="precio_venta[]" id="precio_venta'+id+'" value="'+producto.precio_venta+'"></td>'+
                        '<td><input type="number" class="form-control existencia" name="existencia[]" id="existencia'+id+'" value="1"></td>'+
                        '<td><input type="number" class="form-control _descuento" name="descuento[]" id="descuento'+id+'" value="0"></td>'+
                        '<td><input type="number" class="form-control _subtotal" name="subtotal_p[]" id="subtotal'+id+'" value="'+producto.precio_venta+'" readonly></td>'+
                        '<td><input type="number" class="form-control _total" name="total_p[]" id="total'+id+'" value="'+producto.precio_venta+'" readonly></td>'+
                        '<td><button type="button" class="btn btn-danger btn-sm btn-delete" data-id="'+id+'" ><i class="fa fa-trash"></i></button></td>'+
                        '</tr>';

                    body_table.append(html);
                    modalProducto.modal('hide');
                    calcular();
                }

                const buscarProducto = () => {
                    if (buscar.val !== ''){
                        $.ajax({
                            url: "{{url('Producto-Lista')}}",
                            type: "GET",
                            dataType: "json",
                            success: function (data) {
                                contenido.html('');
                                for (const datum of data) {
                                    const url = '{{url('')}}/' + datum.imagen;
                                    const id = datum.id;
                                    const nombre = datum.nombre;
                                    const descripcion = datum.descripcion;
                                    const precio = datum.precio_venta;

                                    const tarjeta = '<div class="col-md-3">'+
                                        '<div class="card align-items-center" >' +
                                        '<img src="'+url+'" class="card-img-top" ' +
                                        'style="width: 70px; height: 70px">' +
                                        '<div class="card-body">' +
                                        '<h6 class="card-title">'+nombre+'</h6>' +
                                        '<p class="card-text">' + descripcion +'</p>' +
                                        '<p class="card-text">$ ' + precio +'</p>' +
                                        '<p class="card-text"> <button class="btn btn-success" data-json=\''+JSON.stringify(datum)+'\' onclick="agregarProducto(this)">' +
                                        'Agregar' +
                                        '</button></p>' +
                                        '</div>' +
                                        '</div>' +
                                        '</div>';

                                    contenido.append(tarjeta);
                                }

                            }
                        });

                        modalProducto.modal('show');
                    }
                }

                $(document).ready( function () {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{url('Proveedor-Lista')}}",
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('#id_proveedor').empty();
                            for (const dataValue of data) {
                                $('#id_proveedor').append("<option value='"+dataValue.id+"'>"+dataValue.nombre_completo+"</option>");
                            }
                        }
                    });

                    calcular();

                });
            </script>
@endpush
