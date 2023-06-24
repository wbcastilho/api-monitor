# Api-Monitor
![PHP](https://img.shields.io/badge/php-v7.4%2B-blue)
![GitHub last commit](https://img.shields.io/github/last-commit/AzeemIdrisi/PhoneSploit-Pro?logo=github)

Api que exibe os eventos capturados pelos controles de acesso. 

## :rocket: Começando

### Instalar dependências do composer
```
composer install
```

### Configurar arquivo .env
Renomear o arquivo .env.example para .env e nele colocar as configurações de acesso a sua base de dados e a configuração da pasta de uploads.
```
DB_DRIVER=pdo_mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database_exemplo
DB_USERNAME=username
DB_PASSWORD=password
DB_CHARSET=utf8mb4

DIR_UPLOADS_ACESSO=\\caminho\\para\\uploads\\acesso
```