<?php

require_once __DIR__ . '/../controller/usuarioController.php';
$userController = new UsuarioController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    switch ($_GET['acao']) {
        case 'getAllUsers':
            $output = $userController->getAllClient($_POST['email'], $_POST["nome"]);
            return $output;
            break;
        case 'deletar':
            $output = $userController->deleteUser($_POST["id_usuario"]);
            header('Location: ../../pages/home/index.php');
            break;
        case 'create':
            $output = $userController->createUser($_POST["nome"], $_POST["email"]);
            header('Location: ../../pages/home/index.php');
            break;
        case 'update':
            $output = $userController->updateUser($_POST["usuarioId"], $_POST["nome"], $_POST["email"]);
            header('Location: ../../pages/home/index.php');
            break;
        default:
            echo 'Not found';
            break;
    }
}
