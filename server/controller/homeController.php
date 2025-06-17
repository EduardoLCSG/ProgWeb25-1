<?php
// server/controller/homeController.php

class homeController
{
    private $conn;

    public function __construct()
    {
        require_once ROOT_PATH . '/server/config/database/database.php';
        $objDb = new Database;
        $this->conn = $objDb->connect();
    }

    /**
     * Busca todos os produtos no banco de dados.
     * @return array Lista de produtos.
     */
    public function getProdutos()
    {
        // Altere a consulta para buscar a nova coluna 'imagem_path'
        $sql = "SELECT id, nome, descricao, preco, imagem_path FROM produtos";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function index()
    {
        // PASSO 1: Busca os produtos do banco de dados chamando o método getProdutos.
        $produtos = $this->getProdutos();

        // PASSO 2: Define o caminho da view que o layout irá carregar.
        $view = ROOT_PATH . '/public/pages/home.php';

        // PASSO 3: Chama o layout principal.
        // A variável $produtos estará disponível dentro de 'layout.php' e, consequentemente, em 'home.php'.
        require_once ROOT_PATH . '/public/components/layout.php';
    }
}