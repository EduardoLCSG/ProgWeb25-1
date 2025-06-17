<style>
    .componente-produto {
        border: 1px solid #ccc;
        padding: 15px;
        margin-bottom: 20px;
        width: 100%;
        border-radius: 5px;
        font-family: sans-serif;
        box-shadow: 2px 2px 3px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .informacao { margin-bottom: 8px; }
    .informacao.preco { font-size: 1.2em; font-weight: bold; color: #e44d26; margin-top: auto; }
    .imagem-produto { width: 100%; height: 200px; object-fit: contain; margin-bottom: 10px; }
</style>

<main class="container">
    <div class="m-4">
        <div class="row">
            <?php if (empty($produtos)): ?>
                <div class="col-12">
                    <p>Nenhum produto encontrado no momento.</p>
                </div>
            <?php else: ?>
                <?php foreach ($produtos as $produto): ?>
                    <div class="col-md-3">
                        <div class="componente-produto">
                            <?php
                                // Define o caminho da imagem padrão
                                $caminhoImagemPadrao = ROOT_PATH.'\public\assets\images\default.jpg';
                                echo $caminhoImagemPadrao;
                                
                                // Verifica se o produto tem um caminho de imagem e se o arquivo existe
                                if (!empty($produto['imagem_path']) && file_exists(ROOT_PATH . '/public' . $produto['imagem_path'])) {
                                    $caminhoImagem = $produto['imagem_path'];
                                } else {
                                    $caminhoImagem = $caminhoImagemPadrao;
                                }
                            ?>
                            
                            <img src="<?php echo htmlspecialchars($caminhoImagem); ?>"
                                 alt="<?php echo htmlspecialchars($produto['nome']); ?>" class="imagem-produto">

                            <h2 class="informacao"><?php echo htmlspecialchars($produto['nome']); ?></h2>
                            
                            <?php if (!empty($produto['descricao'])): ?>
                                <p class="informacao"><?php echo htmlspecialchars($produto['descricao']); ?></p>
                            <?php endif; ?>

                            <p class="informacao preco">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                            
                            <p class="informacao">À vista no PIX</p>
                            <button style="background-color: #e44d26; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer;">COMPRAR</button>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php endif; ?>
        </div>
    </div>
</main>