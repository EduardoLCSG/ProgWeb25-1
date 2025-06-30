<?php
require_once ROOT_PATH . '/server/controller/baseController.php';

class ProdutosController extends baseController
{
    public function __construct()
    {
        parent::__construct(); // Inicializa a conexão (assumindo que $this->conn está no baseController)
    }

    public function GetProdutosByText()
    {
        // Termo de busca (seguro contra null)
        $searchTerm = $_GET['term'] ?? '';
        $categoriaFiltrada = $_GET['categoria_id'] ?? 'todos';
        
        // Categoria (opcional)
        $categoriaId = $_GET['categoria_id'] ?? 'todos';

        // Monta SQL inicial
        $sql = "SELECT p.id, p.nome, p.descricao, p.preco, p.imagem_path, p.categoria_id 
                FROM produtos p WHERE LOWER(p.nome) LIKE LOWER(?)";
        $params = ["%$searchTerm%"];

        // Se categoria foi especificada
        if ($categoriaId != 'todos' && !empty($categoriaId)) {
            $sql .= " AND p.categoria_id = ?";
            $params[] = $categoriaId;
        }

        try {
            $produtosQuery = $this->conn->prepare($sql);
            $produtosQuery->execute($params);
            $produtos = $produtosQuery->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Retorna erro como HTML simples (ou loga)
            echo "<p class='text-danger'>Erro ao buscar produtos: " . htmlspecialchars($e->getMessage()) . "</p>";
            return;
        }

        require_once ROOT_PATH . '/public/pages/lista_produtos.php';
    }
}
