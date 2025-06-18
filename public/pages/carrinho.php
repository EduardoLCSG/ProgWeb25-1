<main class="d-flex container my-4">
  <div class="w-25 p-3" style="background-color: #f8f9fa; border-radius: 5px;">
    <h4>Resumo do Pedido</h4>
    <hr>
    <div>
      <span>Subtotal:</span>
      <span class="float-end">R$ <?php echo number_format($totalCarrinho ?? 0, 2, ',', '.'); ?></span>
    </div>
    <div>
      <span>Frete:</span>
      <span class="float-end">Somente retirada</span>
    </div>
    <hr>
    <div>
      <strong>Total:</strong>
      <strong class="float-end">R$ <?php echo number_format($totalCarrinho ?? 0, 2, ',', '.'); ?></strong>
    </div>
    
    <div class="d-grid gap-2 mt-4">
        <form action="/finalizarPedido" method="post">
            <button type="submit" class="btn btn-primary w-100" <?php if (empty($itens)) echo 'disabled'; ?>>
                Finalizar Compra
            </button>
        </form>
    </div>
    </div>

  <div class="w-75 ms-4">
    <h3>Meu Carrinho</h3>
    <hr>

    <?php if (empty($itens)): ?>
      <div class="alert alert-info">
        Seu carrinho está vazio.
      </div>
    <?php else: ?>
      <?php foreach ($itens as $item): ?>
        <div class="card mb-3">
          <div class="row g-0">
            <div class="col-md-2 d-flex align-items-center justify-content-center p-2">

              <?php
              // Define o caminho da imagem do item, se existir, ou usa a imagem padrão
              $caminhoImagemPadrao = '/assets/images/default.jpg';
              if (!empty($item['imagem_path']) && file_exists(ROOT_PATH . '/public' . $item['imagem_path'])) {
                $caminhoImagem = $item['imagem_path'];
              } else {
                $caminhoImagem = $caminhoImagemPadrao;
              }
              ?>
              <img src="<?php echo htmlspecialchars($caminhoImagem); ?>"
                class="img-fluid rounded-start"
                alt="<?php echo htmlspecialchars($item['nome']); ?>" style="max-height: 120px; object-fit: contain;">
            </div>
            <div class="col-md-10">
              <div class="card-body">
                <div class="d-flex justify-content-between">
                  <h5 class="card-title"><?php echo htmlspecialchars($item['nome']); ?></h5>
                  <p class="card-text">
                    <strong>Subtotal: R$ <?php echo number_format($item['quantidade'] * $item['preco_unitario'], 2, ',', '.'); ?></strong>
                  </p>
                </div>
                <p class="card-text mb-1">
                  <small class="text-muted">Preço Unitário: R$ <?php echo number_format($item['preco_unitario'], 2, ',', '.'); ?></small>
                </p>

                <div class="d-flex align-items-center mt-2">
                  <span class="me-2">Quantidade:</span>
                  <form action="/diminuirItem" method="post" class="me-2">
                    <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
                    <button type="submit" class="btn btn-secondary btn-sm">-</button>
                  </form>

                  <span class="mx-2"><?php echo htmlspecialchars($item['quantidade']); ?></span>

                  <form action="/adicionarItem" method="post">
                    <input type="hidden" name="produto_id" value="<?php echo $item['produto_id']; ?>">
                    <input type="hidden" name="quantidade" value="1">
                    <button type="submit" class="btn btn-secondary btn-sm">+</button>
                  </form>

                  <form action="/removerItem" method="post" class="ms-auto">
                    <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
                    <button type="submit" class="btn btn-outline-danger btn-sm">Remover</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>

  </div>
</main>