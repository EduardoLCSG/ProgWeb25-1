<?php

require_once __DIR__ . '/../controller/loginController.php';
$loginController = new LoginController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    switch ($_GET['acao']) {
        case 'validarLogin':
            $output = $loginController->ValidaSenha($_POST['email'], $_POST["nome"]);
            $output ? 
            header('Location: ../../pages/home/index.php') : 
            header('Location: ../../index.php');
            break;
        default:
            echo 'Not found';
            break;
    }
}