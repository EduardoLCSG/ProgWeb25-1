<?php

// include_once __DIR__ . '/../config/database/database.php';
require_once __DIR__ . '/../config/database/database.php';

class LoginController
{
    private $conn;

    public function __construct()
    {
        $objDb = new Database;
        $this->conn = $objDb->connect();
    }

    public function ValidaSenha($email, $nome): bool
    {   
        try {
            $sql = "SELECT * FROM usuarios WHERE email = :email AND nome = :nome";
            $db = $this->conn->prepare($sql);
            $db->bindParam(":email", $email);
            $db->bindParam(":nome", $nome);
            $db->execute();
            $users = $db->fetchAll(PDO::FETCH_ASSOC);
            var_dump($users);

            if ($users) {
                session_start();
                $_SESSION["id_usuario"] = $users[0]["id"];
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 0, 'message' => 'Erro ao validar usuário: ' . $e->getMessage()]);
            return false;
        }
    }
}
