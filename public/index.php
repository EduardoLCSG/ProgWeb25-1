<?php
// public/index.php

/**
 * Define uma constante global para o caminho raiz do projeto.
 */
define('ROOT_PATH', dirname(__DIR__));

// Pega a URI da requisição, por ex: "/calculadora" ou "/contato"
$uri = $_SERVER['REQUEST_URI'];

// Remove a barra inicial e qualquer parâmetro GET para limpar o caminho
$path = trim(parse_url($uri, PHP_URL_PATH), '/');

// Se o caminho estiver vazio (acessou a raiz do site), redireciona para /home
if ($path === '') {
    header('Location: /home', true, 302);
    exit();
}

// O roteamento agora é feito com base no caminho limpo
match ($path) {
    'home' => require ROOT_PATH . '/public/pages/home.php',

    'calculadora' => (function() {
        require_once ROOT_PATH . '/server/controller/CalculadoraController.php';
        $controller = new CalculadoraController();
        $controller->index();
    })(),

    // Adicione outras rotas aqui...

    default => require ROOT_PATH . '/public/pages/404.php',
};