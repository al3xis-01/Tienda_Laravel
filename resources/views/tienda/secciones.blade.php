@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-5 rounded">
        @auth
            Secciones
            <div class="row" id="contenedor">

            </div>

        @endauth
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        function goToProducto(id) {

        }
        $(document).ready(() => {
            const contenedor = $('#contenedor');
            var request = $.ajax({
                url: "{{url('Categoria-Lista')}}",
                method: "GET",
                dataType: "json"
            });
            request.done((response) =>{
                for (const responseElement of response) {
                    const url = '{{url('Tienda/Producto/Categoria')}}' +'/' + responseElement.id;
                    const columna = '<div class="col-3 m-2">' +
                        '<a class="btn btn-primary" href="'+url +'">'
                        + responseElement.nombre +' </a> </div>';
                    contenedor.append(columna);
                }
            });
        });
    </script>
@endpush
