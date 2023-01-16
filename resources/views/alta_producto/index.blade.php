@extends('layouts.app-master')


@section('content')

    <div class="container mt-0">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h5>Listado de Altas de productos</h5>
                </div>
                <div class="pull-right mb-2">
                    <a class="btn btn-success" href="{{ route('AltaProducto.create') }}"> Crear Alta</a>
                </div>
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="card-body">
            <table class="table table-hover table-bordered cell-border table-responsive row-border" id="datatable-crud">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Folio</th>
                    <th>Fecha</th>
                    <th>Motivo</th>
                    <th>Proveedor</th>
                    <th>Descuento</th>
                    <th>Subtotal</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready( function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#datatable-crud').DataTable({
                processing: true,
                serverSide: true,
                language: {
                    url: 'assets/es-ES.json',
                },
                ajax: "{{ url('AltaProducto') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'folio', name: 'folio' },
                    { data: 'fecha', name: 'fecha' },
                    { data: 'motivo', name: 'motivo' },
                    { data: 'id_proveedor', name: 'id_proveedor' },
                    { data: 'descuento', name: 'descuento' },
                    { data: 'subtotal', name: 'subtotal' },
                    { data: 'total', name: 'total' },
                    {data: 'action', name: 'action', orderable: false},
                ],
                order: [[0, 'asc']]
            });
            $('body').on('click', '.delete', function () {
                Swal.fire(
                    {
                        title: 'Desea borrar el registro',
                        showDenyButton: true,
                        showCancelButton: true,
                        confirmButtonText: 'Si',
                        denyButtonText: `No`,
                        icon: 'question'
                    }
                ).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        var id = $(this).data('id');
// ajax
                        $.ajax({
                            type:"POST",
                            url: "{{ url('AltaProducto-Eliminar') }}",
                            data: { id: id},
                            dataType: 'json',
                            success: function(res){

                                Swal.fire('Borrado!', '', 'success')
                                var oTable = $('#datatable-crud').dataTable();
                                oTable.fnDraw(false);
                            }
                        });
                    } else if (result.isDenied) {
                        //Swal.fire('Changes are not saved', '', 'info')
                    }
                })
            });
        });
    </script>
@endsection

