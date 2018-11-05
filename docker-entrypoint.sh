#!/bin/bash
set -ue
#work in progress
shutdown_mysql() {
    if [[ -S /var/run/mysqld/mysqld.sock ]]; then
        mysqladmin -u root shutdown || true
    fi
}

trap shutdown_mysql EXIT

mkdir -p /var/run/mysqld/ /var/mysql
chown -R mysql:mysql /var/run/mysqld/ /var/mysql

gosu mysql mysqld_safe --pid-file=/var/run/mysqld/mysqld.pid --socket=/var/run/mysqld/mysqld.sock --port=3306


MYSQL_PID=$(cat "/var/run/mysqld/mysqld.pid")

/usr/local/bin/docker-php-entrypoint &

PHP_PID="$!"

while ps -p "$PHP_PID" >>/dev/null && ps -p "$MYSQL_PID" >>/dev/null; do
    sleep 1
done
