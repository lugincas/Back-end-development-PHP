@extends('basePublica')

@section('titulo', 'Inicio de sesión')

@section('contenido')
    @auth

    <h1 class="exito">¡Ya has iniciado sesión!</h1>
    <a class="enlaceBoton" href="{{ route('zonaprivada') }}">Ir a zona privada</a>

    @endauth

    @guest
    <h2>Iniciar sesión</h2>
    @if ($errors->any())
    <div style="color: red;">
        <H2>ERRORES:</H2>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Formulario de inicio de sesión -->
    <fieldset class="estiloLogin">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <label for="email">Correo Electrónico</label>
            <br>
            <input type="email" id="email" name="email" value="{{ old('email') }}">
            <hr>
            <label for="password">Contraseña</label>
            <br>
            <input type="password" id="password" name="password"><hr>
            <input class="enlaceBoton" type="submit" value="Login">
        </form>
    </fieldset>
    @endguest

@endsection