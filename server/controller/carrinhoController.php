<?php
// server/controller/calculadoraController.php

class carrinhoController
{
    public function index()
    {
        // Apenas define o caminho da view que o layout irá carregar
        $view = ROOT_PATH . '/public/pages/carrinho.php';

        // Chama o layout principal, que por sua vez carregará a $view
        require_once ROOT_PATH . '/public/components/layout.php';
    }
}
