<?php
namespace App\Repositories;

require '../../src/Models/Produto.php';

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
        try {
            $stmt = $this->db->prepare("INSERT INTO produto (nome, descricao, preco, data_validade, imagem, categoria_id) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $produto->getNome(),
                $produto->getDescricao(),
                $produto->getPreco(),
                $produto->getDataValidade(),
                $produto->getImagem(),
                $produto->getCategoriaId()
            ]);
            return $this->db->lastInsertId();
        } catch (\PDOException $e) {
            throw new \Exception("Erro ao cadastrar produto: " . $e->getMessage());
        }
    }

    public function editarProduto($id, $produto) {
        try {
            $stmt = $this->db->prepare("UPDATE produto SET nome = ?, descricao = ?, preco = ?, data_validade = ?, imagem = ?, categoria_id = ? WHERE id = ?");
            $stmt->execute([
                $produto->getNome(),
                $produto->getDescricao(),
                $produto->getPreco(),
                $produto->getDataValidade(),
                $produto->getImagem(),
                $produto->getCategoriaId(),
                $id
            ]);
        } catch (\PDOException $e) {
            throw new \Exception("Erro ao editar produto: " . $e->getMessage());
        }
    }

    public function excluirProduto($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM produto WHERE id = ?");
            $stmt->execute([$id]);
        } catch (\PDOException $e) {
            throw new \Exception("Erro ao excluir produto: " . $e->getMessage());
        }
    }
    
}