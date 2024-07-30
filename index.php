<?php
require __DIR__ . '/vendor/autoload.php';
require './src/Config/Config.php';
require './src/Repositories/ProdutoRepository.php';
require './src/Services/ProdutoService.php';
require './src/Controllers/ProdutoController.php';

use Slim\Factory\AppFactory;
use Dotenv\Dotenv;
use App\Repositories\ProdutoRepository;
use App\Services\ProdutoService;
use App\Controllers\ProdutoController;
use App\Config\Config;

// Carregar variáveis do ambiente
$dotenv = Dotenv::createImmutable(__DIR__ . '/');
$dotenv->load();

$dbConfig = Config::getDBConfig();
$db = Config::getDBConnection($dbConfig);

// Criação das tabelas
$db->exec("
CREATE TABLE IF NOT EXISTS categoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS produto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    descricao VARCHAR(200) NOT NULL,
    preco DOUBLE NOT NULL,
    data_validade DATE NOT NULL,
    imagem VARCHAR(255) NOT NULL,
    categoria_id INT,
    FOREIGN KEY (categoria_id) REFERENCES categoria(id)
);
");

// Criar a aplicação Slim
$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);

// Iniciar Repositórios, Serviços e Controladores
$produtoRepository = new ProdutoRepository($db);
$produtoService = new ProdutoService($produtoRepository);
$produtoController = new ProdutoController($produtoService);

// Definir as rotas
$app->get('/test', function ($request, $response, $args) {
    $response->getBody()->write(" Rota de teste funcionando!");
    return $response;
});

$app->group('/api', function ($group) use ($produtoController) {
    $group->get('/produtos', [$produtoController, 'listarProdutos']);
    $group->post('/produtos', [$produtoController, 'cadastrarProduto']);
    $group->put('/produtos/{id}', [$produtoController, 'editarProduto']);
    $group->delete('/produtos/{id}', [$produtoController, 'excluirProduto']);
    $group->get('/produtos/busca', [$produtoController, 'buscarProduto']);
});

$app->run();
