@extends('basePrivada')

@section('titulo', 'Formulario para añadir mascotas')

@section('contenido')
<BR>
<A class="enlaceBotonPrivado" href="{{ route('zonaprivada') }}">Volver a la zona privada</A><BR>

    <h2>¡Añade una nueva mascota!</h2>
    @if ($errors->any())
    <H3>Se han producido errores en el formulario:</H3>
    <UL>
        @foreach ($errors->all() as $error)
        <LI>{{ $error }}</LI>
        @endforeach
    </UL>
    @endif
    <div>
        <fieldset class="estiloFormulario">
            <form method='post' action='{{ route("nuevamascotaLCU") }}'>
                @csrf
                <label class="tituloFormulario" for="nombre">Nombre de la mascota</label><br />
                <input type='text' name='nombre' required='required'><br />
                <hr>
                <label for="descripcion">Descripción</label>
                <br />
                <textarea name='descripcion' rows="5" cols="40"
                    placeholder="Escribe aquí la descripción de tu mascota..." required='required'></textarea><br />
                <hr>
                <label for="tipo">Tipo de mascota</label><br />
                <input type="radio" name="tipo" value="perro" />Perro
                <input type="radio" name="tipo" value="gato" />Gato
                <input type="radio" name="tipo" value="pajaro" />Pájaro<br>
                <input type="radio" name="tipo" value="dragon" />Dragón
                <input type="radio" name="tipo" value="conejo" />Conejo
                <input type="radio" name="tipo" value="hamster" />Hámster<br>
                <input type="radio" name="tipo" value="tortuga" />Tortuga
                <input type="radio" name="tipo" value="pez" />Pez
                <input type="radio" name="tipo" value="serpiente" />Serpiente
                <br />
                <hr>
                <label for="publica">¿Pública?</label><br />
                <input type="radio" name="publica" value="Si" />Sí
                <input type="radio" name="publica" value="No" />No
                <br />
                <br />
                <input class="enlaceBoton" type='submit' value='¡Añadir!'>
            </form>

        </fieldset>
    </div>

@endsection