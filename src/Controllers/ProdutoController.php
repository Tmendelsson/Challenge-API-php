<?php

namespace App\Controllers;

require '../../src/Services/ProdutoService.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Services\ProdutoService;
use App\Models\Produto;

class ProdutoController {
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
        
        try {
            $produto = new Produto(
                $data["nome"],
                $data["descricao"],
                $data["preco"],
                $data["data_validade"],
                $data["imagem"],
                $data["categoria_id"]
            );
            $id = $this->service->cadastrarProduto($produto);
            $response->getBody()->write(json_encode([
                'message' => 'Produto cadastrado com sucesso!',
                'id' => $id
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode([
                'error' => $e->getMessage()
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }

    public function editarProduto(Request $request, Response $response, $args) {
        $id = $args['id'];
        $data = $request->getParsedBody();
        
        try {
            $produto = new Produto(
                $data['nome'],
                $data['descricao'],
                $data['preco'],
                $data['data_validade'],
                $data['imagem'],
                $data['categoria_id']
            );
            $this->service->editarProduto($id, $produto);
            $response->getBody()->write(json_encode([
                'message' => 'Produto atualizado com sucesso!'
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode([
                'error' => $e->getMessage()
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }

    public function excluirProduto(Request $request, Response $response, $args) {
        $id = $args['id'];
        
        try {
            $this->service->excluirProduto($id);
            $response->getBody()->write(json_encode([
                'message' => 'Produto excluído com sucesso!'
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode([
                'error' => $e->getMessage()
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }

    public function buscarProduto(Request $request, Response $response, $args) {
        $nome = $request->getQueryParams()["nome"] ?? "";
        $descricao = $request->getQueryParams()["descricao"] ?? "";
        $produtos = $this->service->buscarProduto($nome, $descricao);
        $response->getBody()->write(json_encode($produtos));
        return $response->withHeader("Content-Type", "application/json");
    }
}