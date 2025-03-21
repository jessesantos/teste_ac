# Comandos para executar o projeto

## Configuração do ambiente

1. Instalar as dependências do Composer:
```bash
composer install
```

2. Copiar o arquivo de ambiente:
```bash
cp .env.example .env
```

3. Gerar a chave da aplicação:
```bash
php artisan key:generate
```

4. Configurar o banco de dados no arquivo `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=carteira_digital
DB_USERNAME=root
DB_PASSWORD=
```

## Executar as migrações

1. Criar o banco de dados:
```bash
mysql -u root -p -e "CREATE DATABASE carteira_digital CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

2. Executar as migrações:
```bash
php artisan migrate
```

## Compilar os assets

1. Instalar as dependências do Node.js:
```bash
npm install
```

2. Compilar os assets:
```bash
npm run build
```

## Iniciar o servidor

```bash
php artisan serve
```

Acesse a aplicação em: http://localhost:8000
