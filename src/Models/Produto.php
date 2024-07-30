<?php
namespace App\Models;

use DateTime;
use Exception;

class Produto {
    private $id;
    private $nome;
    private $descricao;
    private $preco;
    private $data_validade;
    private $imagem;
    private $categoria_id;

    public function __construct($nome, $descricao, $preco, $data_validade, $imagem, $categoria_id) {
        $this->setNome($nome);
        $this->setDescricao($descricao);
        $this->setPreco($preco);
        $this->setDataValidade($data_validade);
        $this->setImagem($imagem);
        $this->setCategoriaId($categoria_id);
    }

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        if (strlen($nome) > 50) {
            throw new Exception("Nome não pode ter mais de 50 caracteres.");
        }
        $this->nome = $nome;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setDescricao($descricao) {
        if (strlen($descricao) > 200) {
            throw new Exception("Descrição não pode ter mais de 200 caracteres.");
        }
        $this->descricao = $descricao;
    }

    public function getPreco() {
        return $this->preco;
    }

    public function setPreco($preco) {
        if ($preco <= 0) {
            throw new Exception("Preço deve ser um valor positivo.");
        }
        $this->preco = $preco;
    }

    public function getDataValidade() {
        return $this->data_validade;
    }

    public function setDataValidade($data_validade) {
        $data = new DateTime($data_validade);
        $hoje = new DateTime();
        if ($data < $hoje) {
            throw new Exception("Data de validade não pode ser anterior à data atual.");
        }
        $this->data_validade = $data_validade;
    }

    public function getImagem() {
        return $this->imagem;
    }

    public function setImagem($imagem) {
        $this->imagem = $imagem;
    }

    public function getCategoriaId() {
        return $this->categoria_id;
    }

    public function setCategoriaId($categoria_id) {
        $this->categoria_id = $categoria_id;
    }
}
