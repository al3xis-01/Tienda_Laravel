@extends('layouts.app-master')


@section('content')

    <div class="container mt-0">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h5>Listado de categorias</h5>
                </div>
                <div class="pull-right mb-2">
                    <a class="btn btn-success" href="{{ route('Categoria.create') }}"> Crear Categoria</a>
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
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Action</th>
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
                ajax: "{{ url('Categoria') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'nombre', name: 'nombre' },
                    { data: 'descripcion', name: 'descripcion' },
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
                            url: "{{ url('Categoria-Eliminar') }}",
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

