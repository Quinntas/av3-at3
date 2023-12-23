<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        return response()->json(['categorias' => $categorias], 200);
    }

    public function show($id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(['categoria' => $categoria], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nome' => 'required|unique:categorias,nome'
        ]);

        $categoria = Categoria::create([
            'nome' => $request->input('nome')
        ]);

        return response()->json(['message' => 'Created ', 'categoria' => $categoria], 201);
    }

    public function update(Request $request, $id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $this->validate($request, [
            'nome' => 'required|unique:categorias,nome,'.$id
        ]);

        $categoria->nome = $request->input('nome');
        $categoria->save();

        return response()->json(['message' => 'Updated', 'categoria' => $categoria], 200);
    }

    public function destroy($id)
    {
        $categoria = Categoria::find($id);
        if (!$categoria) {
            return response()->json(['message' => 'Not found'], 404);
        }
        $categoria->delete();
        return response()->json(['message' => 'Removed'], 200);
    }
}

