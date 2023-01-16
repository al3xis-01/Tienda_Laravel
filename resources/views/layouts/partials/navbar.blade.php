<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{url('/')}}">
            <i class="fa fa-home"></i>
            Inicio
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @auth
                @php($Tipo = auth()->user()->tipo)

                @switch($Tipo)
                    @case('ADMIN')
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Home</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Catálogos
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="{{route('Categoria.index')}}">Categorías</a></li>
                                    <li><a class="dropdown-item" href="{{route('Proveedor.index')}}">Proveedores</a></li>
                                    <li><a class="dropdown-item" href="{{route('Producto.index')}}">Productos</a></li>
                                    <li><a class="dropdown-item" href="{{route('Usuario.index')}}">Usuarios</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page"
                                   href="{{ route('AltaProducto.index') }}">
                                    <i class="fa fa-row"></i>
                                    Alta de productos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page"
                                   href="{{ route('AltaProducto.index') }}">
                                    <i class="fa fa-row"></i>
                                    Inventario de productos
                                </a>
                            </li>

                        </ul>
                        @break
                    @case('USER')
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page"
                                   href="{{ route('Tienda.index') }}">
                                    <i class="fa fa-store"></i>
                                    Tienda
                                </a>
                            </li>
                        </ul>
                        @break
                @endswitch

                {{auth()->user()->nombre}}
                <div class="text-end">
                    <a href="{{ route('logout.perform') }}" class="btn btn-outline-light me-2">Cerrar Sesión</a>
                </div>
            @endauth

            @guest
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    </ul>
                <div class="text-end">
                    <a href="{{ route('login.perform') }}" class="btn btn-outline-light me-2">Iniciar Sesión</a>
                    <a href="{{ route('register.perform') }}" class="btn btn-warning">Registrarse</a>
                </div>
            @endguest
        </div>
    </div>
</nav>
