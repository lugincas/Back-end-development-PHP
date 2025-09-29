<?php

/* 
 * Luis Ginés Casanova de Utrilla
 * Desarrollo Web en Entorno Cliente - 2025 
 */

namespace App\Http\Controllers\ApiLCU;

use App\Http\Controllers\Controller;
use App\Models\MascotaLCU;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LCUMascotasControllerAPI extends Controller
{
    /*
     * Método público para obtener la lista de mascotas del usuario autenticado
     */
    public function listarMascotasLCU(): JsonResponse
    {
        $mascotas = MascotaLCU::where('user_id', auth()->user()->id)->get()->all(); // Almacenamos en un array todos los datos de aquellas mascotas que pertenezcan al usuario autenticado (es decir, que compartan el campo correspondiente al id del usuario) mediante una consulta con Eloquent

        for ($i = 0; $i < count($mascotas); $i++) { // Almacenamos las mascotas obtenidas por la consulta anterior en un nuevo array, pero sólo registrando los datos que nos interesan por cada mascota almacenada
            $datosMascotas[$i] = [
                'id' => $mascotas[$i]['id'],
                'nombre' => $mascotas[$i]['nombre'],
                'descripcion' => $mascotas[$i]['descripcion'],
                'tipo' => $mascotas[$i]['tipo'],
                'publica' => $mascotas[$i]['publica'],
                'megusta' => $mascotas[$i]['megusta']
            ];
        }

        return response()->json($datosMascotas); // Forzamos que el método retorne el array como documento JSON
    }

    /*
     * Método público para crear una nueva mascota
     */
    public function crearMascotaLCU(Request $request): JsonResponse
    {
        $validador = Validator::make( // Creamos un validador para los datos que vamos a recibir
            $request->all(), // Recopilamos los datos recibidos
            [ // Establecemos las reglas necesarias para cada dato
                'nombre' => 'required|string|min:1|max:50',
                'descripcion' => 'required|string|min:1|max:250',
                'tipo' => 'required|string|in:perro,gato,pajaro,dragon,conejo,hamster,tortuga,pez,serpiente',
                'publica' => 'required|string|in:Si,No'
            ],
            [ // Personalizamos los mensajes de error en función de cada regla no cumplida
                'nombre.required' => 'El nombre no se ha indicado.',
                'nombre.string' => 'El nombre debe ser una cadena de texto.',
                'nombre.min' => 'El nombre no puede quedar vacío.',
                'nombre.max' => 'El nombre es demasiado largo.',
                'descripcion.required' => 'La descripción no se ha indicado.',
                'descripcion.string' => 'La descripción debe ser una cadena de texto.',
                'descripcion.min' => 'La descripción no puede quedar vacía.',
                'descripcion.max' => 'La descripción es demasiado larga.',
                'tipo.required' => 'El tipo no se ha especificado.',
                'tipo.in' => 'El tipo no es válido.',
                'publica.required' => 'No se ha especificado la privacidad de la mascota.',
                'publica.in' => 'Responde si es pública con Sí o No, por favor.'
            ]
        );

        if ($validador->fails()) { // Si la validación no se realiza con éxito, retornamos el mensaje y nuestro array con los errores que se han encontrado, en función de las reglas de validación no cumplidas
            return response()->json(['mensaje' => 'Los datos no son válidos', 'errores' => $validador->errors()], 400);
        }

        $datos = $validador->validated(); // Si la validación se realiza con éxito, recuperamos los datos validados en forma de array con validated() y los almacenamos en una variable

        // Añadimos a nuestro array los datos que nos faltan para crear una mascota, como los 'meGusta' y el id del usuario al que pertenece
        $datos['megusta'] = 0; 
        $datos['user_id'] = $request->user()->id;

        $nuevaMascota = MascotaLCU::create( // Guardamos en una variable nuestra nueva instancia de MascotaLCU con los datos finales mediante el método create
            $datos
        );

        return response()->json(['idMascotaNueva' => $nuevaMascota['id'], 'nombreApellidos' => 'Luis Ginés Casanova de Utrilla']); // Devolvemos, en formato JSON, tanto el id de la mascota creada  como mi nombre y apellidos.
    }

    /*
     * Método público para modificar una mascota
     */
    public function cambiarMascotaLCU(int $mascota, Request $request): JsonResponse
    {

        if ($request->isJson()) { // Comprobamos si los datos recibidos son de tipo JSON

            $validador = Validator::make( // Creamos un validador para los datos que vamos a recibir
                $request->json()->all(), // Recopilamos los datos tipo JSON
                [ // Establecemos las reglas necesarias para cada dato
                    'descripcion' => 'required|string|min:1|max:250',
                    'publica' => 'required|string|in:Si,No'
                ],
                [ // Personalizamos los mensajes de error en función de cada regla no cumplida
                    'descripcion.required' => 'La descripción no se ha indicado.',
                    'descripcion.string' => 'La descripción debe ser una cadena de texto.',
                    'descripcion.min' => 'La descripción no puede quedar vacía.',
                    'descripcion.max' => 'La descripción es demasiado larga.',
                    'publica.required' => 'No se ha especificado la privacidad de la mascota.',
                    'publica.in' => 'Responde si es pública con Sí o No, por favor.'
                ]
            );

            if ($validador->fails()) { // Si la validación no se realiza con éxito, retornamos el mensaje y nuestro array con los errores que se han encontrado, en función de las reglas de validación no cumplidas
                return response()->json(['mensaje' => 'Los datos no son válidos', 'errores' => $validador->errors()], 400);
            }

            $datos = $validador->validated(); // Si la validación se realiza con éxito, recuperamos los datos validados en forma de array con validated() y los almacenamos en una variable

            $mascotaActualizar = MascotaLCU::find($mascota); // Recuperamos la mascota por su clave primaria con find. En este caso, será por el ID de la mascota que pasemos por parámetro a nuestro controlador

            if (!isset($mascota) || !isset($mascotaActualizar) || !$request->bearerToken()) { // Si la mascota no existe o el identificador no es válido, informamos de ello al usuario
                return response()->json(['mensaje' => 'La mascota no existe o el identificador no es válido.'], 404);
            } else { // Si la mascota existe y el identificador es válido, procedemos a comprobar si coinciden el id del usuario autenticado y el del propietario de la mascota

                if (auth()->user()->id === $mascotaActualizar->user_id) { // Si el id del usuario autenticado coincide con el del propietario de la mascota, llevamos a cabo la actualización
                    if ($mascotaActualizar->descripcion === $datos['descripcion'] && $mascotaActualizar->publica === $datos['publica']) { // Comprobamos si los datos a modificar son los mismos, y en ese caso se lo notificamos al usuario
                        return response()->json(['mensaje' => 'Los datos son los mismos, no se han efectuado cambios.']);
                    } else { // Si los datos no son iguales, procedemos a la actualización de los valores
                        $mascotaActualizar->descripcion = $datos['descripcion']; // Actualizamos la descripción
                        $mascotaActualizar->publica = $datos['publica']; // Actualizamos la privacidad de la mascota
                        $mascotaActualizar->save(); // Guardamos la actualización

                        return response()->json(['mensaje' => 'Se han efectuado los cambios.', 'datosModificados' => ['descripcion' => $mascotaActualizar->descripcion, 'publica' => $mascotaActualizar->publica]]); // Devolvemos el mensaje que indica que la actualización se ha llevado a cabo con éxito y los datos que acabamos de modificar
                    }
                } else { // Si el id del usuario y el del propietario de la mascota no coinciden, informamos de ello al usuario y no llevamos a cabo la actualización
                    return response()->json(['mensaje' => 'La mascota existe, pero es de otro/a usuario/a. No puedes modificar una mascota que no es tuya.'], 403);
                }
            }
        } else { // Si los datos recibidos no son de tipo JSON, indicamos al usuario que no tienen el formato deseado
            return response()->json(['mensaje' => 'Los datos no tienen el formato deseado.'], 403);
        }
    }

    /*
     * Método público para borrar una mascota
     */
    public function borrarMascotaLCU($mascota): JsonResponse
    {
        if (!is_numeric($mascota)) { // Comprobamos si el parámetro de nuestra ruta es un número, y si no lo es, se lo indicamos al usuario
            return response()->json(['mensaje' => 'No has utilizado un número.'], 400);
        }

        $mascotaActualizar = MascotaLCU::find($mascota); // Recuperamos la mascota por su clave primaria con find. En este caso, será por el ID de la mascota que pasemos por parámetro a nuestro controlador

        if (!isset($mascotaActualizar)) { // Comprobamos si la mascota recuperada existe. Si no existe, se lo indicamos al usuario
            return response()->json(['mensaje' => 'La mascota seleccionada no existe y no se puede borrar.'], 400);
        } else { // Si la mascota existe, procedemos a comprobar si el id del usuario autenticado coincide con el del propietario
            if (auth()->user()->id === $mascotaActualizar->user_id) { // Si el id del usuario autenticado coincide con el del propietario de la mascota, llevamos a cabo la eliminación

                $mascotaActualizar->delete(); // Borramos la mascota elegida y notificamos al usuario de que la eliminación se ha llevado a cabo con éxito

                return response()->json(['mensaje' => 'Se ha eliminado la mascota con éxito.']);
            }else{ // Si el id del usuario y el del propietario de la mascota no coinciden, informamos de ello al usuario y no llevamos a cabo la eliminación
                return response()->json(['mensaje' => 'La mascota existe, pero es de otro/a usuario/a. No puedes eliminar una mascota que no es tuya.'], 400);
            }
        }
        return response()->json(['mensaje' => 'Ha ocurrido un error inesperado.'], 400); // Controlamos cualquier otro tipo de error
    }
}
