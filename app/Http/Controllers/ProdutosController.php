<?php

namespace App\Http\Controllers;

use App\Models\Produtos;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ProdutosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Buscando todos os registros do modelo Produtos
        $registros = Produtos::all();

        // Contando o número de registros
        $contador = $registros->count();

        // Verificando se há registros
        if ($contador > 0) {
            return response()->json([
                'success' => true,
                'message' => 'Produtos encontrados com sucesso',
                'data' => $registros,
                'total' => $contador
            ], 200);
        }

        // Caso não haja registros, retornar 404
        return response()->json([
            'success' => false,
            'message' => 'Nenhum produto encontrado',
        ], 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação dos dados recebidos
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'marca' => 'required',
            'preco' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Registros inválidos',
                'errors' => $validator->errors()
            ], 400);
        }

        // Criando um registro no banco de dados
        $registro = Produtos::create($request->all());

        if ($registro) {
            return response()->json([
                'success' => true,
                'message'=> 'Produto cadastrado com sucesso!',
                'data' => $registro
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao cadastrar o produto'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Buscando um produto pelo ID
        $registro = Produtos::find($id);

        // Verificando se o produto foi encontrado
        if ($registro) {
            return response()->json([
                'success' => true,
                'message' => 'Produto localizado com sucesso!',
                'data' => $registro
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Produto não localizado.',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'marca' => 'required',
            'preco' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Registros inválidos',
                'errors' => $validator->errors()
            ], 400);
        }

        // Encontrando o registro no banco
        $registroBanco = Produtos::find($id);

        if (!$registroBanco) {
            return response()->json([
                'success' => false,
                'message' => 'Produto não encontrado'
            ], 404);
        }

        // Atualizando os dados
        $registroBanco->nome = $request->nome;
        $registroBanco->marca = $request->marca;
        $registroBanco->preco = $request->preco;

        // Salvando as alterações
        if ($registroBanco->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Produto atualizado com sucesso!',
                'data' => $registroBanco
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar o produto'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Encontrando um produto no banco
        $registro = Produtos::find($id);

        if (!$registro) {
            return response()->json([
                'success' => false,
                'message' => 'Produto não encontrado'
            ], 404);
        }

        // Deletando o produto
        if ($registro->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Produto deletado com sucesso'
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Erro ao deletar o produto'
        ], 500);
    }
}
