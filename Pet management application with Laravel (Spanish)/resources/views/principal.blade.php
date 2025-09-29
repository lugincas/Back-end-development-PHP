@extends('basePublica')

@section('titulo', 'Página principal (Pública)')

@section('contenido')
<div class="centrarZona">
    <H2>Bienvenido a la página principal PÚBLICA.</H2>
    @auth
    <h3 class="exito">¡Estás autenticado!</h3>
    <div>
        <A class="enlaceBoton" href="{{ route('zonaprivada') }}">Ir a tu zona privada</A>
    </div>
    @if(count($mascotasLCU) !== 0) <!-- Si hay mascotas, desplegamos el listado -->
    <br>
    <H3>Listado de mascotas públicas:</H3>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Tipo</th>
                <th>#MeGusta</th>
                <th>Propietario</th>
                <th>Votar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mascotasLCU as $mascota)
            <tr>
                <td>{{$mascota->id}}</td>
                <td>{{$mascota->nombre}}</td>
                <td>{{$mascota->descripcion}}</td>
                <td>{{$mascota->tipo}}</td>
                <td>{{$mascota->megusta}}</td>
                <td>{{$mascota->user->name}}</td>   
                <td>
                    <form method="post" action="{{ route('votomascota') }}"> <!-- Introducimos el voto mediante un formulario y un campo tipo hidden para enviar mediante POST el id de la mascota seleccionada -->
                        @csrf
                        <input type="hidden" name="mascotaId" value="{{$mascota->id}}">
                        <input class="botonVoto" type="submit" value="¡Me gusta!">
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else <!-- Si no hay mascotas, informamos de ello e instamos a que se añada alguna -->
    <H3>No hay mascotas públicas en este momento...</H3>
    <H3>¡Accede a tu zona privada y añade la primera!</H3>
    @endif
    @endauth
    @guest
    No estás autenticado, por favor ...
    <BR>
    <BR>
    <div>
        <A class="enlaceBoton" href="{{ route('formlogin') }}">Inicia sesión</A>
    </div>
    @endguest
</div>
@endsection