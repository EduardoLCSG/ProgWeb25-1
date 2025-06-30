<?php
    $categoriaFiltrada = $_GET['categoria_id'] ?? 'todos';
?>

<?php if (empty($produtos)): ?>
    <div class="col-12">
        <p>Nenhum produto encontrado no momento.</p>
    </div>
<?php else: ?>
    <?php foreach ($produtos as $produto): ?>
        <?php
        // CONDIÇÃO DE FILTRO: Mostra o produto apenas se...
        // 1. O filtro for 'todos' OU
        // 2. O categoria_id do produto for igual ao da URL
        if ($categoriaFiltrada == 'todos' || $produto['categoria_id'] == $categoriaFiltrada):
        ?>
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
    <?php
        endif; // Fim da condição de filtro
    endforeach; // Fim do loop de produtos 
    ?>
<?php endif; ?>