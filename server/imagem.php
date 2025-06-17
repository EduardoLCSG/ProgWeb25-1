<?php
// imagem.php

// Pega o ID do produto a partir do parâmetro GET na URL (ex: /imagem.php?id=1)
$id = $_GET['id'] ?? 0;
$imageData = null; // Inicializa a variável de imagem como nula

if ($id > 0) {
    // Conecta ao banco de dados
    require_once __DIR__ . '/server/config/database/database.php';
    $objDb = new Database;
    $conn = $objDb->connect();

    // Busca apenas a imagem do produto especificado
    $sql = "SELECT imagem FROM produtos WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Associa a coluna 'imagem' a uma variável
    $stmt->bindColumn(1, $imageData, PDO::PARAM_LOB);
    $stmt->fetch(PDO::FETCH_BOUND);
}

// Verifica se os dados da imagem foram carregados do banco
if ($imageData) {
    // Se a imagem foi encontrada no banco, exibe-a
    header('Content-Type: image/jpeg'); // Assumindo que as imagens no banco são JPEG
    echo $imageData;
    exit();
} else {
    // Se a imagem NÃO foi encontrada (seja por ID inválido ou por não existir no banco),
    // exibe a imagem padrão.

    // 1. Define o caminho absoluto para a imagem padrão
    $caminhoImagemPadrao = __DIR__ . '/public/assets/images/vazio.png';

    // 2. Informa ao navegador que o conteúdo é uma imagem PNG
    header('Content-Type: image/png');

    // 3. Lê o arquivo de imagem e o envia para o navegador
    readfile($caminhoImagemPadrao);
    exit();
}