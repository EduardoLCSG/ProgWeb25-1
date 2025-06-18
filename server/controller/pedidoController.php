<?php
require_once ROOT_PATH . '/server/controller/baseController.php';

class PedidoController extends baseController
{
    public function __construct()
    {
        // Chama o construtor da classe pai para inicializar a conexão
        parent::__construct();
    }

        public function exibirConfirmacao()
    {
        // Protege a página, só pode ser vista se um pedido acabou de ser feito
        if (!isset($_SESSION['ultimo_pedido_id'])) {
            header('Location: /home');
            exit();
        }

        $pedidoId = $_SESSION['ultimo_pedido_id'];

        // Aqui você pode buscar os dados do pedido recém-criado para exibir um resumo
        // (Vou manter simples por enquanto, apenas exibindo o ID)
        $viewData = ['pedido_id' => $pedidoId];
        
        // Limpa a variável da sessão para que a página não seja recarregada
        unset($_SESSION['ultimo_pedido_id']);

        $view = ROOT_PATH . '/public/pages/pedidoConfirmado.php';
        require_once ROOT_PATH . '/public/components/layout.php';
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
}