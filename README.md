# ProgWeb25-1
- Repositório para execução do trabalho para disciplina de PROGWEB 2025/1 FACOM UFMS.
## Algumas instruções de download das dependências para conseguir rodar o projeto:

### Versão do PHP 8.4
- Nessa versão, não vai precisar usar um XAMPP, WAMP, Laragon, MAMP ou similares para rodar o projeto.
- Estamos utilizando a versão 8.4.5. Windows => [VS17 x64 Thread Safe](https://windows.php.net/downloads/releases/php-8.4.5-Win32-vs17-x64.zip)

### Banco de dados Postgresql
- Estamos utilizando a versão 17.4.1 Windows => [Postgreslq](https://sbp.enterprisedb.com/getfile.jsp?fileid=1259402)
- Foi utilizado PDO para realizar a conexão de banco de dados, para isso, é importante verificar no arquivo php.ini, as entensões não estejam comentadas:
1. pdo_pgsql
2. pgsql 
- Deve ser algo como: extension={{nome_extensão}}

- Criamos um arquivo .env, para configurar a rota, usuário e senha do banco de dados.
- A estrutura, terá um dump sql do banco de dados

#### Execução do sistema, iniciar o servidor embutido:
- php -S localhost:8000 -t public public/index.php