# IMAGEM BASE:
FROM wyveo/nginx-php-fpm:latest

# DIRETÓRIO A SER TRABALHO NO CONTAINER:
WORKDIR /usr/share/nginx/

# REMOÇÃO DA PASTA HTML E LINK SIMBÓLICO DA PUBLICK PARA HTML:
RUN rm -rf /usr/share/nginx/src/html
RUN ln -s /usr/share/nginx/src/public html

# CÓPIA DOS ARQUIVOS DO DIRETÓRIO ATUAL PARA O CONTAINER:
COPY . /usr/share/nginx

# ALTERA ARQUIVO DE CONFIGURAÇÃO DO NGINX:
RUN echo "" >> /etc/nginx/conf.d/default.conf
ADD support_files/nginx.conf /etc/nginx/conf.d/default.conf

# ALIAS BÁSICOS PARA FACILITAR A CODIFICAÇÃO:
RUN cd /root/ && echo 'alias ll="ls -lha"' >> .bashrc
