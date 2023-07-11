<?php

use App\Http\Controllers\TarefasController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/cadastro/tarefa', [TarefasController::class, 'store']);
Route::get('/index/tarefa/{id}', [TarefasController::class, 'index']);
Route::put('/update/tarefa/{id}', [TarefasController::class, 'update']);