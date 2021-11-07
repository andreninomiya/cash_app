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

Criação dos Containers:
``` bash
docker compose up -d --build
```

Acesso ao Container PHP:
``` bash
docker exec -it cash_php bash
```

Popular base de dados:
``` bash
php artisan migrate --seed
```


## Collection no Postman

> https://drive.google.com/file/d/1sASfOrqJXuvJXtR5NCrZjIAeQM7_oWTi/view?usp=sharing
