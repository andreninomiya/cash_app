# IMAGEM BASE:
FROM wyveo/nginx-php-fpm:latest

# DIRETÓRIO A SER TRABALHO NO CONTAINER:
WORKDIR /usr/share/nginx/

# REMOÇÃO DA PASTA HTML E LINK SIMBÓLICO DA PUBLICK PARA HTML:
RUN rm -rf /usr/share/nginx/html
RUN ln -s public html

# CÓPIA DOS ARQUIVOS DO DIRETÓRIO ATUAL PARA O CONTAINER:
COPY . /usr/share/nginx

# ALTERAÇÃO DE PERMISSÃO DA PASTA STORAGE PARA EVITAR ERRO DE ACESSO:
RUN chmod -R 775 /usr/share/nginx/storage/*

# ALIAS BÁSICOS PARA FACILITAR A CODIFICAÇÃO:
RUN cd /root/ && echo 'alias ll="ls -lha"' >> .bashrc
