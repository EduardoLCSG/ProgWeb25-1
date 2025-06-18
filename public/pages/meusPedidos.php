<main class="container my-5">
    <h1 class="mb-4">Meus Pedidos</h1>

    <?php if (empty($pedidos)): ?>
        <div class="alert alert-info">
            Você ainda não fez nenhum pedido.
        </div>
    <?php else: ?>
        <div class="accordion" id="accordionPedidos">
            <?php foreach ($pedidos as $pedido): ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading-<?php echo $pedido['id']; ?>">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $pedido['id']; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $pedido['id']; ?>">
                            <div class="w-100 d-flex justify-content-between pe-3">
                                <span><strong>Pedido #<?php echo $pedido['id']; ?></strong></span>
                                <span>Data: <?php echo date('d/m/Y H:i', strtotime($pedido['criado_em'])); ?></span>
                                <span>Status: <span class="badge bg-warning text-dark"><?php echo htmlspecialchars(ucfirst($pedido['status'])); ?></span></span>
                                <span>Total: R$ <?php echo number_format($pedido['total'], 2, ',', '.'); ?></span>
                            </div>
                        </button>
                    </h2>
                    <div id="collapse-<?php echo $pedido['id']; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $pedido['id']; ?>" data-bs-parent="#accordionPedidos">
                        <div class="accordion-body">
                            <h5>Itens do Pedido</h5>
                            <?php if (!empty($itensPorPedido[$pedido['id']])): ?>
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($itensPorPedido[$pedido['id']] as $item): ?>
                                        <li class="list-group-item d-flex align-items-center">
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
                                            <div class="flex-grow-1">
                                                <?php echo htmlspecialchars($item['nome']); ?>
                                                <small class="d-block text-muted">Qtd: <?php echo $item['quantidade']; ?> | Preço Unit.: R$ <?php echo number_format($item['preco_unitario'], 2, ',', '.'); ?></small>
                                            </div>
                                            <div>
                                                <strong>Subtotal: R$ <?php echo number_format($item['quantidade'] * $item['preco_unitario'], 2, ',', '.'); ?></strong>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>