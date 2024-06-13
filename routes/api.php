<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UsuariosController,
    PetsController,
    ServicosController,
    AgendaController
};

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'V1/api-petshop'], function () {
    Route::group(['prefix' => 'usuarios'], function () {
        Route::post('login', [UsuariosController::class, 'login']);
        Route::post('inserir', [UsuariosController::class, 'store']);
        Route::middleware('jwt.auth')->group(function () {
            Route::get('data', [UsuariosController::class, 'getData']);
            Route::delete('/{id}', [UsuariosController::class, 'delete']);
            Route::put('/{id}', [UsuariosController::class, 'update']);
            Route::get('listar', [UsuariosController::class, 'index']);
        });
    });

    Route::group(['prefix' => 'pets'], function () {
        Route::post('inserir', [PetsController::class, 'store']);
        Route::delete('/{id}', [PetsController::class, 'delete']);
        Route::put('/{id}', [PetsController::class, 'update']);
        Route::get('listar', [PetsController::class, 'index']);
        Route::middleware('jwt.auth')->group(function () {
            Route::get('meus-pets', [PetsController::class, 'getPetsByUser']);
        });
    });

    Route::group(['prefix' => 'servicos'], function () {
        Route::post('inserir', [ServicosController::class, 'store']);
        Route::delete('/{id}', [ServicosController::class, 'delete']);
        Route::put('/{id}', [ServicosController::class, 'update']);
        Route::get('listar', [ServicosController::class, 'index']);
    });
    Route::group(['prefix' => 'agenda'], function () {
        Route::post('inserirServicosAgenda', [AgendaController::class, 'storeServicosAgenda']);
        Route::post('inserir', [AgendaController::class, 'store']);
        Route::delete('/{id}', [AgendaController::class, 'delete']);
        Route::put('/{id}', [AgendaController::class, 'update']);
        Route::get('listar', [AgendaController::class, 'index']);
        Route::middleware('jwt.auth')->group(function () {
            Route::get('listByUser', [AgendaController::class, 'getAgendamentosByUser']);
        });
    });
});
