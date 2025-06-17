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
      <span class="float-end">A calcular</span>
    </div>
    <hr>
    <div>
      <strong>Total:</strong>
      <strong class="float-end">R$ <?php echo number_format($totalCarrinho ?? 0, 2, ',', '.'); ?></strong>
    </div>
    <div class="d-grid gap-2 mt-4">
      <button class="btn btn-primary" type="button">Finalizar Compra</button>
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
                $caminhoImagem = !empty($item['imagem_path']) ? $item['imagem_path'] : '/assets/images/default.jpg';
              ?>
              <img src="<?php echo htmlspecialchars($caminhoImagem); ?>" class="img-fluid rounded-start" alt="<?php echo htmlspecialchars($item['nome']); ?>" style="max-height: 120px; object-fit: contain;">
            </div>
            <div class="col-md-10">
              <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($item['nome']); ?></h5>
                <p class="card-text mb-1">
                  <strong>Preço Unitário:</strong> R$ <?php echo number_format($item['preco_unitario'], 2, ',', '.'); ?>
                </p>
                <p class="card-text mb-1">
                  <strong>Quantidade:</strong> <?php echo htmlspecialchars($item['quantidade']); ?>
                </p>
                <p class="card-text">
                  <strong>Subtotal:</strong> R$ <?php echo number_format($item['quantidade'] * $item['preco_unitario'], 2, ',', '.'); ?>
                </p>
                </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>

  </div>
</main>