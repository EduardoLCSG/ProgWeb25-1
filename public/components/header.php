<?php
require_once __DIR__ . '/../../config/database/database.php';

$stmt = $pdo->query("SELECT * FROM usuarios");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<header>
    <nav class="navbar navbar-expand-lg" style="background-color: #F28705;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Solar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Calculadora</a>
                    </li>
                </ul>
            </div>
            <div class="collapse navbar-collapse d-flex flex-row-reverse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Carrinho</a>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-outline-success" type="submit">Login</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- <ul>
        <?php foreach ($usuarios as $produto): ?>
            <li>
                <strong><?= htmlspecialchars($produto['nome']) ?></strong><br>
            </li>
        <?php endforeach; ?>
    </ul> -->
</header>
