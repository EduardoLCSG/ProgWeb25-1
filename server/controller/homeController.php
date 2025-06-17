<?php
// server/controller/homeController.php

class homeController
{
    private $conn;

    /**
     * O construtor agora cria uma conexão com o banco de dados.
     */
    public function __construct()
    {
        // Supondo que você tenha uma classe Database que gerencia a conexão
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
        // Seleciona os campos necessários, incluindo o ID para a imagem.
        $sql = "SELECT id, nome, descricao, preco, imagem FROM produtos";
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