<?php
require __DIR__.'/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use Dotenv\Dotenv;
use App\Repositories\ProdutoRepository;
use App\Services\ProdutoService;
use App\Controllers\ProdutoController;
use PDO;
use src\Config\Config;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db = getDBConnection([
    'host'=>getenv('DB_HOST'),
    'port'=>getenv('DB_PORT'),
    'dbname'=>getenv('DB_NAME'),
    'user'=>getenv('DB_USER'),
    'pass'=>getenv('DB_PASS')
]);

$db->exec("
CREATE TABLE IF NOT EXISTS categoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS produto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    descricao VARCHAR(200) NOT NULL,
    preco DOUBLE NOT NULL CHECK (preco > 0),
    data_validade DATE NOT NULL CHECK (data_validade >= CURDATE()),
    imagem VARCHAR(255) NOT NULL,
    categoria_id INT,
    FOREIGN KEY (categoria_id) REFERENCES categoria(id)
);
");

$produtoRepository = new ProdutoRepository($db);
$produtoService = new ProdutoService($produtoRepository);
$produtoController = new ProdutoController($produtoService);

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

$app->group('/api', function () use ($produtoController) {
    $this->get('/produtos', [$produtoController, 'listarProdutos']);
    $this->post('/produtos', [$produtoController, 'cadastrarProduto']);
    $this->put('/produtos/{id}', [$produtoController, 'editarProduto']);
    $this->delete('/produtos/{id}', [$produtoController, 'excluirProduto']);
    $this->get('/produtos/busca', [$produtoController, 'buscarProduto']);
});

$app->run();