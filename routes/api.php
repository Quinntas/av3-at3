<?php

// routes/api.php

use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PedidoController;

Route::resource('products', ProdutoController::class);
Route::resource('categories', CategoriaController::class);
Route::resource('orders', PedidoController::class);

Route::post('orders/create', [PedidoController::class, 'realizarPedido']);
Route::post('orders/fee-calculator', [PedidoController::class, 'calcularFrete']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
