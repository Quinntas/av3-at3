<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::all();
        return response()->json(['produtos' => $produtos], 200);
    }

    public function show($id)
    {
        $produto = Produto::find($id);

        if (!$produto) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['produto' => $produto], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nome' => 'required',
            'preco' => 'required|numeric|min:0',
            
        ]);

        $produto = Produto::create([
            'nome' => $request->input('nome'),
            'preco' => $request->input('preco'),
            
        ]);

        return response()->json(['message' => 'Created', 'produto' => $produto], 201);
    }

    
    public function update(Request $request, $id)
    {
        $produto = Produto::find($id);

        if (!$produto) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $this->validate($request, [
            'nome' => 'required',
            'preco' => 'required|numeric|min:0',
           
        ]);

        $produto->nome = $request->input('nome');
        $produto->preco = $request->input('preco');
        
        $produto->save();

        return response()->json(['message' => 'Updated', 'produto' => $produto], 200);
    }

    
    public function destroy($id)
    {
        $produto = Produto::find($id);

        if (!$produto) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $produto->delete();

        return response()->json(['message' => 'Removed'], 200);
    }
}
