<?php

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__."/../");
$dotenv->load();

$dbConfig = [
    'host'=>$_ENV['DB_HOST'],
    'port'=>$_ENV['DB_PORT'],
    'dbname'=>$_ENV['DB_NAME'],
    'user'=>$_ENV['DB_USER'],
    'pass'=>$_ENV['DB_PASS'],
];

function getDBConnection($config) {
    $dsn="mysql:host={$config['host']};port={$config['host']};dbname={$config['dbname']}";
    try {
        $pdo = new PDO($dsn, $config['user'], $config['pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("DB ERROR: ". $e->getMessage());
    }
}