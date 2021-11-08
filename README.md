## CashApp | PicPay 2021

![GitHub release (latest by date)](https://img.shields.io/static/v1?label=release&message=v1.0&color=blue)
![GitHub release (latest by date)](https://img.shields.io/static/v1?label=status&message=online&color=success)

<img height="120em" src="https://logodownload.org/wp-content/uploads/2018/05/picpay-logo-2.png">

> Serviço de transações financeiras entre Usuários e Lojistas


## Descrição

- **Linguagem:** PHP
- **Framework:** Lumen


## Instalação

Git Clone:
``` bash
git clone https://github.com/andreninomiya/cash_app.git
```

Acessar diretório:
``` bash
cd cash_app/src/
```

Copiar .env:
``` bash
cp .env.example .env
# Configuração de variáveis apenas com admin
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
cd /usr/share/nginx/src && composer install
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

Reiniciar Containers:
``` bash
# 'Ctrl + D' ou 'New Tab' para realizar o próximo passo
docker compose restart
```

Acessar Container PHP novamente:
``` bash
docker exec -it cash_php bash
```

Popular base de dados:
``` bash
cd /usr/share/nginx/src && php artisan migrate --seed
```

## Collection no Postman

> https://drive.google.com/file/d/1PshQxeUUoHLvDr-AHgL-YEtAtyEbZMIq/view?usp=sharing
