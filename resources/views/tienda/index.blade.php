@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-5 rounded">
        @auth
            @if ($venta = Session::get('success'))
                <div class="alert alert-success">
                    <p class="text-start">
                        La venta se realizó correctamente, Folio: {{$venta['venta']['folio']}}
                    </p>
                </div>
            @endif

            <form id="form" action="{{route('Tienda.store')}}" method="POST" enctype="multipart/form-data" class="form-control">
                @csrf
                <div class="row text-center mb-5">
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
                <div class="row text-center mb-5">
                    <div class="col-md-12">
                        <table class="table table-responsive" id="myTable">
                            <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Existencias</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="myBody">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row text-center m-5">
                    <div class="col-4">
                        <label for="subtotal">Subtotal: </label>
                        <input type="number" name="subtotal" id="subtotal" class="form-control" value="0" readonly>
                    </div>
                    <div class="col-4">
                        <label for="total">Total: </label>
                        <input type="number" name="total" id="total" class="form-control" value="0" readonly>
                    </div>
                    <div class="col-4">
                        <button type="button" class="btn btn-success" onclick="terminarVenta()">
                            <i class="fa fa-plus"></i>
                            Terminar Venta
                        </button>
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

        @endauth
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        const total_in = $('#total');
        const subtotal_in = $('#subtotal');

        const body_table = $('#myBody');
        const myTable = $('#myTable');
        const modalProducto = $('#modalProducto');
        const buscar = $('#buscar');
        const contenido = $('#contenido');
        const form = $('#form');

        let total = 0;
        let subtotal = 0;

        const calcular = () => {
            const precio_v = $('.precio_venta');
            const existencia = $('.existencia');
            const stock = $('.stock');
            const _total = $('._total');
            total = 0;
            subtotal = 0;

            $.each(precio_v, (i, val) => {
                const p = Number($(precio_v[i]).val());
                let e = Number($(existencia[i]).val());
                let res = p * e;

                if (e > Number($(stock[i]).val())){
                    e = Number($(stock[i]).val());
                    res = p * e;
                }
                if(e <= 0){
                    e= 1;
                    res = p * e;
                }

                $(_total[i]).val(res);
                $(existencia[i]).val(e);

                total += res;
                subtotal += res;
            });

            total_in.val(total);
            subtotal_in.val(subtotal);

        };

        const buscarProducto = () => {
            if (buscar.val !== ''){
                $.ajax({
                    url: "{{url('Inventario-Lista')}}",
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
                            const existencia = datum.stock;

                            const tarjeta = '<div class="col-md-3">'+
                                '<div class="card align-items-center" >' +
                                '<img src="'+url+'" class="card-img-top" ' +
                                'style="width: 70px; height: 70px">' +
                                '<div class="card-body">' +
                                '<h6 class="card-title">'+nombre+'</h6>' +
                                '<p class="card-text">' + descripcion +'</p>' +
                                '<p class="card-text">$ ' + precio +'</p>' +
                                '<p class="card-text">Existencias ' + existencia +'</p>' +
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

        const agregarProducto = (producto) => {
            producto = JSON.parse($(producto).attr('data-json'));

            const id = producto.id;

            if ($('#tr_'+id).length > 0){
                Swal.fire(
                    'PRODUCTO YA AGREGADO',
                    'El producto ya se encuentra agregado',
                    'info'
                );
                return;
            }

            const html = '<tr id="tr_'+id+'" onclick="calcular()" onchange="calcular()">' +
                '<td> '+producto.nombre+'</td>'+
                '<td> <input type="hidden" class="form-control producto" name="inventario[]" id="inventario'+id+'" value="'+producto.id+'">' +
                '<input readonly type="number" class="form-control precio_venta" name="precio_venta[]" id="precio_venta'+id+'" value="'+producto.precio_venta+'"></td>'+
                '<td><input type="number" class="form-control stock" name="stock[]" id="stock'+id+'" value="'+producto.stock+'" readonly></td>'+
                '<td><input type="number" class="form-control existencia" name="existencia[]" id="existencia'+id+'" value="1"></td>'+
                '<td><input type="number" class="form-control _total" name="total_p[]" id="total'+id+'" value="'+producto.precio_venta+'" readonly></td>'+
                '<td><button type="button" class="btn btn-danger btn-sm btn-delete" data-id="'+id+'" ><i class="fa fa-trash"></i></button></td>'+
                '</tr>';

            body_table.append(html);
            modalProducto.modal('hide');
            calcular();
        }

        const terminarVenta = () => {
          if ($('.producto').length <= 0){
              Swal.fire(
                  'ERROR',
                  'No puede terminar la venta sin escoger un producto',
                  'warning'
              );
              return;
          }
          form.submit();
        }

        myTable.on('click','.btn-delete', function () {
            $(this).closest('tr').remove();
            calcular();
        });


        $(document).ready(() => {
           @if(isset($venta))
            let json = '@php(print json_encode($venta))';
            let id = JSON.parse(json).venta.id;

            $.ajax({
                url: "{{url('Tienda/Ticket/'.$venta['venta']['id'])}}",
                type: "GET",
                dataType: "json",
                success: function (data) {
                    if(data.ticket !== ''){
                        const window_print =  window.open(' ', 'popimpr');
                        window_print.document.write(data.ticket);
                        setTimeout(function () {
                            window_print.print();
                            window_print.close();
                        }, 1000);
                    }
                }
            });

            @endif
        });

    </script>

@endpush
