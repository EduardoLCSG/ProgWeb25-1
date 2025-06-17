<?php

// include_once __DIR__ . '/../config/database/database.php';
require_once __DIR__ . '/../config/database/database.php';

class UsuarioController
{
    private $conn;

    public function __construct()
    {
        $objDb = new Database;
        $this->conn = $objDb->connect();
    }

    public function createUser($nome, $email, $senha, $confirmar_senha, $termos)
    {
        try {
            if (empty($nome) || empty($email) || empty($senha) || empty($confirmar_senha) || !isset($termos)) {
                echo "
    <script>
        alert('Preencha todos os campos obrigatórios e aceite os termos de uso.');
        window.location.href = '/login';
    </script>
    ";
                return;
            }

            if ($senha !== $confirmar_senha) {
                echo "
    <script>
        alert('As senhas não coincidem. Por favor, tente novamente.');
        window.location.href = '/login';
    </script>
    ";
                return;
            }
            // Hashear a senha
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            // Prepara a consulta SQL para inserir o novo usuário
            $sql = "INSERT INTO usuarios (nome_completo, email, senha) VALUES (:nome, :email, :senha)";
            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':nome' => $nome,
                ':email' => $email,
                ':senha' => $senhaHash
            ]);

            // Gera um script JavaScript para o alerta e redirecionamento
            echo "
    <script>
        alert('Usuário cadastrado com sucesso!');
        window.location.href = '/login';
    </script>
    ";
        } catch (PDOException $e) {
            // Tratar erros com alertas JavaScript

            if ($e->getCode() == 23505) { // Código de violação de unicidade
                $mensagem_erro = "Erro: O email informado já está cadastrado.";
            } else {
                $mensagem_erro = "Erro ao cadastrar o usuário: " . $e->getMessage();
            }

            // Gera um script para o alerta de erro e volta para a página de login
            echo "
    <script>
        alert('$mensagem_erro');
        window.location.href = '/login';
    </script>
    ";
        }
    }

    public function logout()
    {
        // Inicia a sessão
        session_start();

        // Destrói a sessão
        session_destroy();

        // Redireciona para a página de login
        echo "
    <script>
        alert('Logout realizado com sucesso!');
        window.location.href = '/home';
    </script>
    ";
    }


    // Esses métodos estão comentados porque não são necessários para o funcionamento atual
    /*
    public function getAllClient()
    {
        if (!isset($_SESSION["id_usuario"])) {
            $errorMsg = 'Acesso negado. Usuário não autenticado.';
            return false;
        }
        try {
            $sql = "SELECT * FROM usuarios";
            $db = $this->conn->prepare($sql);
            $db->execute();
            $users = $db->fetchAll(PDO::FETCH_ASSOC);
            return $users;
        } catch (Exception $e) {
            $errorMsg = $e->getMessage();
            return false;
        }
    }

    public function getUserById($id)
    {
        try {
            // Prepara e executa a consulta
            $sql = "SELECT * FROM usuarios WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            // Retorna o usuário encontrado, ou `false` se não houver resultado
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user ?: false;
        } catch (Exception $e) {
            error_log("Erro ao buscar usuário: " . $e->getMessage());
            return false;
        }
    }

    public function updateUser($id, $nome, $email)
    {
        try {
            // Prepara e executa a atualização
            $sql = "UPDATE usuarios SET nome = :nome, email = :email WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);

            // Retorna `true` se a atualização foi bem-sucedida, `false` caso contrário
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Erro ao atualizar usuário: " . $e->getMessage());
            return false;
        }
    }
    public function deleteUser($id)
    {
        try {
            // Prepara e executa a atualização
            $sql = "DELETE FROM usuarios WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Erro ao atualizar usuário: " . $e->getMessage());
            return false;
        }
    }

    public function getUsersByPage($offset, $limit)
    {
        $sql = "SELECT * FROM usuarios ORDER BY id ASC LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
        */
}
