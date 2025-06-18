<header>
    <nav class="navbar navbar-expand-lg" style="background-color: #F28705;">
        <div class="container-fluid">
            <a class="navbar-brand" href="/home">Solar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/calculadora">Calculadora</a>
                    </li>
                </ul>
            </div>
            <div class="collapse navbar-collapse d-flex flex-row-reverse" id="navbarNav">
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['autenticado']) && $_SESSION['autenticado'] === true): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/meusPedidos">Meus Pedidos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/carrinho">Carrinho</a>
                        </li>
                        <li class="nav-item">
                            <a href="/logout" class="btn btn-outline-danger">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a href="/login" class="btn btn-outline-success">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="w-100" style="background-image: url('/assets/images/transporte-home.jpg'); background-size: cover;
    background-position: center; background-repeat: no-repeat; clip-path: inset(0% 0% 0% 0%);
    height: 15vh; margin: 0; padding: 0;">
    </div>
</header>