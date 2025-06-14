<?php
// server/controller/CalculadoraController.php

class CalculadoraController
{
    public function index()
    {
        // Usa a constante para montar o caminho absoluto para a view
        require_once ROOT_PATH . '/public/pages/calculadora.php';
    }
}