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

        if ($this->validaSenha($email, $senha)) {
            header("Location: /home");
            exit();
        } else {
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
    public function exibirPedidos()
    {
        // 1. Protege a rota: o usuário deve estar logado
        if (!isset($_SESSION['autenticado']) || !$_SESSION['autenticado']) {
            header('Location: /login');
            exit();
        }

        $usuarioId = $_SESSION['usuario_id'];
        $pedidos = [];
        $itensPorPedido = [];

        try {
            // 2. Busca todos os pedidos do usuário, do mais recente para o mais antigo
            $sqlPedidos = "SELECT id, total, status, criado_em FROM pedidos WHERE usuario_id = :usuario_id ORDER BY criado_em DESC";
            $stmtPedidos = $this->conn->prepare($sqlPedidos);
            $stmtPedidos->execute([':usuario_id' => $usuarioId]);
            $pedidos = $stmtPedidos->fetchAll(PDO::FETCH_ASSOC);

            // 3. Se houver pedidos, busca todos os itens de todos esses pedidos de uma só vez
            if (!empty($pedidos)) {
                // Pega os IDs de todos os pedidos encontrados
                $pedidoIds = array_column($pedidos, 'id');

                // Cria os placeholders (?) para a cláusula IN
                $placeholders = implode(',', array_fill(0, count($pedidoIds), '?'));

                $sqlItens = "SELECT 
                                pi.pedido_id, pi.quantidade, pi.preco_unitario,
                                p.nome, p.imagem_path
                             FROM 
                                pedido_itens pi
                             JOIN 
                                produtos p ON pi.produto_id = p.id
                             WHERE 
                                pi.pedido_id IN ($placeholders)";

                $stmtItens = $this->conn->prepare($sqlItens);
                $stmtItens->execute($pedidoIds);
                $todosOsItens = $stmtItens->fetchAll(PDO::FETCH_ASSOC);

                // 4. Organiza os itens por pedido para facilitar a exibição na view
                foreach ($todosOsItens as $item) {
                    $itensPorPedido[$item['pedido_id']][] = $item;
                }
            }
        } catch (PDOException $e) {
            error_log("Erro ao buscar pedidos do usuário: " . $e->getMessage());
            // Você pode redirecionar para uma página de erro aqui
        }

        // 5. Carrega a view, passando os dados dos pedidos e dos itens
        $view = ROOT_PATH . '/public/pages/meusPedidos.php';
        require_once ROOT_PATH . '/public/components/layout.php';
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
