FROM wyveo/nginx-php-fpm:latest
WORKDIR /usr/share/nginx/
RUN rm -rf /usr/share/nginx/html
COPY . /usr/share/nginx
RUN chmod -R 777 /usr/share/nginx/storage/*
RUN ln -s public html

# BASIC ALIAS
RUN cd /root/ && echo 'alias ll="ls -lha"' >> .bashrc
RUN cd /root/ && echo 'alias la="ls -A"' >> .bashrc
RUN cd /root/ && echo 'alias l="ls -CF"' >> .bashrc
