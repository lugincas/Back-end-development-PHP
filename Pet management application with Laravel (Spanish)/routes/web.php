<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Models\MascotaLCU;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MascotaControllerLCU;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

//Ruta a la zona pública (simplemente accediendo a / vía GET)
Route::get('/', function () {
    $mascotas = MascotaLCU::where('publica','Si')->get()->all();
    
    return view('principal',['mascotasLCU'=>$mascotas]);
})->name('zonapublica');

//Ruta a la zona privada (simplemente accediendo a /zonaprivada vía GET)
Route::get('/zonaprivada', function () {
    $usuarioAutenticado = auth()->user();
    $mascotas = $usuarioAutenticado->mascotas;
     
    return view('privada.principal',['mascotasLCU'=>$mascotas]);
})->middleware('auth')->name('zonaprivada');

//Creamos una ruta nombrada (formlogin) tipo GET a '/login' que mostrará el formulario
Route::get('/login', [LoginController::class, 'mostrarFormularioLoginLCU'])->name('formlogin');
//Creamos una ruta nombrada (login) tipo POST a '/login' que procesará el formulario
Route::post('/login', [LoginController::class, 'loginLCU'])->name('login');
//Creamos una ruta nombrada (logout) tipo POST a '/logout' que cerrará la sesión
Route::get('/logout', [LoginController::class, 'logoutLCU'])->name('logout');

Route::get('/mascota/nueva', [MascotaControllerLCU::class, 'mostrarFormularioCrearMascotasLCU'])->middleware('auth')->name('formmascotaLCU');

Route::post('/mascota/nueva', [MascotaControllerLCU::class, 'validadorDatosLCU'])->middleware('auth')->name('nuevamascotaLCU');

// Ruta tipo POST para la función del controlador encargada de votar mascotas, a '/votomascota'
Route::post('/voto', [MascotaControllerLCU::class, 'votarMascotaLCU'])->name('votomascota');

