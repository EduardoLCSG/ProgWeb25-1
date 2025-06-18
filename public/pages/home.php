<style>
    /* Seu CSS continua o mesmo */
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
                    <div class="col-md-3 mb-4">
                        <div class="componente-produto">
                            <?php
                                // Define o caminho da imagem padrão
                                $caminhoImagemPadrao = '/assets/images/default.jpg';
                                
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

                            <form action="/adicionarItem" method="post" class="mt-auto">
                                <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>">

                                <div class="d-flex align-items-center mb-2">
                                    <label for="quantidade-<?php echo $produto['id']; ?>" class="me-2">Qtd:</label>
                                    <input type="number" name="quantidade" id="quantidade-<?php echo $produto['id']; ?>" value="1" min="1" class="form-control" style="width: 70px;">
                                </div>

                                <button type="submit" class="btn btn-primary w-100" style="background-color: #e44d26; border: none;">Adicionar ao Carrinho</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</main>