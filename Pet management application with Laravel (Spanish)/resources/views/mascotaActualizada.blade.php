@extends('basePublica')

@section('titulo', '¡Mascota añadida!')

@section('contenido')

@if ($mascotaActualizadaLCU->user->name !== auth()->user()->name) <!-- Si la mascota valorada no pertenece al usuario autenticado, se informa de la operación -->
    <h2>¡<span class="exito">{{$mascotaActualizadaLCU->nombre}}</span> ha recibido un like!</h2>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Tipo</th>
                <th>#Me Gustas</th>
                <th>Propietario</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{$mascotaActualizadaLCU->id}}</td>
                <td>{{$mascotaActualizadaLCU->nombre}}</td>
                <td>{{$mascotaActualizadaLCU->descripcion}}</td>
                <td>{{$mascotaActualizadaLCU->tipo}}</td>
                <td class="exito">{{$mascotaActualizadaLCU->megusta}}</td>
                <td>{{$mascotaActualizadaLCU->user->name}}</td>
            </tr> 
        </tbody>
    </table>
    <BR>
@else <!-- Si la mascota valorada pertenece al usuario autenticado, se le informa -->
<h2><span class="error">{{$mascotaActualizadaLCU->nombre}}</span> no puede recibir el like porque es una de tus mascotas... <br>
¡Por favor, valora la mascota de otro/a usuario/a!</h2>
@endif
<A class="enlaceBoton" href="{{ route('zonapublica') }}">Volver a la zona pública</A>
    
@endsection