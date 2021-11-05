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
RUN chmod -R 777 /usr/share/nginx/storage/*

## SET USUÁRIO DO CONTAINER (EVITANDO CONFLITO DE PERMISSÃO ENTRE O CONTAINER E MÁQUINA LOCAL):
#RUN useradd -u 1000 andre
#USER $user

# ALIAS BÁSICOS PARA FACILITAR A CODIFICAÇÃO:
RUN cd /root/ && echo 'alias ll="ls -lha"' >> .bashrc
RUN cd /root/ && echo 'alias la="ls -A"' >> .bashrc
RUN cd /root/ && echo 'alias l="ls -CF"' >> .bashrc
