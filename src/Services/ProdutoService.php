<?php

namespace App\Services;

require '../../src/Models/Produto.php';
require '../../src/Repositories/ProdutoRepository.php';

use App\Repositories\ProdutoRepository;
use App\Models\Produto;

class ProdutoService {
    private $repository;

    public function __construct(ProdutoRepository $repository) {
        $this->repository = $repository;
    }

    public function listarProdutos($page, $perPage) {
        $offset = ($page - 1) * $perPage;
        return $this->repository->listarProdutos($perPage, $offset);
    }

    public function buscarProduto($nome, $descricao) {
        return $this->repository->buscarProdutos($nome, $descricao);
    }

    public function cadastrarProduto($data) {
        $produto = new Produto(
            $data['nome'],
            $data['descricao'],
            $data['preco'],
            $data['data_validade'],
            $data['imagem'],
            $data['categoria_id']
        );
        
        return $this->repository->cadastrarProduto($produto);
    }

    public function editarProduto($id, $data) {
        $produto = new Produto(
            $data['nome'],
            $data['descricao'],
            $data['preco'],
            $data['data_validade'],
            $data['imagem'],
            $data['categoria_id']
        );
        
        $this->repository->editarProduto($id, $produto);
    }

    public function excluirProduto($id) {
        $this->repository->excluirProduto($id);
    }
}