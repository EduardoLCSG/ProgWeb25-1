<?php
// server/controller/carrinhoController.php

class CarrinhoController
{
    private $conn;

    public function __construct()
    {
        // Garante a conexão com o banco de dados ao instanciar o controller
        require_once ROOT_PATH . '/server/config/database/database.php';
        $objDb = new Database;
        $this->conn = $objDb->connect();
    }

    /**
     * Busca o carrinho do usuário logado. Se não existir, cria um novo.
     * @param int $usuarioId
     * @return int O ID do carrinho.
     */

    public function adicionarItem(){

        
    }

    private function getOrCreateCarrinhoId(int $usuarioId): int
    {
        // 1. Tenta encontrar um carrinho existente para o usuário
        $sql = "SELECT id FROM carrinhos WHERE usuario_id = :usuario_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
        $stmt->execute();
        $carrinho = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($carrinho) {
            return $carrinho['id'];
        } else {
            // 2. Se não encontrou, cria um novo carrinho para o usuário
            $sql = "INSERT INTO carrinhos (usuario_id) VALUES (:usuario_id)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
            $stmt->execute();
            // Retorna o ID do carrinho recém-criado
            return $this->conn->lastInsertId();
        }
    }

    /**
     * Busca os itens do carrinho, juntando com os dados dos produtos.
     * @param int $carrinhoId
     * @return array Lista de itens no carrinho.
     */
    private function getItensDoCarrinho(int $carrinhoId): array
    {
        $sql = "SELECT 
                    ci.produto_id,
                    ci.quantidade,
                    ci.preco_unitario,
                    p.nome,
                    p.imagem_path
                FROM 
                    carrinho_itens ci
                JOIN 
                    produtos p ON ci.produto_id = p.id
                WHERE 
                    ci.carrinho_id = :carrinho_id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':carrinho_id', $carrinhoId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function index()
    {
        // 1. Proteger a rota: verifica se o usuário está logado
        if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
            // Se não estiver logado, redireciona para a página de login
            header('Location: /login');
            exit();
        }

        // 2. Pega o ID do usuário da sessão
        $usuarioId = $_SESSION['usuario_id'];

        // 3. Obtém o ID do carrinho do usuário (cria se não existir)
        $carrinhoId = $this->getOrCreateCarrinhoId($usuarioId);

        // 4. Busca os itens do carrinho
        $itens = $this->getItensDoCarrinho($carrinhoId);

        // 5. Calcula o total do carrinho
        $totalCarrinho = 0;
        foreach ($itens as $item) {
            $totalCarrinho += $item['quantidade'] * $item['preco_unitario'];
        }
        
        // 6. Define o caminho da view e carrega o layout
        $view = ROOT_PATH . '/public/pages/carrinho.php';
        // As variáveis $itens e $totalCarrinho estarão disponíveis na view
        require_once ROOT_PATH . '/public/components/layout.php';
    }
}