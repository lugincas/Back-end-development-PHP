@extends('basePrivada')

@section('titulo', 'Página principal (Privada)')

@section('contenido')

@auth
<br>
<div>
    <A class="enlaceBoton" href="{{ route('zonapublica') }}">Ir a la zona pública</A>
    <A class="enlaceBotonLogout" href="{{ route('logout') }}">Cerrar sesión</A>
</div>
<br>
<H2>¡Hola<span class="exito"> {{ Auth::user()->name}} </span>! Bienvenido/a a la página principal de la zona PRIVADA.</H2>
@if(count($mascotasLCU) !== 0) <!-- Si hay mascotas, desplegamos el listado -->
<H2>¡Tus mascotas!</H2>
<table>
    <thead>
        <tr>
            <th class="celdaHeadPrivada">Id</th>
            <th class="celdaHeadPrivada">Nombre</th>
            <th class="celdaHeadPrivada">Descripcion</th>
            <th class="celdaHeadPrivada">Tipo</th>
            <th class="celdaHeadPrivada">#Me Gustas</th>
            <th class="celdaHeadPrivada">Propietario</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($mascotasLCU as $mascota)
        <tr>
            <td class="celdaPrivada">{{$mascota->id}}</td>
            <td class="celdaPrivada">{{$mascota->nombre}}</td>
            <td class="celdaPrivada">{{$mascota->descripcion}}</td>
            <td class="celdaPrivada">{{$mascota->tipo}}</td>
            <td class="celdaPrivada">{{$mascota->megusta}}</td>
            <td class="celdaPrivada">{{$mascota->user->name}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<br>
@else <!-- Si no hay mascotas, avisamos de ello -->
<H2>¡No tienes mascotas! Añade tu primera mascota pulsando en el botón de abajo:</H2>
@endif
<A class="enlaceBotonPrivado" href="{{ route('formmascotaLCU') }}">¡Añade una nueva mascota!</A>

@endauth

@endsection