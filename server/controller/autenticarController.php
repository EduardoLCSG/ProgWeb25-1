<?php

// include_once __DIR__ . '/../config/database/database.php';
require_once __DIR__ . '/../config/database/database.php';

class autenticarController
{
    private $conn;

    public function __construct()
    {
        $objDb = new Database;
        $this->conn = $objDb->connect();
    }

    public function autenticarSenha($loginEmail, $loginSenha): bool
    {
        session_start();
        try {
            $sql = "SELECT id, nome_completo, email, senha FROM usuarios WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":email", $loginEmail);
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar a senha e autenticar
            // Verifica se o usuário existe E se a senha está correta
            if ($usuario && password_verify($loginSenha, $usuario['senha'])) {
                // Autenticação bem-sucedida!

                // Armazena os dados do usuário na sessão
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome_completo'];
                $_SESSION['usuario_email'] = $usuario['email'];
                $_SESSION['autenticado'] = true;


                // Redireciona para a página home
                echo "
    <script>
        alert('Login realizado com sucesso!');
        
    </script>
    ";
                return true;
            } else {
                // Falha na autenticação

                // Redireciona de volta para a página de login com uma mensagem de erro
                echo "
    <script>
        alert('Email ou senha inválidos. Por favor, tente novamente.');
        window.location.href = '/login';
    </script>
    ";
                return false;
            }














            $db = $this->conn->prepare($sql);
            $db->bindParam(":email", $loginEmail);
            $db->bindParam(":senha", $loginSenha);
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
