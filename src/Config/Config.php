<?php
namespace App\Config;

class Config {
    public static function getDBConnection($config) {
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset=utf8";
        try {
            $pdo = new \PDO($dsn, $config['user'], $config['pass']);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            echo "Conexão com o banco de dados estabelecido com sucesso!";
            return $pdo;
        } catch (\PDOException $e) {
            die("DB ERROR: " . $e->getMessage());
        }
    }

    public static function getDBConfig() {
        return [
            'host' => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'],
            'dbname' => $_ENV['DB_NAME'],
            'user' => $_ENV['DB_USER'],
            'pass' => $_ENV['DB_PASS'],
        ];
    }
}
