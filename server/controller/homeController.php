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

    public function getProdutos()
    {
        // Esta consulta já está correta, não precisa mudar
        $sql = "SELECT p.id, p.nome, p.descricao, p.preco, p.imagem_path, p.categoria_id 
                FROM produtos p";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getCategorias()
    {
        $sql = "SELECT id, nome FROM categorias ORDER BY nome ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function index()
    {
        // Busca tanto os produtos quanto as categorias
        $produtos = $this->getProdutos();
        $categorias = $this->getCategorias(); // NOVO

        // Define o caminho da view
        $view = ROOT_PATH . '/public/pages/home.php';
        
        // Carrega o layout, que terá acesso a $produtos e $categorias
        require_once ROOT_PATH . '/public/components/layout.php';
    }
}