<?php

class LoginController
{
    public function index()
    {
        // Apenas define o caminho da view que o layout irá carregar
        $view = ROOT_PATH . '/public/pages/login.php';

        // Chama o layout principal, que por sua vez carregará a $view
        require_once ROOT_PATH . '/public/components/layout.php';
    }

}
