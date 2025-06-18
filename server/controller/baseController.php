<?php
// server/controller/BaseController.php
//controlador base para reaproveitar código entre os controladores
// Exemplo: conexão com o banco de dados

class baseController 
{
    protected $conn;

    public function __construct()
    {
        require_once ROOT_PATH . '/server/config/database/database.php';
        $objDb = new Database;
        $this->conn = $objDb->connect();
    }
}