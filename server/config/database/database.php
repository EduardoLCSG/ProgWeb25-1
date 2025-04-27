<?php
require_once __DIR__ . '/../env.php';

class Database
{
    public function connect(): PDO {
            loadEnv();
            
            $host = getenv('DB_HOST');
            $port = getenv('DB_PORT');
            $dbname = getenv('DB_NAME');
            $user = getenv('DB_USER');
            $password = getenv('DB_PASSWORD');
            
            try {
                $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $pdo;
            } catch (PDOException $e) {
                die("Erro ao conectar ao banco de dados: " . $e->getMessage());
            }
    }
}

