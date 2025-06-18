<?php
// server/controller/BaseController.php

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