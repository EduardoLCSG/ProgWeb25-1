<main class="d-flex">
  <div class="w-100 h-100 d-flex" style="background-color: #727072;">
    <div class="m-4 w-50" style="background-color: #919191;">
      <div class="m-4">
        <h2>Login</h2>
        <form method="POST" action="../server/routes/loginRouter.php?acao=validarLogin">
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
          </div>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Senha</label>
            <input type="password" class="form-control" id="exampleInputPassword1">
          </div>
          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
          </div>
          <button type="submit" class="btn btn-primary">Login</button>
        </form>
      </div>
    </div>
    <div class="m-4 w-50" style="background-color: #919191;">
      <div class="m-4">
        <h2>Cadastre-se</h2>
        <form method="POST" action="../server/routes/usuarioRouter.php?acao=create">
          <div class="mb-3">
            <label for="nome" class="form-label">Nome Completo</label>
            <input type="text" class="form-control" id="nome" aria-describedby="emailHelp">
          </div>
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
          </div>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Senha</label>
            <input type="password" class="form-control" id="exampleInputPassword1">
          </div>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Confirme a Senha</label>
            <input type="password" class="form-control" id="exampleInputPassword1">
          </div>
          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Concordo com termos de uso.</label>
          </div>
          <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
      </div>
    </div>
  </div>
</main>