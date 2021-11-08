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
cd cash_app/services/
```

Copiar .env e alteração de valores (apenas com admin):
``` bash
cp .env.example .env
```

Criar Containers:
``` bash
docker compose up -d --build
```

Acessar Container PHP:
``` bash
docker exec -it cash_php bash
```

Composer install:
``` bash
composer install
chown -R 1000:1000 /usr/share/nginx/src/vendor/
```

Alterar user:group do diretório .dbdocker:
``` bash
chown -R 1000:1000 /usr/share/nginx/.dbdocker/
```

Alterar permissão e user:group do diretório storage:
``` bash
chmod -R 775 /usr/share/nginx/src/storage/
chown -R 1000:www-data /usr/share/nginx/src/storage/
```

Reiniciar Containers (`Ctrl + P + Q` ou `New Tab`):
``` bash
docker compose restart
```

Acessar Container PHP novamente:
``` bash
docker exec -it cash_php bash
```

Popular base de dados:
``` bash
php artisan migrate --seed
```

## Collection no Postman

> https://drive.google.com/file/d/1sASfOrqJXuvJXtR5NCrZjIAeQM7_oWTi/view?usp=sharing
