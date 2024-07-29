<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Services\ProdutoService;
use App\Models\Produto;

class ProdutoController{
    private $service;
    public function __construct(ProdutoService $service) {
        $this->service = $service;
    }
    public function listarProdutos(Request $request, Response $response, $args) {
        $page = $request->getQueryParams()["page"] ?? 1;
        $perPage = $request->getQueryParams()["perPage"] ?? 10;
        $produtos = $this->service->listarProdutos($page, $perPage);
        $response->getBody()->write(json_encode($produtos));
        return $response->withHeader("Content-Type", "application/json");
    }

    public function cadastrarProduto(Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $produto = new Produto();
        $produto->nome = $data["nome"];
        $produto->descricao = $data["descricao"];
        $produto->preco = $data["preco"];
        $produto->data_validade = $data["data_validade"];
        $produto->imagem = $data["imagem"];
        $produto->categoria_id = $data["categoria_id"];
        $id = $this->service->cadastrarProduto($produto);
        $response->getBody()->write(json_encode(['id' => $id]));
        return $response->withHeader('Content-Type', 'application/json');
    }
    public function editarProduto(Request $request, Response $response, $args) {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $produto = new Produto();
        $produto->nome = $data['nome'];
        $produto->descricao = $data['descricao'];
        $produto->preco = $data['preco'];
        $produto->data_validade = $data['data_validade'];
        $produto->imagem = $data['imagem'];
        $produto->categoria_id = $data['categoria_id'];
        $this->service->editarProduto($id, $produto);
        $response->getBody()->write(json_encode(['message' => 'Produto atualizado com sucesso!']));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function excluirProduto(Request $request, Response $response, $args) {
        $id = $args['id'];
        $this->service->excluirProduto($id);
        $response->getBody()->write(json_encode(['message' => 'Produto excluído com sucesso!']));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function buscarProduto(Request $request, Response $response, $args) {
        $nome = $request->getQueryParams()["nome"] ?? "";
        $descricao = $request->getQueryParams()["descricao"] ?? "";
        $produtos = $this->service->buscarProduto($nome, $descricao);
        $response->getBody()->write(json_encode($produtos));
        return $response->withHeader("Content-Type", "application/json");
    }


}