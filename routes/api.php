<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\penggunaController;
use App\Http\Controllers\artikelController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('register', [penggunaController::class, 'register']);
    Route::post('login', [penggunaController::class, 'login']);
    Route::post('logout', [penggunaController::class, 'logout']);
    Route::post('refresh', [penggunaController::class, 'refresh']);
    Route::post('me', [penggunaController::class, 'me']);
    Route::put('update', [penggunaController::class, 'updateAkun']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'artikel'
], function ($router) {
    Route::get('/', [ArtikelController::class, 'index']);
    Route::get('/{id}', [ArtikelController::class, 'show']);
    Route::get('/user', [ArtikelController::class, 'getDataByUser']);
    Route::post('/', [ArtikelController::class, 'store']);
    Route::put('/{id}', [ArtikelController::class, 'update']);
    Route::delete('/{id}', [ArtikelController::class, 'destroy']);
});
