<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido; // Importe o modelo do Pedido
use App\Models\Produto; // Importe o modelo do Produto
use BetoSouza\PhpCorreios\Frete;

class PedidoController extends Controller
{
    public function realizarPedido(Request $request)
{
    if (!$request->has('produtos') || empty($request->produtos)) {
        return response()->json(['message' => 'Not found'], 400);
    }

    $novoPedido = Pedido::create([
        'codigo_pedido' => uniqid(), 
        'total' => 0, 
        'status' => 'pendente',
    ]);

    foreach ($request->produtos as $produto) {
        $produtoDB = Produto::find($produto['produto_id']);
        
        if (!$produtoDB || $produtoDB->quantidade_estoque < $produto['quantidade']) {
            return response()->json(['message' => 'Produto não disponível em estoque'], 400);
        }

        $subtotal = $produtoDB->preco * $produto['quantidade'];
        $novoPedido->produtos()->attach($produto['produto_id'], [
            'quantidade' => $produto['quantidade'],
            'preco_unitario' => $produtoDB->preco,
            'subtotal' => $subtotal,
        ]);

        $produtoDB->quantidade_estoque -= $produto['quantidade'];
        $produtoDB->save();

        $novoPedido->total += $subtotal;
    }

    $novoPedido->save();

    return response()->json(['message' => 'Success', 'pedido' => $novoPedido], 201);
     
    
    
}

}
