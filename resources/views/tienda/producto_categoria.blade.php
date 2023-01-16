@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-5 rounded">
        @auth
            <h3>{{$categoria->nombre}}</h3>
        @endauth
    </div>
@endsection
