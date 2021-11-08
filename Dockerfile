# IMAGEM BASE:
FROM wyveo/nginx-php-fpm:latest

# DIRETÓRIO A SER TRABALHO NO CONTAINER:
WORKDIR /usr/share/nginx/

# REMOÇÃO DA PASTA HTML E LINK SIMBÓLICO DA PUBLICK PARA HTML:
RUN rm -rf /usr/share/nginx/src/html
RUN ln -s /usr/share/nginx/src/public html

# CÓPIA DOS ARQUIVOS DO DIRETÓRIO ATUAL PARA O CONTAINER:
COPY . /usr/share/nginx

RUN cd /usr/share/nginx/src/ && composer install
RUN chown -R 1000:1000 /usr/share/nginx/src/vendor/

RUN chmod -R 775 /usr/share/nginx/src/storage/
RUN chown -R 1000:www-data /usr/share/nginx/src/storage/

# ALTERA ARQUIVO DE CONFIGURAÇÃO DO NGINX:
RUN echo "" >> /etc/nginx/conf.d/default.conf
ADD support_files/nginx.conf /etc/nginx/conf.d/default.conf

# ALIAS BÁSICOS PARA FACILITAR A CODIFICAÇÃO:
RUN cd /root/ && echo 'alias ll="ls -lha"' >> .bashrc
