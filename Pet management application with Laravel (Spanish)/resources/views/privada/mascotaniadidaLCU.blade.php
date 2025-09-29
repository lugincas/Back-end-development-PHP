@extends('basePrivada')

@section('titulo', '¡Mascota añadida!')

@section('contenido')

    <h2>¡La mascota <span class="exito">{{$nuevaMascotaLCU->nombre}}</span> se ha añadido con éxito! || <span class="exito">Luis Ginés Casanova de Utrilla</span></h2>
    <br>
    <A class="enlaceBoton" href="{{ route('formmascotaLCU') }}">¡Añade otra mascota!</A>
    <br>
    <A class="enlaceBotonPrivado" href="{{ route('zonaprivada') }}">Volver a la zona privada</A>

@endsection