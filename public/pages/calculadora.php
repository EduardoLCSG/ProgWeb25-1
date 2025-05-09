<!doctype html>
<html lang="pt-br">

<head>
    <title>Solar</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
</head>

<body class="w-100">
    <?php require_once '../components/header.php'; ?>
    <main class="d-flex" style="height: 640px;">
        <div class="w-25 h-100" style="background-color: #e1e1e1;">

        </div>
        <div class="w-75 h-100 d-flex" style="background-color: #820e8d;">
            <div class="m-4 w-50" style="background-color: #919191;">
                <div class="m-4">
                    <h2>Calculadora</h2>
                    <p>Calcule a quantidade de placas necessarias para o seu consumo mensal.</p>
                    <form>
                      <div class="mb-3">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="nome" aria-describedby="emailHelp">
                      </div>
                      <div class="mb-3">
                        <label for="consumoKw" class="form-label">Comsumo de energia em Kw</label>
                        <input type="number" class="form-control" id="consumoKw" aria-describedby="emailHelp">
                      </div>
                      <div class="mb-3">
                        <label for="endereco" class="form-label">Endereço</label>
                        <input type="text" class="form-control" id="endereco">
                      </div>
                      <div class="mb-3">
                        <label for="email" class="form-label">E-mail de contato</label>
                        <input type="email" class="form-control" id="email">
                      </div>
                      <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                        <label class="form-check-label" for="exampleCheck1">Concordo com termos de uso.</label>
                      </div>
                      <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Tenho interesse em receber contatos, promoções e notícias.</label>
                      </div>
                      <button type="submit" class="btn btn-primary">Calcular</button>
                    </form>
                </div>
              </div>
              <div class="m-4 w-50" style="background-color: #919191;">
                <div class="m-4">
                    <span id="resultado">

                    </span>
                    
                </div>
              </div>
              
        </div>
    </main>
    <?php require_once '../components/footer.php'; ?>
</body>

</html>