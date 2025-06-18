<?php
// server/controller/carrinhoController.php

require_once ROOT_PATH . '/server/controller/baseController.php';

class carrinhoController extends baseController // <-- Herda de BaseController
{
    public function __construct()
    {
        // Chama o construtor da classe pai para inicializar a conexão
        parent::__construct(); 
    }

    /**
     * Busca o carrinho do usuário logado. Se não existir, cria um novo.
     * @param int $usuarioId
     * @return int O ID do carrinho.
     */

    public function adicionarItem()
    {
        // 1. Proteger a rota: verifica se o usuário está logado e se o método é POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
            header('Location: /login');
            exit();
        }

        // 2. Obter e validar os dados do formulário
        $produtoId = filter_input(INPUT_POST, 'produto_id', FILTER_VALIDATE_INT);
        $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT);

        if (!$produtoId || !$quantidade || $quantidade <= 0) {
            // Se os dados forem inválidos, redireciona de volta para a home
            header('Location: /home?erro=invalido');
            exit();
        }

        try {
            // 3. Obter ID do usuário e do carrinho
            $usuarioId = $_SESSION['usuario_id'];
            $carrinhoId = $this->getOrCreateCarrinhoId($usuarioId);

            // 4. Obter o preço atual do produto para garantir consistência
            $sqlProduto = "SELECT preco FROM produtos WHERE id = :produto_id";
            $stmtProduto = $this->conn->prepare($sqlProduto);
            $stmtProduto->execute([':produto_id' => $produtoId]);
            $produto = $stmtProduto->fetch(PDO::FETCH_ASSOC);

            if (!$produto) {
                // Produto não existe
                header('Location: /home?erro=produto_nao_existe');
                exit();
            }
            $precoUnitario = $produto['preco'];

            // 5. Verificar se o item já existe no carrinho
            $sqlVerifica = "SELECT id, quantidade FROM carrinho_itens WHERE carrinho_id = :carrinho_id AND produto_id = :produto_id";
            $stmtVerifica = $this->conn->prepare($sqlVerifica);
            $stmtVerifica->execute([':carrinho_id' => $carrinhoId, ':produto_id' => $produtoId]);
            $itemExistente = $stmtVerifica->fetch(PDO::FETCH_ASSOC);

            if ($itemExistente) {
                // Se existe, ATUALIZA a quantidade
                $novaQuantidade = $itemExistente['quantidade'] + $quantidade;
                $sql = "UPDATE carrinho_itens SET quantidade = :quantidade WHERE id = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([':quantidade' => $novaQuantidade, ':id' => $itemExistente['id']]);
            } else {
                // Se não existe, INSERE um novo item
                $sql = "INSERT INTO carrinho_itens (carrinho_id, produto_id, quantidade, preco_unitario) VALUES (:carrinho_id, :produto_id, :quantidade, :preco_unitario)";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    ':carrinho_id' => $carrinhoId,
                    ':produto_id' => $produtoId,
                    ':quantidade' => $quantidade,
                    ':preco_unitario' => $precoUnitario
                ]);
            }

            // 6. Redirecionar para a página do carrinho para o usuário ver o item adicionado
            header('Location: /carrinho');
            exit();

        } catch (PDOException $e) {
            // Em um ambiente real, você logaria o erro em vez de exibi-lo
            error_log("Erro ao adicionar item ao carrinho: " . $e->getMessage());
            header('Location: /home?erro=db'); // Informa que houve um erro
            exit();
        }
    }

    // Adicione este método dentro da classe carrinhoController

    public function diminuirItem()
    {
        // 1. Segurança: Verificar sessão e método POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
            header('Location: /login');
            exit();
        }

        // 2. Obter e validar o ID do item do carrinho
        $itemId = filter_input(INPUT_POST, 'item_id', FILTER_VALIDATE_INT);
        if (!$itemId) {
            header('Location: /carrinho?erro=item_invalido');
            exit();
        }

        try {
            // 3. Obter o carrinho do usuário para verificação de segurança
            $usuarioId = $_SESSION['usuario_id'];
            $carrinhoId = $this->getOrCreateCarrinhoId($usuarioId);

            // 4. Buscar a quantidade atual do item (e verificar se o item pertence ao carrinho do usuário)
            $sqlVerifica = "SELECT quantidade FROM carrinho_itens WHERE id = :item_id AND carrinho_id = :carrinho_id";
            $stmtVerifica = $this->conn->prepare($sqlVerifica);
            $stmtVerifica->execute([':item_id' => $itemId, ':carrinho_id' => $carrinhoId]);
            $item = $stmtVerifica->fetch(PDO::FETCH_ASSOC);

            // 5. Lógica condicional: se item existe, decide se atualiza ou apaga
            if ($item) {
                if ($item['quantidade'] > 1) {
                    // Se a quantidade for maior que 1, apenas diminui 1
                    $sql = "UPDATE carrinho_itens SET quantidade = quantidade - 1 WHERE id = :item_id";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->execute([':item_id' => $itemId]);
                } else {
                    // Se a quantidade for 1, remove o item completamente
                    $sql = "DELETE FROM carrinho_itens WHERE id = :item_id";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->execute([':item_id' => $itemId]);
                }
            }
            
            // 6. Redirecionar de volta para o carrinho
            header('Location: /carrinho');
            exit();

        } catch (PDOException $e) {
            error_log("Erro ao diminuir item do carrinho: " . $e->getMessage());
            header('Location: /carrinho?erro=db');
            exit();
        }
    }

    public function removerItem()
    {
        // 1. Proteger a rota: verifica se o usuário está logado e se o método é POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
            header('Location: /login');
            exit();
        }

        // 2. Obter e validar o ID do item a ser removido
        $itemId = filter_input(INPUT_POST, 'item_id', FILTER_VALIDATE_INT);

        if (!$itemId) {
            // Se o ID for inválido, redireciona de volta para o carrinho
            header('Location: /carrinho?erro=item_invalido');
            exit();
        }

        try {
            // 3. Obter o ID do carrinho do usuário atual (para verificação de segurança)
            $usuarioId = $_SESSION['usuario_id'];
            $carrinhoId = $this->getOrCreateCarrinhoId($usuarioId);

            // 4. Executar a exclusão SEGURA do item
            // A cláusula "AND carrinho_id = :carrinho_id" é uma camada de segurança crucial.
            // Ela garante que um usuário só possa remover itens do SEU PRÓPRIO carrinho.
            $sql = "DELETE FROM carrinho_itens WHERE id = :item_id AND carrinho_id = :carrinho_id";
            $stmt = $this->conn->prepare($sql);
            
            $stmt->execute([
                ':item_id' => $itemId,
                ':carrinho_id' => $carrinhoId
            ]);

            // 5. Redirecionar de volta para o carrinho para o usuário ver o resultado
            header('Location: /carrinho');
            exit();

        } catch (PDOException $e) {
            error_log("Erro ao remover item do carrinho: " . $e->getMessage());
            header('Location: /carrinho?erro=db');
            exit();
        }
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
        // ADICIONE "ci.id as item_id" à consulta SELECT
        $sql = "SELECT 
                    ci.id as item_id, 
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

    // Adicione este método dentro da classe carrinhoController

    public function finalizarPedido()
    {
        // 1. Segurança: Garante que o usuário está logado e o método é POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['autenticado']) || !$_SESSION['autenticado']) {
            header('Location: /login');
            exit();
        }

        $usuarioId = $_SESSION['usuario_id'];
        $carrinhoId = $this->getOrCreateCarrinhoId($usuarioId);
        $itens = $this->getItensDoCarrinho($carrinhoId);

        // Não prossiga se o carrinho estiver vazio
        if (empty($itens)) {
            header('Location: /carrinho');
            exit();
        }

        try {
            // 2. INICIA A TRANSAÇÃO: Todas as operações seguintes devem ter sucesso.
            $this->conn->beginTransaction();

            // 3. Calcula o total final e cria o pedido na tabela 'pedidos'
            $totalPedido = 0;
            foreach ($itens as $item) {
                $totalPedido += $item['quantidade'] * $item['preco_unitario'];
            }
            
            // Ignoramos endereco_id por enquanto
            $sqlPedido = "INSERT INTO pedidos (usuario_id, total, status) VALUES (:usuario_id, :total, 'processando')";
            $stmtPedido = $this->conn->prepare($sqlPedido);
            $stmtPedido->execute([':usuario_id' => $usuarioId, ':total' => $totalPedido]);
            $pedidoId = $this->conn->lastInsertId();

            // 4. Move os itens do carrinho para a tabela 'pedido_itens' e atualiza o estoque
            $sqlItemPedido = "INSERT INTO pedido_itens (pedido_id, produto_id, quantidade, preco_unitario) VALUES (:pedido_id, :produto_id, :quantidade, :preco_unitario)";
            $sqlEstoque = "UPDATE produtos SET estoque = estoque - :quantidade WHERE id = :produto_id";
            
            foreach ($itens as $item) {
                // Insere o item no pedido
                $stmtItem = $this->conn->prepare($sqlItemPedido);
                $stmtItem->execute([
                    ':pedido_id' => $pedidoId,
                    ':produto_id' => $item['produto_id'],
                    ':quantidade' => $item['quantidade'],
                    ':preco_unitario' => $item['preco_unitario']
                ]);

                // Atualiza o estoque do produto
                $stmtEstoque = $this->conn->prepare($sqlEstoque);
                $stmtEstoque->execute([
                    ':quantidade' => $item['quantidade'],
                    ':produto_id' => $item['produto_id']
                ]);
            }

            // 5. Limpa o carrinho de compras do usuário
            $sqlLimpaCarrinho = "DELETE FROM carrinho_itens WHERE carrinho_id = :carrinho_id";
            $stmtLimpa = $this->conn->prepare($sqlLimpaCarrinho);
            $stmtLimpa->execute([':carrinho_id' => $carrinhoId]);

            // 6. EFETIVA A TRANSAÇÃO: Se tudo deu certo, salva as alterações no banco
            $this->conn->commit();

            // Guarda o ID do último pedido na sessão para a página de confirmação
            $_SESSION['ultimo_pedido_id'] = $pedidoId;

            // 7. Redireciona para a página de sucesso
            header('Location: /pedidoConfirmado');
            exit();

        } catch (PDOException $e) {
            // 8. DESFAZ A TRANSAÇÃO: Se algo deu errado, reverte todas as alterações
            $this->conn->rollBack();
            error_log("Erro ao finalizar pedido: " . $e->getMessage());
            header('Location: /carrinho?erro=finalizacao');
            exit();
        }
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