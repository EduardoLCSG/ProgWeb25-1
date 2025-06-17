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
    public function autenticar($email, $senha)
    {

        if($this->validaSenha($email, $senha)){
            header("Location: /home");
            exit();
        }
        else {
            // Se a autenticação falhar, redireciona de volta para a página de login com uma mensagem de erro
            echo "    <script>
                alert('E-mail ou senha incorretos. Por favor, tente novamente.');
                window.location.href = '/login';
            </script>
            ";
        }
    }

    public function validaSenha(string $loginEmail, string $loginSenha): bool
{
    

    try {
        // 1. BUSCAR O USUÁRIO PELO E-MAIL (única consulta necessária)
        $sql = "SELECT id, nome_completo, email, senha FROM usuarios WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":email", $loginEmail);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // 2. VERIFICAR A SENHA E AUTENTICAR
        // Verifica se um usuário foi encontrado E se a senha fornecida corresponde ao hash no banco.
        if ($usuario && password_verify($loginSenha, $usuario['senha'])) {
            // Autenticação bem-sucedida!

            // Regenera o ID da sessão para segurança contra "session fixation".
            session_regenerate_id(true);

            // 3. ARMAZENAR DADOS NA SESSÃO
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome_completo'];
            $_SESSION['usuario_email'] = $usuario['email'];
            $_SESSION['autenticado'] = true;
            $_SESSION['last_activity'] = time();

            return true; // Retorna SUCESSO
        }

        // Se o usuário não existe ou a senha está incorreta, a função continua e retorna falha.
        return false; // Retorna FALHA

    } catch (Exception $e) {
        // Em um ambiente de produção, grave este erro em um log em vez de exibi-lo.
        error_log('Erro ao validar usuário: ' . $e->getMessage());
        return false; // Retorna FALHA em caso de exceção
    }
}

    public function logout()
    {       
        // Destrói todas as variáveis da sessão
        session_unset();
        session_destroy();

        // Redireciona para a página de home após o logout
        header("Location: /home");
        exit();
    }

}
