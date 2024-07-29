<?php
namespace App\Repositories;
use App\Models\Produto;
use PDO;

Class ProdutoRepository {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function listarProdutos($limit, $offset) {
        $stmt = $this->db->prepare("SELECT * FROM produto LIMIT ? OFFSET ?");
        $stmt->bindParam(1, $limit, PDO::PARAM_INT);
        $stmt->bindParam(2, $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, Produto::class);
    }

    public function buscarProdutos($nome, $descricao) {
        $stmt = $this->db->prepare("SELECT * FROM produto WHERE nome LIKE ? OR descricao LIKE ?");
        $stmt->execute(["%$nome%", "%$descricao%"]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, Produto::class);
    }

    public function cadastrarProduto($produto) {
        $stmt = $this->db->prepare("INSERT INTO produto (nome, descricao, preco, data_validade, imagem, categoria_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$produto->nome, $produto->descricao, $produto->preco, $produto->data_validade, $produto->imagem, $produto->categoria_id]);
        return $this->db->lastInsertId();
    }

    public function editarProduto($id, $produto) {
        $stmt = $this->db->prepare("UPDATE produto SET nome = ?, descricao = ?, preco = ?, data_validade = ?, imagem = ?, categoria_id = ? WHERE id = ?");
        $stmt->execute([$produto->nome, $produto->descricao, $produto->preco, $produto->data_validade, $produto->imagem, $produto->categoria_id, $id]);
    }

    public function excluirProduto($id) {
        $stmt = $this->db->prepare("DELETE FROM produto WHERE id = ?");
        $stmt->execute([$id]);
    }
    
}