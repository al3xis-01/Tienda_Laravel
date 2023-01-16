@extends('layouts.app-master')


@section('content')

    <div class="container mt-0">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h5>Listado de usuarios</h5>
                </div>
                <div class="pull-right mb-2">
                    <a class="btn btn-success" href="{{ route('Usuario.create') }}"> Crear Usuario</a>
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
                    <th>Apellido</th>
                    <th>Usuario</th>
                    <th>Correo</th>
                    <th>Tipo</th>
                    <th>Estado</th>
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
                ajax: "{{ url('Usuario') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'nombre', name: 'nombre' },
                    { data: 'apellido', name: 'apellido' },
                    { data: 'username', name: 'username' },
                    { data: 'email', name: 'email' },
                    { data: 'tipo', name: 'tipo' },
                    { data: 'estado', name: 'estado' },
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
                            url: "{{ url('Usuario-Eliminar') }}",
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

