# Projeto_Monitor_Moedas

Aplicação Laravel para monitoramento e histórico de conversões de moedas internacionais.

## Tecnologias usadas
- Laravel (projeto atual compatível com PHP 8.3)
- MySQL
- Tailwind CSS
- Chart.js
- ExchangeRate API

## Estrutura implementada
- Autenticação com tabela `usuarios`
- Histórico de consultas em `historico_consultas`
- Camada de serviço para ExchangeRate API
- Cache de resultados por 5 minutos
- Validações com FormRequest
- Views Blade responsivas inspiradas em dashboard moderno
- Rotas protegidas por middleware `auth`
- Layout com sidebar, cards e gráficos

## Configuração inicial
1. Copie o ambiente:
   ```bash
   cp .env.example .env
   ```
2. Atualize o `.env` com as credenciais do MySQL e da API:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=projeto_monitor_moedas
   DB_USERNAME=root
   DB_PASSWORD=
   EXCHANGERATE_API_KEY=seu_token_aqui
   ```
3. Instale as dependências PHP e front-end:
   ```bash
   composer install
   npm install
   ```
4. Gere a chave da aplicação:
   ```bash
   php artisan key:generate
   ```
5. Crie o banco de dados MySQL e importe o script:
   ```bash
   mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS projeto_monitor_moedas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
   mysql -u root -p projeto_monitor_moedas < database/banco.sql
   ```

## Usuário de exemplo
- E-mail: `admin@local`
- Senha: `admin123`

## Executando a aplicação
```bash
npm run dev
php artisan serve
```

## Observações
- Não foram utilizadas migrations. O banco é criado manualmente pelo script `database/banco.sql`.
- O serviço `ExchangeRateService` faz cache de consultas por 5 minutos e registra logs de requisições.
- Use o formulário de `Consultar Moedas` para gerar consultas e popular o histórico.
