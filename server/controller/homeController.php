<?php
// server/controller/homeController.php

require_once ROOT_PATH . '/server/controller/baseController.php';

class homeController extends baseController // <-- Herda de BaseController
{
    public function __construct()
    {
        // Chama o construtor da classe pai para inicializar a conexão
        parent::__construct(); 
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