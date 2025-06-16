<main class="d-flex">
  <div class="w-100 h-100 d-flex" style="background-color: #727072;">
    <div class="m-4 w-50" style="background-color: #919191;">
      <div class="m-4">
        <h2>Faça seu Login!</h2>
        <form method="POST" action="/autenticar">
          <div class="mb-3">
            <label for="loginEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="loginEmail" name="loginEmail" aria-describedby="emailHelp" required>
          </div>
          <div class="mb-3">
            <label for="loginSenha" class="form-label">Senha</label>
            <input type="password" class="form-control" id="loginSenha" name="loginSenha" required>
          </div>
          <button type="submit" class="btn btn-primary">Login</button>
        </form>
      </div>
    </div>
    <div class="m-4 w-50" style="background-color: #919191;">
      <div class="m-4">
        <h2>Ainda não tem uma conta? Cadastre-se</h2>
        <form method="POST" action="/createUser">
          <div class="mb-3">
            <label for="nome" class="form-label">Nome Completo</label>
            <input type="text" class="form-control" id="nome" name="nome" aria-describedby="emailHelp" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Endereço de Email</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
          </div>
          <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control" id="senha" name="senha" required>
          </div>
          <div class="mb-3">
            <label for="confirmar_senha" class="form-label">Confirme a Senha</label>
            <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" required>
          </div>
          <div class="mb-3 form-check">
            <label class="form-check-label" for="termos">Concordo com termos de uso.</label>
            <input type="checkbox" class="form-check-input" id="termos" name="termos" required>
          </div>
          <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
      </div>
    </div>
  </div>
</main>