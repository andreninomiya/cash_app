FROM wyveo/nginx-php-fpm:latest
WORKDIR /usr/share/ngnix
RUN rm -rf /usr/share/ngnix/html
COPY . /usr/share/ngnix
RUN chmod -R 775 /usr/share/ngnix/storage/*
RUN ln -s public html

# BASHRC ALIAS
RUN cd /root/ && echo 'alias ll="ls -lha"' >> .bashrc
RUN cd /root/ && echo 'alias la="ls -A"' >> .bashrc
RUN cd /root/ && echo 'alias l="ls -CF"' >> .bashrc
