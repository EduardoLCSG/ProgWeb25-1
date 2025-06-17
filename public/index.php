<?php

// Inicia a sessão
session_start();

// Verifica se a sessão não expirou
if (isset($_SESSION['autenticado']) && $_SESSION['autenticado'] === true) {
    // Define o tempo limite de inatividade em segundos (5 minutos)
    $inactive_timeout = 300; 

    // Verifica se o timestamp da última atividade está definido
    if (isset($_SESSION['last_activity'])) {
        // Calcula o tempo de inatividade
        $session_life = time() - $_SESSION['last_activity'];

        // Se o tempo de inatividade for maior que o tempo limite
        if ($session_life > $inactive_timeout) {
            // Destrói a sessão e redireciona para o login
            session_unset();
            session_destroy();
            header("Location: /login?motivo=expirado");
            exit();
        }
    }
    
    // Se a sessão ainda estiver ativa, atualiza o timestamp da última atividade
    $_SESSION['last_activity'] = time();
}

/**
 * Define uma constante global para o caminho raiz do projeto.
 */
define('ROOT_PATH', dirname(__DIR__));

$request_uri = $_SERVER['REQUEST_URI'];

// Remove query strings (ex: ?param=valor) para obter o caminho do arquivo.
$request_path = parse_url($request_uri, PHP_URL_PATH);

// Constrói o caminho completo para o arquivo no sistema de arquivos.
$file_path = ROOT_PATH . '/public' . $request_path; // Ajuste '/public' se suas imagens estiverem em outra pasta.

// Se o caminho da requisição aponta para um arquivo existente,
// informa ao servidor web para servi-lo diretamente e para a execução do script.
if (is_file($file_path)) {
    return false;
}

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

    'createUser' => (function () {
        require_once ROOT_PATH . '/server/controller/usuarioController.php';
        $controller = new usuarioController();
        $controller->createUser($nome = $_POST["nome"], $email = $_POST["email"], $senha = $_POST['senha'], $confirmar_senha = $_POST['confirmar_senha'], $termos = $_POST['termos']);
    })(),

    'autenticar' => (function () {
        require_once ROOT_PATH . '/server/controller/usuarioController.php';
        $controller = new usuarioController();
        $controller->autenticar($email = $_POST["loginEmail"], $senha = $_POST["loginSenha"]);
    })(),

    'logout' => (function () {
        require_once ROOT_PATH . '/server/controller/usuarioController.php';
        $controller = new usuarioController();
        $controller->logout();
    })(),
    'adicionarItem' => (function () {
        require_once ROOT_PATH . '/server/controller/carrinhoController.php';
        $controller = new carrinhoController();
        $controller->adicionarItem();
    })(),

    // Adicione outras rotas aqui...

    default => (function () {
        http_response_code(404);
        require_once ROOT_PATH . '/server/controller/notFoundController.php';
        $controller = new notFoundController();
        $controller->index();
    })(),
};
