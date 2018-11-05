FROM php:7.2.11-apache-stretch

RUN docker-php-ext-install pdo pdo_mysql
RUN apt update && apt install -y mariadb-server mysql-client gosu

COPY --chown=root:root ./docker-entrypoint.sh /
RUN chmod u+x /docker-entrypoint.sh

ENTRYPOINT /docker-entrypoint.sh
