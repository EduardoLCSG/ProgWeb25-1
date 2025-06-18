<main class="container text-center my-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1 class="mb-3">🎉 Pedido Realizado com Sucesso!</h1>
            <p class="lead">Obrigado por sua compra. Seu pedido foi registrado e está sendo processado.</p>
            <div class="alert alert-success">
                Número do seu Pedido: <strong>#<?php echo htmlspecialchars($viewData['pedido_id']); ?></strong>
            </div>
            <p>Você receberá mais informações por e-mail. Como não há entrega, seu pedido estará disponível para retirada em nossa loja em breve.</p>
            <a href="/home" class="btn btn-primary mt-3">Continuar Comprando</a>
        </div>
    </div>
</main>