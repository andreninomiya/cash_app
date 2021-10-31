FROM php:7.4-apache

# SET VARIÁVEIS PARA CRIAR USUÁRIO (EVITANDO CONFLITO DE PERMISSÃO):
ARG uid=1000
ARG user=andre

# SET APACHE ENVS:
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_PID_FILE /var/run/apache2/apache2.pid
ENV APACHE_SERVER_NAME localhost

# ATUALIZAÇÃO SISTEMA:
RUN apt-get update && apt-get upgrade -y

# INSTALAÇÃO SERVIÇOS BÁSICOS:
RUN apt-get install -y git curl wget htop vim zip unzip

# INSTALAÇÃO EXTENSÃO MYSQLI
RUN docker-php-ext-install mysqli

# LIMPAR CASH APT:
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# CONFIGURAÇÃO APACHE:
ADD ./apache.conf /etc/apache2/sites-available/apache.conf
RUN cd /etc/apache2/sites-available/ && a2ensite apache.conf
RUN a2enmod rewrite && service apache2 restart

# CRIAÇÃO DE USUÁRIO PARA RODAR COMPOSER E ARTISAN:
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && chown -R $user:$user /home/$user

# SET DIRETÓRIO E USUÁRIO DO PROJETO:
VOLUME /var/www/html
WORKDIR /var/www/html
USER $user