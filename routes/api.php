<?php

use App\Http\Controllers\ProdutosControlller;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\Routes;

// rotas para visualizar os registros
Route::get('/',function(){return response()->json(['Sucesso'=>true]);});
Route::get('/produtos',[ProdutosController::class, index]);
Route::get('/produtos/{codigo}',[ProdutosController::class,'show']);

Route::post('/produtos' ,[ProdutosController::class, 'store']);

Route::put('/produtos/{codigo}' ,[ProdutosController::class, 'update']);

Route::delete('/produtos/{id}' ,[ProdutosController::class, 'destroy']);
