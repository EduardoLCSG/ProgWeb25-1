<main class="d-flex">
    <div class="w-25 h-100" style="background-color: #e1e1e1;">
    </div>
    <div class="w-75 h-100 d-flex" style="background-color: #a1a1a1;">
        <div class="m-4 w-50" style="background-color: #e1e1e1;">
            <div class="m-4">
                <h2>Calculadora de Painéis Solares</h2>
                <p>Calcule a quantidade de placas necessarias para o seu consumo mensal.</p>

                <form>
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="nome" placeholder="Digite seu nome completo" required>
                    </div>
                    <div class="mb-3">
                        <label for="kwh_mes" class="form-label">Consumo mensal (kWh):</label>
                        <input type="number" id="kwh_mes" class="form-control" placeholder="Digite o consumo mensal em kWh" required>
                    </div>
                    <div>
                        <label for="estado" class="form-label">Selecione seu estado:</label>
                        <select id="estado" class="form-control" required>
                            <option value="" disabled selected>Selecione seu estado</option>
                            <option value="4.9">Acre (AC)</option>
                            <option value="5.3">Alagoas (AL)</option>
                            <option value="5.0">Amapá (AP)</option>
                            <option value="4.4">Amazonas (AM)</option>
                            <option value="5.5">Bahia (BA)</option>
                            <option value="5.6">Ceará (CE)</option>
                            <option value="5.4">Distrito Federal (DF)</option>
                            <option value="4.8">Espírito Santo (ES)</option>
                            <option value="5.4">Goiás (GO)</option>
                            <option value="5.1">Maranhão (MA)</option>
                            <option value="5.5">Mato Grosso (MT)</option>
                            <option value="5.3">Mato Grosso do Sul (MS)</option>
                            <option value="5.2">Minas Gerais (MG)</option>
                            <option value="4.7">Pará (PA)</option>
                            <option value="5.6">Paraíba (PB)</option>
                            <option value="4.5">Paraná (PR)</option>
                            <option value="5.6">Pernambuco (PE)</option>
                            <option value="5.7">Piauí (PI)</option>
                            <option value="4.7">Rio de Janeiro (RJ)</option>
                            <option value="5.6">Rio Grande do Norte (RN)</option>
                            <option value="5.0">Rondônia (RO)</option>
                            <option value="4.8">Roraima (RR)</option>
                            <option value="4.3">Rio Grande do Sul (RS)</option>
                            <option value="4.4">Santa Catarina (SC)</option>
                            <option value="5.3">Sergipe (SE)</option>
                            <option value="4.7">São Paulo (SP)</option>
                            <option value="5.4">Tocantins (TO)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" class="form-control" id="telefone" placeholder="(xx) xxxxx-xxxx" required>
                    </div>
                    <div class="mb-3">
                        <label for="endereco" class="form-label">Endereço</label>
                        <input type="text" class="form-control" id="endereco" placeholder="Digite seu endereço" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail de contato</label>
                        <input type="email" class="form-control" id="email" placeholder="Digite seu e-mail" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="termosDeUso" required>
                        <label class="form-check-label" for="termosDeUso">Concordo com termos de uso.</label>
                    </div>
                    <button type="button" onclick="calcular()" class="btn btn-primary">Calcular</button>
                </form>

                <script>
                    function calcular() {
                        const termosDeUso = document.getElementById("termosDeUso").checked;

                        if (!termosDeUso) {
                            alert("Você deve concordar com os termos de uso para realizar o cálculo.");
                            return;
                        }

                        const kwhMes = parseFloat(document.getElementById("kwh_mes").value);
                        const hsp = parseFloat(document.getElementById("estado").value);

                        if (isNaN(kwhMes) || kwhMes <= 0 || isNaN(hsp)) {
                            document.getElementById("resultado").textContent = "valor inválido";
                            document.getElementById("area").textContent = "--";
                            document.getElementById("custo").textContent = "--";
                            document.getElementById("disclaimer").textContent = "";
                            return;
                        }

                        const potenciaPainel = 0.55; // 550W em kW
                        const eficiencia = 0.8;
                        const diasMes = 30;
                        const precoPorPainel = 1500; // Valor aproximado de um painel solar em reais
                        const areaPorPainel = 2; // Área aproximada de um painel solar em m²

                        const energiaPorPainelMes = potenciaPainel * hsp * diasMes * eficiencia;
                        const quantidadePaineis = Math.ceil(kwhMes / energiaPorPainelMes);

                        const areaTotal = quantidadePaineis * areaPorPainel;
                        const custoTotal = quantidadePaineis * precoPorPainel;

                        document.getElementById("resultado").textContent = quantidadePaineis;
                        document.getElementById("area").textContent = areaTotal.toFixed(2) + " m²";
                        document.getElementById("custo").textContent = "R$ " + custoTotal.toFixed(2);
                        document.getElementById("disclaimer").textContent = "Os valores apresentados são aproximados e podem sofrer alterações em casos concretos.";
                    }
                </script>
            </div>
        </div>
        <div class="m-4 w-50" style="background-color:#e1e1e1;">
            <div class="m-4">
                <p>Você precisa de aproximadamente: <span id="resultado">--</span> painéis de 550W</p>
                <p>Área necessária: <span id="area">--</span></p>
                <p>Custo estimado: <span id="custo">--</span></p>
                <p id="disclaimer" style="color: red; font-size: 0.9em;"></p>
            </div>
        </div>
    </div>
</main>