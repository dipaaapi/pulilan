FROM registry.hub.docker.com/library/php:8.5-apache

RUN docker-php-ext-install mysqli pdo_mysql \
    && a2enmod rewrite

RUN printf 'mysqli.default_socket=/var/run/mysqld/mysqld.sock\npdo_mysql.default_socket=/var/run/mysqld/mysqld.sock\n' > /usr/local/etc/php/conf.d/mysql-socket.ini

RUN printf 'ServerName localhost\n' > /etc/apache2/conf-available/server-name.conf \
    && a2enconf server-name \
    && sed -i 's@/var/www/html@/var/www/html/public@g' /etc/apache2/sites-available/000-default.conf

COPY tools/apache.conf /etc/apache2/sites-available/000-default.conf

RUN printf 'expose_php=Off\nupload_max_filesize=5M\npost_max_size=8M\nsession.use_strict_mode=1\n' > /usr/local/etc/php/conf.d/app.ini

WORKDIR /var/www/html
COPY . /var/www/html
CMD ["sh", "/var/www/html/tools/docker-start.sh"]
