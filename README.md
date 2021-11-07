## CashApp | PicPay 2021

![GitHub release (latest by date)](https://img.shields.io/static/v1?label=release&message=v1.0&color=blue)
![GitHub release (latest by date)](https://img.shields.io/static/v1?label=status&message=online&color=success)

> Serviço de transações financeiras entre Usuários e Lojistas


## Instalação

Git Clone:
``` bash
HTTPS:
git clone https://github.com/andreninomiya/cash_app.git 

SSH:
git clone git@github.com:andreninomiya/cash_app.git
```

Acessar diretório:
``` bash
cd cash_app/
```

Cópia .env e alteração de valores (apenas com admin):
``` bash
cp .env.example .env
```

Criação dos Containers:
``` bash
docker compose up -d --build
```

Acesso ao Container PHP:
``` bash
docker exec -it cash_php bash
```

Alterar user:group do diretório .dbdocker:
``` bash
chown -R 1000:1000 .dbdocker/
```

Composer install:
``` bash
composer install
chown -R 1000:1000 vendor/
```

Popular base de dados:
``` bash
php artisan migrate --seed
```

Editar configurações do Nginx para direcionar requisições à `index.php`:
``` bash
nano /etc/nginx/conf.d/default.conf
```

Apagar `$uri/index.html` em:
``` bash
location / { 
    # First attempt to serve request as file, then
    # as directory, then fall back to index.php
    try_files $uri $uri/ /index.php?$query_string $uri/index.html;
}
```

Salvar configurações do Nginx:
``` bash
Ctrl + X
Y
Enter
```

Reinicar Nginx:
``` bash
/etc/init.d/nginx restart
```

## Collection no Postman

> https://drive.google.com/file/d/1sASfOrqJXuvJXtR5NCrZjIAeQM7_oWTi/view?usp=sharing
