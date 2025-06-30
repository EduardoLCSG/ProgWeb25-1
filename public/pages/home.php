<style>
    
    .componente-produto {
        border: 1px solid #ccc;
        padding: 15px;
        margin-bottom: 20px;
        width: 100%;
        border-radius: 5px;
        font-family: sans-serif;
        box-shadow: 2px 2px 3px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .informacao {
        margin-bottom: 8px;
    }

    .informacao.preco {
        font-size: 1.2em;
        font-weight: bold;
        color: #e44d26;
        margin-top: auto;
    }

    .imagem-produto {
        width: 100%;
        height: 200px;
        object-fit: contain;
        margin-bottom: 10px;
    }

    /* Adiciona estilo para o link de categoria ativo */
    .nav-pills .nav-link.active {
        background-color: #F28705;
    }
</style>

<div class="w-100 p-3 d-flex justify-content-center categorias" style="background-color:#bfbfbf;">
    <?php
    // Pega a categoria da URL, ou define 'todos' como padrão
    $categoriaFiltrada = $_GET['categoria_id'] ?? 'todos';
    ?>
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-link <?php if ($categoriaFiltrada == 'todos') echo 'active'; ?>" href="/home">Todos</a>
        </li>
        <?php foreach ($categorias as $categoria): ?>
            <li class="nav-item">
                <a class="nav-link <?php if ($categoriaFiltrada == $categoria['id']) echo 'active'; ?>"
                    href="/home?categoria_id=<?php echo $categoria['id']; ?>">
                    <?php echo htmlspecialchars($categoria['nome']); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<main class="container">
    <div class="m-4">
        <div class="row">
             <div class="input-group input-group-lg mb-3">
                <span class="input-group-text" id="search-icon">
                    <i class="bi bi-search"></i> </span>
                <input type="text" class="form-control" id="procurar-produto" placeholder="Digite o nome de um produto..." aria-label="Busca" aria-describedby="search-icon">
            </div>
        </div>
        <div id="produtos-container" class="row">
           <?php require_once ROOT_PATH . '/public/pages/lista_produtos.php'; ?>
        </div>  
    </div>
</main>

<script src="../js/pesquisaProdutos.js"></script>
