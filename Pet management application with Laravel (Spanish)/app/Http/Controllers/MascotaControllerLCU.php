<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MascotaLCU;

class MascotaControllerLCU extends Controller
{
    // Mostrar el formulario de inicio de sesión autenticada
    public function mostrarFormularioCrearMascotasLCU()
    {
        return view('privada.formmascotaLCU');
    }

    public function validadorDatosLCU(Request $request)
    {
        $datosvalidados = $request->validate([ // Validamos los datos
            'nombre' => 'required|string|min:4|max:50',
            'descripcion' => 'required|string|max:250',
            'tipo' => 'required|string|in:perro,gato,pajaro,dragon,conejo,hamster,tortuga,pez,serpiente',
            'publica' => 'required|string|in:Si,No'
        ]);

        if ($datosvalidados) { // Si se han validado correctamente, guardamos los datos en una nueva instancia de la base de datos
            
            $nuevaMascota = new MascotaLCU();
            $nuevaMascota->nombre = $datosvalidados['nombre'];
            $nuevaMascota->descripcion = $datosvalidados['descripcion'];
            $nuevaMascota->tipo = $datosvalidados['tipo'];
            $nuevaMascota->publica = $datosvalidados['publica'];
            $nuevaMascota->megusta = 0;
            $nuevaMascota->user_id = auth()->user()->id;
            $nuevaMascota->save();
        }
        return view('privada.mascotaniadidaLCU', ['nuevaMascotaLCU' => $nuevaMascota]); // Devolvemos la vista y los datos que hemos almacenado en una variable
    }

    public function votarMascotaLCU(Request $request)
    { // Función para recibir el voto de la mascota y actualizar el campo de Me Gusta
        $mascotaActualizar = MascotaLCU::find($request->mascotaId); // Almacenamos en una variable la mascota que tiene el id que hemos recibido mediante la Request

        if (auth()->user()->id != $mascotaActualizar->user_id) { // Si el id del usuario autenticado no coincide con el del propietario de la mascota, llevamos a cabo la actualización
            
            $mascotaActualizar->megusta = $mascotaActualizar->megusta +1; // Actualizamos el valor
            $mascotaActualizar ->save(); // Lo guardamos

            return view('mascotaActualizada', ['mascotaActualizadaLCU' => $mascotaActualizar]);// Devolvemos la vista y los datos que hemos almacenado en una variable
        } else { // Si el id del usuario autenticado y el del propietario de la mascota votada coinciden, no realizamos ninguna operación pero devolvemos la vista y los datos almacenados en la variable para informar al respecto
            return view('mascotaActualizada', ['mascotaActualizadaLCU' => $mascotaActualizar]);
        }

    }
}
