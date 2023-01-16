@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-5 rounded">
        @auth
        <h1>
            Bienvenido {{auth()->user()->nombre}}

        </h1>
        <p class="lead">

        </p>
        @endauth

        @guest
        <h1>Bienvenido</h1>
        <p class="lead">Favor de registrarse o iniciar sesión.</p>
        @endguest
    </div>
@endsection
