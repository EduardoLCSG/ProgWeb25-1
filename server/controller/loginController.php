<?php

// include_once __DIR__ . '/../config/database/database.php';
require_once __DIR__ . '/../config/database/database.php';

class LoginController
{
    public function index()
    {
        // Apenas define o caminho da view que o layout irá carregar
        $view = ROOT_PATH . '/public/pages/login.php';

        // Chama o layout principal, que por sua vez carregará a $view
        require_once ROOT_PATH . '/public/components/layout.php';
    }

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
