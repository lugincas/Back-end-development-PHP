<?php

/* 
 * Luis Ginés Casanova de Utrilla
 * Desarrollo Web en Entorno Cliente - 2025 
 */

use App\Http\Controllers\ApiLCU\Auth\LoginController;
use App\Http\Controllers\ApiLCU\LCUMascotasControllerAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/** Respuesta por defecto cuando no hay usuario autenticado*/
Route::get('/login', function () {
    return response()->json(["mensaje"=>"Es necesaria autenticación para acceder"],401);
})->name('login');

/** Ruta que permite a un usuario autenticado ver sus datos completos (JSON) tras autenticación.
 *  HTTP GET
 *  http://localhost:.../api/user
 */
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/** Ruta que permite a un usuario hacer login vía API. 
 *  HTTP POST
 *  http://localhost:.../api/login
 */
Route::post('/login', [LoginController::class,'doLogin']);

/** Ruta que permite a un usuario hacer logout (borrar tokens) 
 *  HTTP Cualquiera
 *  http://localhost:.../api/logout
 */
Route::any('/logout', [LoginController::class,'doLogout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/** Ruta que permite a un usuario autenticado obtener un listado de sus mascotas
 *  HTTP GET
 *  http://localhost:.../api/mascotasLCU
 */
Route::middleware('auth:sanctum')->get('/mascotasLCU', [LCUMascotasControllerAPI::class, 'listarMascotasLCU']);

/** Ruta que permite a un usuario autenticado crear una nueva mascota
 *  HTTP POST
 *  http://localhost:.../api/crearmascotaLCU
 */
Route::middleware('auth:sanctum')->post('/crearmascotaLCU', [LCUMascotasControllerAPI::class, 'crearMascotaLCU']);

/* * Ruta que permite a un usuario autenticado modificar una de sus mascotas
 *  HTTP PUT
 *  http://localhost:.../api/mascotaLCU
 */
Route::middleware('auth:sanctum')->put('/mascotaLCU/{mascota}', [LCUMascotasControllerAPI::class, 'cambiarMascotaLCU'])->whereNumber('mascota'); // Controlamos que el parámetro introducido a través de la ruta sea un número

/** Ruta que permite a un usuario autenticado borrar una de sus mascotas
 *  HTTP DELETE
 *  http://localhost:.../api/mascotaLCU
 */
Route::middleware('auth:sanctum')->delete('/mascotaLCU/{mascota}', [LCUMascotasControllerAPI::class, 'borrarMascotaLCU']); // Esta vez, controlamos que el parámetro introducido a través de la ruta sea un número desde el controlador