<?php

namespace App\Services;

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

    public function cadastrarProduto($produto) {
        return $this->repository->cadastrarProduto($produto);
    }

    public function editarProduto($id, $produto) {
        $this->repository->editarProduto($id, $produto);
    }
    public function excluirProduto($id) {
        $this->repository->excluirProduto($id);
    }

}