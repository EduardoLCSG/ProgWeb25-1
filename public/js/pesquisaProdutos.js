document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('procurar-produto');
    const productsContainer = document.getElementById('produtos-container');
    let debounceTimer;

    searchInput.addEventListener('input', function () {
        const searchTerm = this.value;
        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(() => {
            productsContainer.style.opacity = '0.5';

            const categoriaId = getQueryParam('categoria_id') || 'todos';
            
            const url = `/GetProdutosByText?term=${encodeURIComponent(searchTerm)}&categoria_id=${encodeURIComponent(categoriaId)}`;
            fetch(url)
                .then(response => response.text())
                .then(html => {
                    productsContainer.innerHTML = html;
                    productsContainer.style.opacity = '1';
                })
                .catch(error => {
                    console.error('Erro na busca:', error);
                    productsContainer.innerHTML = '<p class="text-danger">Ocorreu um erro ao carregar os produtos.</p>';
                    productsContainer.style.opacity = '1';
                });
        }, 300);
    });



    function getQueryParam(param) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }
});
