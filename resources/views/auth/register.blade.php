@extends('layouts.auth-master')

@section('content')
    <form method="post" action="{{ route('register.perform') }}" id="formR">

        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <img class="mb-4" src="{!! url('images/bootstrap-logo.svg') !!}" alt="" width="72" height="57">

        <h1 class="h3 mb-3 fw-normal">Registro de usuario</h1>

        <div class="form-group form-floating mb-3">
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="correo@example.com" required="required" autofocus>
            <label for="floatingEmail">Correo</label>
            @if ($errors->has('email'))
                <span class="text-danger text-left">{{ $errors->first('email') }}</span>
            @endif
        </div>

        <div class="form-group form-floating mb-3">
            <input type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Username" required="required" autofocus>
            <label for="floatingName">Usuario</label>
            @if ($errors->has('username'))
                <span class="text-danger text-left">{{ $errors->first('username') }}</span>
            @endif
        </div>

        <div class="form-group form-floating mb-3">
            <input type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" placeholder="nombre" required="required" autofocus>
            <label for="floatingName">Nombre</label>
            @if ($errors->has('nombre'))
                <span class="text-danger text-left">{{ $errors->first('nombre') }}</span>
            @endif
        </div>

        <div class="form-group form-floating mb-3">
            <input type="text" class="form-control" name="apellido" value="{{ old('apellido') }}" placeholder="Apellido" required="required" autofocus>
            <label for="floatingName">Apellido</label>
            @if ($errors->has('apellido'))
                <span class="text-danger text-left">{{ $errors->first('apellido') }}</span>
            @endif
        </div>

        <div class="form-group form-floating mb-3">
            <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password" required="required">
            <label for="floatingPassword">Contraseña</label>
            @if ($errors->has('password'))
                <span class="text-danger text-left">{{ $errors->first('password') }}</span>
            @endif
        </div>


        <button class="w-100 btn btn-lg btn-primary" type="button" id="registerBtn">Registrar</button>

        @include('auth.partials.copy')
    </form>
@endsection
@push('scripts')
    <script>

        const registerBtn = $('#registerBtn');
        const formR = $('#formR');

        registerBtn.on('click', () => {
            Swal.fire(
                {
                    title: '¿Registrarse?',
                    icon: 'info',
                    text: '¿Está seguro que desea registrarse?',
                    showCancelButton: true
                }
            ).then(
                (value) => {
                    if (value.isConfirmed){
                        formR.submit();
                    }
                }
            );
        });

    </script>
@endpush
