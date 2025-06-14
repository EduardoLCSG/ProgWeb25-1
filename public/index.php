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

    'home' => (function () {
        require_once ROOT_PATH . '/server/controller/homeController.php';
        $controller = new homeController();
        $controller->index();
    })(),

    'calculadora' => (function () {
        require_once ROOT_PATH . '/server/controller/calculadoraController.php';
        $controller = new calculadoraController();
        $controller->index();
    })(),

    'carrinho' => (function () {
        require_once ROOT_PATH . '/server/controller/carrinhoController.php';
        $controller = new carrinhoController();
        $controller->index();
    })(),

    'login' => (function () {
        require_once ROOT_PATH . '/server/controller/loginController.php';
        $controller = new loginController();
        $controller->index();
    })(),

    // Adicione outras rotas aqui...

    default => (function () {
        require_once ROOT_PATH . '/server/controller/notFoundController.php';
        $controller = new notFoundController();
        $controller->index();
    })(),
};
